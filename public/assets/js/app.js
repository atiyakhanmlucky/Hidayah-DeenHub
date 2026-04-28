(function () {
    'use strict';

    // Theme toggle -----------------------------------------------------------
    var root = document.documentElement;
    var toggleBtn = document.getElementById('theme-toggle');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            var next = root.dataset.theme === 'dark' ? 'light' : 'dark';
            root.dataset.theme = next;
            try { localStorage.setItem('hdh-theme', next); } catch (e) {}
        });
    }

    // Mobile nav -------------------------------------------------------------
    var navToggle = document.getElementById('nav-toggle');
    var nav = document.querySelector('.site-nav');
    if (navToggle && nav) {
        navToggle.addEventListener('click', function () {
            var open = nav.classList.toggle('open');
            navToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    }

    // Helpers exposed globally -----------------------------------------------
    var BASE = (typeof window.HDH_BASE === 'string') ? window.HDH_BASE : '';
    function u(path) {
        if (!path) return BASE;
        if (/^(https?:)?\/\//i.test(path)) return path; // already absolute
        if (path.charAt(0) !== '/') path = '/' + path;
        return BASE + path;
    }
    window.HDH = {
        url: u,
        fetchJSON: function (url, opts) {
            opts = opts || {};
            opts.headers = Object.assign({ 'Accept': 'application/json' }, opts.headers || {});
            return fetch(u(url), opts).then(function (r) {
                if (!r.ok) throw new Error('HTTP ' + r.status);
                return r.json();
            });
        },
        formatTime12: function (hhmm) {
            if (!hhmm || !/^\d{1,2}:\d{2}/.test(hhmm)) return hhmm;
            var parts = hhmm.split(':');
            var h = parseInt(parts[0], 10);
            var m = parts[1].slice(0, 2);
            var suffix = h >= 12 ? 'PM' : 'AM';
            var h12 = h % 12 || 12;
            return h12 + ':' + m + ' ' + suffix;
        }
    };
})();
