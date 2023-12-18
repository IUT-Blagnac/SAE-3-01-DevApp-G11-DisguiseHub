<header>
    <div class="logo">
        <div class="left">
            <a class="icon" href="/~saephp11/recherche.php">
                <i class="fa-solid fa-magnifying-glass fa-2x"></i>
            </a>
        </div>
        <a class="logo" href="/~saephp11/">
            <img src="/~saephp11/img/logo.png" alt="Disguise'Hub">
            <h1>Disguise'Hub</h1>
        </a>
        <div class="right">
            <a class="icon" href="/~saephp11/panier.php">
                <i class="fa-regular fa-cart-shopping fa-2x"></i>
            </a>
            <a class="icon" href="/~saephp11/compte">
                <i class="fa-solid fa-user fa-2x"></i>
            </a>
        </div>
    </div>
    <div class="menu">
        <?php
            $statement = "SELECT * FROM Categorie WHERE idCategoriePere IS NULL";
            require_once("connect.inc.php");

            $req = $conn -> prepare($statement);
            $req -> execute();

            while ($cat = $req -> fetch()) {
                echo "<div class='item'>
                    <a class='categorie' href='categorie.php?id=" . $cat["idCategorie"] . "'>" . $cat["nomCategorie"] . "</a>";
                    
                    $statement2 = "SELECT * FROM Categorie WHERE idCategoriePere = " . $cat["idCategorie"];
                    $req2 = $conn -> prepare($statement2);
                    $req2 -> execute();
                    
                    if($req2 && $req2->rowCount() > 0) {
                        echo "<div class='sousmenu'>";
                        while ($cat2 = $req2 -> fetch()) {
                            echo "<a class='sous-categorie' href='categorie.php?id=" . $cat2["idCategorie"] . "'>" . $cat2["nomCategorie"] . "</a>";
                        }
                        echo "</div>";
                    }

                    $req2 -> closeCursor();

                    echo "</div>";
            }
            
            $req -> closeCursor();
        ?>
    </div>
</header>
