<footer>
    <div class="liens">
        <div>
            <h2>Nous contacter</h2>
            <a href="/~saephp11/pageconstruction.php">Aide et contact</a>
            <a href="https://x.com/">X (Twitter)</a>
            <a href="https://instagram.com/">Instagram</a>
        </div>
        <div>
            <h2>Nos magasins</h2>
            <a href="/~saephp11/pageconstruction.php">Paris</a>
            <a href="/~saephp11/pageconstruction.php">Toulouse</a>
            <a href="/~saephp11/pageconstruction.php">Autres</a>
        </div>
        <div>
            <h2>À propos</h2>
            <a href="/~saephp11/pageconstruction.php">Plan du site</a>
            <a href="/~saephp11/pageconstruction.php">Conditions d'utilisation</a>
            <a href="/~saephp11/pageconstruction.php">Protection des données</a>
            <a href="/~saephp11/pageconstruction.php">Navigateur et cookies</a>
        </div>
    </div>
    <div class="copyright">
        <p>© 2024 Disguise'Hub. Tous droits réservés.</p>
        <a href="/~saephp11/magm.php">Réalisé par MAGM</a>
    </div>
</footer>

<script>
    var liens = document.querySelectorAll("a");
    
    for (var i = 0; i < liens.length; i++) {
        if (!liens[i].href) continue;
        if (window.location.href.includes("/~saephp11/angelo")) {
            liens[i].href = liens[i].href.replace("/~saephp11/", "/~saephp11/angelo/");
        } else if (window.location.href.includes("/~saephp11/guychel")) {
            liens[i].href = liens[i].href.replace("/~saephp11/", "/~saephp11/guychel/");
        } else if (window.location.href.includes("/~saephp11/marwan")) {
            liens[i].href = liens[i].href.replace("/~saephp11/", "/~saephp11/marwan/");
        } else if (window.location.href.includes("/~saephp11/maxence")) {
            liens[i].href = liens[i].href.replace("/~saephp11/", "/~saephp11/maxence/");
        }
    }
</script>