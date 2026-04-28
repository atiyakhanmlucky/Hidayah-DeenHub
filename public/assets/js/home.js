(function () {
    'use strict';

    function loadTip() {
        HDH.fetchJSON('/api/tip.php')
            .then(function (data) {
                if (!data || !data.tip) return;
                var t = data.tip;
                document.getElementById('tip-category').textContent = t.category || 'tip';
                document.getElementById('tip-title').textContent = t.title;
                document.getElementById('tip-body').textContent = t.body;
                var ref = document.getElementById('tip-ref');
                ref.textContent = t.reference ? 'Source: ' + t.reference : '';
            })
            .catch(function () {
                document.getElementById('tip-title').textContent = 'Keep doing good deeds.';
                document.getElementById('tip-body').textContent = 'Could not load a reminder right now — but the best reminder is the one you act on today.';
            });
    }

    function loadPrayerSummary() {
        HDH.fetchJSON('/api/prayer-times.php')
            .then(function (data) {
                if (!data || !data.timings) return;
                var timings = data.timings;
                var order = ['Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];
                var now = new Date();
                var todayStr = now.toISOString().slice(0, 10);
                var nextName = null;
                var nextTime = null;
                for (var i = 0; i < order.length; i++) {
                    var key = order[i];
                    var t = timings[key];
                    if (!t) continue;
                    var candidate = new Date(todayStr + 'T' + t.slice(0, 5) + ':00');
                    if (candidate > now) { nextName = key; nextTime = candidate; break; }
                }
                if (!nextName) { nextName = 'Fajr (tomorrow)'; }
                var statNext = document.getElementById('stat-next');
                if (statNext) {
                    statNext.textContent = nextName + (nextTime ? ' · ' + HDH.formatTime12(timings[nextName]) : '');
                }
                var statHijri = document.getElementById('stat-hijri');
                if (statHijri && data.hijri) { statHijri.textContent = data.hijri.date + ' ' + data.hijri.month + ', ' + data.hijri.year + ' AH'; }
                var statCity = document.getElementById('stat-city');
                if (statCity && data.meta) { statCity.textContent = data.meta.city + ', ' + data.meta.country; }
            })
            .catch(function () { /* silent */ });
    }

    document.addEventListener('DOMContentLoaded', function () {
        loadTip();
        loadPrayerSummary();
        var btn = document.getElementById('new-tip');
        if (btn) btn.addEventListener('click', loadTip);
    });
})();
