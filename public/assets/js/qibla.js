(function () {
    'use strict';
    var KAABA_LAT = 21.422487;
    var KAABA_LON = 39.826206;

    function toRad(d) { return d * Math.PI / 180; }
    function toDeg(r) { return r * 180 / Math.PI; }

    function computeBearing(lat1, lon1, lat2, lon2) {
        var dLon = toRad(lon2 - lon1);
        var phi1 = toRad(lat1), phi2 = toRad(lat2);
        var y = Math.sin(dLon) * Math.cos(phi2);
        var x = Math.cos(phi1) * Math.sin(phi2) - Math.sin(phi1) * Math.cos(phi2) * Math.cos(dLon);
        var brng = toDeg(Math.atan2(y, x));
        return (brng + 360) % 360;
    }

    document.addEventListener('DOMContentLoaded', function () {
        var needle = document.getElementById('needle');
        var loc    = document.getElementById('loc');
        var bear   = document.getElementById('bearing');
        var errEl  = document.getElementById('qibla-err');

        if (!('geolocation' in navigator)) {
            errEl.textContent = 'Geolocation is not supported by this browser.';
            errEl.classList.remove('hide');
            return;
        }

        navigator.geolocation.getCurrentPosition(
            function (pos) {
                var lat = pos.coords.latitude, lon = pos.coords.longitude;
                loc.textContent  = lat.toFixed(4) + '°, ' + lon.toFixed(4) + '°';
                var brng = computeBearing(lat, lon, KAABA_LAT, KAABA_LON);
                bear.textContent = brng.toFixed(1) + '° from North';
                needle.style.transform = 'rotate(' + brng + 'deg)';
            },
            function (err) {
                errEl.textContent = 'Could not access location: ' + err.message;
                errEl.classList.remove('hide');
            },
            { enableHighAccuracy: true, timeout: 10000 }
        );
    });
})();
