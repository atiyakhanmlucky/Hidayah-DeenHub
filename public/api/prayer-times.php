<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';

header('Content-Type: application/json; charset=utf-8');

$city    = trim((string)($_GET['city']    ?? ''));
$country = trim((string)($_GET['country'] ?? ''));
$method  = (string)($_GET['method']  ?? DEFAULT_METHOD);

if ($city === '' || $country === '') {
    $user = current_user();
    if ($user && !empty($user['city']))    { $city    = $city    ?: $user['city']; }
    if ($user && !empty($user['country'])) { $country = $country ?: $user['country']; }
    $city    = $city    ?: DEFAULT_CITY;
    $country = $country ?: DEFAULT_COUNTRY;
}

$date = date('d-m-Y');
$cacheKey = strtolower($city . '|' . $country . '|' . $method . '|' . $date);

try {
    $pdo = db();

    // Try cache
    $stmt = $pdo->prepare('SELECT payload FROM prayer_cache WHERE cache_key = ? AND expires_at > NOW()');
    $stmt->execute([$cacheKey]);
    $hit = $stmt->fetchColumn();
    if ($hit) {
        echo $hit;
        exit;
    }

    // Fetch from Aladhan
    $url = 'https://api.aladhan.com/v1/timingsByCity/' . $date
        . '?city=' . urlencode($city)
        . '&country=' . urlencode($country)
        . '&method=' . urlencode($method);

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 8,
        CURLOPT_USERAGENT      => 'HidayahDeenHub/1.0',
    ]);
    $raw = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);

    if (!$raw || $status !== 200) {
        throw new RuntimeException('Upstream API error');
    }

    $decoded = json_decode($raw, true);
    if (!isset($decoded['data']['timings'])) {
        throw new RuntimeException('Invalid upstream response');
    }

    $payload = [
        'timings' => $decoded['data']['timings'],
        'date'    => $decoded['data']['date']['readable'] ?? $date,
        'hijri'   => [
            'date'   => $decoded['data']['date']['hijri']['day']   ?? '',
            'month'  => $decoded['data']['date']['hijri']['month']['en'] ?? '',
            'year'   => $decoded['data']['date']['hijri']['year']  ?? '',
            'weekday'=> $decoded['data']['date']['hijri']['weekday']['en'] ?? '',
        ],
        'meta'    => ['city' => $city, 'country' => $country, 'method' => $method],
        'cached'  => false,
    ];

    $json = json_encode($payload);

    $ins = $pdo->prepare('INSERT INTO prayer_cache (cache_key, payload, expires_at)
                           VALUES (?, ?, DATE_ADD(NOW(), INTERVAL ? SECOND))
                           ON DUPLICATE KEY UPDATE payload = VALUES(payload), expires_at = VALUES(expires_at)');
    $ins->execute([$cacheKey, $json, PRAYER_CACHE_TTL]);

    echo $json;
} catch (Throwable $e) {
    http_response_code(502);
    echo json_encode([
        'error' => APP_DEBUG ? $e->getMessage() : 'Could not fetch prayer times.',
        'hint'  => 'Please check the city/country spelling or try again later.',
    ]);
}
