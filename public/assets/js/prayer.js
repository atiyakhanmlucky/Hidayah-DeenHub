(function () {
    'use strict';

    var grid          = document.getElementById('prayer-grid');
    var heroDate      = document.getElementById('hero-date');
    var heroHijri     = document.getElementById('hero-hijri');
    var heroLoc       = document.getElementById('hero-location');
    var nextNameEl    = document.getElementById('next-name');
    var nextCountdown = document.getElementById('next-countdown');
    var cityEl        = document.getElementById('city');
    var countryEl     = document.getElementById('country');
    var methodEl      = document.getElementById('method');

    var ORDER = ['Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];
    var timings = null;
    var countdownTimer = null;

    function fetchTimes() {
        var params = new URLSearchParams({
            city: cityEl.value || '',
            country: countryEl.value || '',
            method: methodEl.value || '1'
        });
        HDH.fetchJSON('/api/prayer-times.php?' + params.toString())
            .then(function (data) {
                if (data.error) { alert(data.error + (data.hint ? '\n' + data.hint : '')); return; }
                timings = data.timings;
                render(data);
            })
            .catch(function () { alert('Could not load prayer times.'); });
    }

    function render(data) {
        heroDate.textContent  = data.date || '';
        heroHijri.textContent = data.hijri ? (data.hijri.date + ' ' + data.hijri.month + ' ' + data.hijri.year + ' AH') : '';
        heroLoc.textContent   = data.meta ? (data.meta.city + ', ' + data.meta.country) : '';
        try {
            localStorage.setItem('hdh-loc', JSON.stringify({
                city: data.meta.city, country: data.meta.country, method: data.meta.method
            }));
        } catch (e) {}

        var cells = grid.querySelectorAll('.prayer-cell');
        cells.forEach(function (cell) {
            var p = cell.dataset.prayer;
            var slot = cell.querySelector('[data-slot="time"]');
            slot.textContent = timings[p] ? HDH.formatTime12(timings[p]) : '—';
        });
        updateCountdown();
        if (countdownTimer) clearInterval(countdownTimer);
        countdownTimer = setInterval(updateCountdown, 1000);
    }

    function updateCountdown() {
        if (!timings) return;
        var now = new Date();
        var today = now.toISOString().slice(0, 10);
        var nextName = null, nextAt = null;
        for (var i = 0; i < ORDER.length; i++) {
            var name = ORDER[i];
            var t = (timings[name] || '').slice(0, 5);
            if (!t) continue;
            var ts = new Date(today + 'T' + t + ':00');
            if (ts > now) { nextName = name; nextAt = ts; break; }
        }
        if (!nextAt) {
            nextName = 'Fajr (tomorrow)';
            var t2 = (timings['Fajr'] || '05:00').slice(0, 5);
            var tomorrow = new Date(now); tomorrow.setDate(now.getDate() + 1);
            nextAt = new Date(tomorrow.toISOString().slice(0, 10) + 'T' + t2 + ':00');
        }
        nextNameEl.textContent = nextName;
        var diff = Math.max(0, Math.floor((nextAt - now) / 1000));
        var h = Math.floor(diff / 3600), m = Math.floor((diff % 3600) / 60), s = diff % 60;
        nextCountdown.textContent = 'in ' + pad(h) + ':' + pad(m) + ':' + pad(s);

        var cells = grid.querySelectorAll('.prayer-cell');
        cells.forEach(function (cell) {
            cell.classList.toggle('active', cell.dataset.prayer === nextName.replace(' (tomorrow)', ''));
        });
    }

    function pad(n) { return n < 10 ? '0' + n : String(n); }

    document.addEventListener('DOMContentLoaded', function () {
        try {
            var saved = JSON.parse(localStorage.getItem('hdh-loc') || 'null');
            if (saved) {
                if (saved.city)    cityEl.value = saved.city;
                if (saved.country) countryEl.value = saved.country;
                if (saved.method)  methodEl.value = saved.method;
            }
        } catch (e) {}
        document.getElementById('refresh').addEventListener('click', fetchTimes);
        [cityEl, countryEl].forEach(function (el) {
            el.addEventListener('keydown', function (e) { if (e.key === 'Enter') fetchTimes(); });
        });
        fetchTimes();
    });
})();
