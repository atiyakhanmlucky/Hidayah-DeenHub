    </main>
    <footer class="site-footer">
        <div class="container site-footer__inner">
            <p>
                <strong>Hidayah DeenHub</strong> · Built with ❤ for the Ummah.
            </p>
            <p class="muted">
                Prayer times powered by
                <a href="https://aladhan.com/prayer-times-api" target="_blank" rel="noopener">Aladhan API</a>.
                Hijri date from the same service. References cite Quran &amp; Sahih ahadith.
            </p>
        </div>
    </footer>
    <script src="<?= e(u('/assets/js/app.js')) ?>"></script>
    <?php if (!empty($page_scripts)): ?>
        <?php foreach ($page_scripts as $script): ?>
            <script src="<?= e(u('/assets/js/' . $script)) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
