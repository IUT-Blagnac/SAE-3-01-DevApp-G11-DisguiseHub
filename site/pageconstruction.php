<html>

<head>
    <title>Disguise'Hub</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/~saephp11/css/general.css">
    <link rel="stylesheet" type="text/css" href="/~saephp11/css/pageconstruction.css">
    <script type="text/javascript" src="/~saephp11/include/fontawesome.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<?php include("./include/header.php"); ?>
<body>

    <div class="Page en construction">
        <h1>Coming Soon</h1>
        <p>Nous sommes entrain de travailler sur ces pages.</p>
        <h1>STAY TUNED</h1>
        <div class="subscribe-container">
        <form id="subscribeForm" action="http://192.168.227.76/~saephp11/subscribe.php" method="post">
    <button type="submit">Subscribe</button>
</form>

<script>
    document.getElementById("subscribeForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Empêche l'envoi du formulaire par défaut
        window.location.href = this.action; // Redirige vers l'URL spécifiée dans l'action du formulaire
    });
</script>
        </div>
    </div>
    <BR><BR><BR><BR><BR><BR>


    

</body>
<?php include("./include/footer.php"); ?>
    

</html>