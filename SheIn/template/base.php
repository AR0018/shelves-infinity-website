<!DOCTYPE html>
<html lang="it">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?php echo $templateParams["title"]; ?></title>
    <meta charset="UTF-8"/>
    <!-- Modificare la penultima cifra in fondo per rendere le icone piene o meno (0 o 1) -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $templateParams['css']; ?>"/>
</head>

<body>
    <header>
        <div class="sidebar">
            <button id="close-nav-button" class="closebutton">X</button>
            <div class="sidebar-categories">
                <h2>Categorie</h2>
                <ul><?php if (isset($templateParams["categories"])):
                    foreach($templateParams["categories"] as $category): ?>
                        <li><a href="<?php echo $paths["products"]; ?>?categoria=<?php echo rawurlencode($category["nome"]); ?>"><?php echo $category["nome"]; ?></a></li>
                    <?php endforeach; ?>
                <?php endif; ?></ul>
            </div>
            <hr class="sidebar-divider">
            <div class="sidebar-genres">
                <h2>Generi</h2>
                <ul><?php if (isset($templateParams["genres"])): 
                    foreach($templateParams["genres"] as $genre): ?>
                        <li><a href="<?php echo $paths["products"]; ?>?genere=<?php echo rawurlencode($genre["nome"]); ?>"><?php echo $genre["nome"]; ?></a></li>
                    <?php endforeach; ?>
                <?php endif; ?></ul>
            </div>
        </div>
        <div class="cnt-navigator">
            <button id="open-nav-button" class="openbutton"><span class="material-symbols-outlined">menu</span></button>
            <h1><a href="<?php echo $templateParams["index"]; ?>">SheIn</a></h1>
            <nav>
                <form action="<?php echo $paths['products']; ?>" role="search" id="search-form" method="get">
                    <label for="nome" class="visually_hidden">Cerca</label>
                    <input id="nome" type="search" name="nome" placeholder="Cerca.." autocomplete="off"/>
                    <button id="cerca" type="submit">
                        <span class="material-symbols-outlined">search</span></button>
                </form>
                <ul>
                    <li><a href="<?php echo $paths["notification"]; ?>">
                        <span class="material-symbols-outlined">notifications
                            <?php if(isset($_SESSION["USERNAME"]) and (count($dbh->getUnreadNotification($dbh->getUserID($_SESSION["USERNAME"])[0]["id"])) > 0)): ?>    
                                <span id="notification-dot" class="badge"></span>
                            <?php endif; ?>
                        </span>
                    </a></li>
                    
                    <?php if(!isset($_SESSION["USERNAME"]) || $dbh->getUserID($_SESSION["USERNAME"])[0]["id"] != 1): ?>
                        <li><a href="<?php echo $paths["shopping_cart"]; ?>">
                            <span class="material-symbols-outlined">shopping_cart</span></a></li>
                    <?php endif; ?>

                    <li><a href="<?php echo $paths["profile"]; ?>">
                        <span class="material-symbols-outlined">account_circle</span></a></li>
                    <?php if(isset($_SESSION["EMAIL"])): ?>
                        <li><a href="<?php echo $paths["logout"]; ?>">
                            <span class="material-symbols-outlined">logout</span></a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main>

        <?php if(isset($templateParams["welcome"])): ?>
        <div id="intro-image">
            <div id="intro-text">
                <h2><strong>Shelves Infinity<br/>
                    <?php if(isset($_SESSION["USERNAME"])): ?>
                    Bentornato <?php echo $_SESSION["USERNAME"]; ?>
                <?php endif; ?></strong></h2>
            </div>
        </div>
        <?php endif; ?>
        <?php
        if (isset($templateParams["name"])) {
            require $templateParams["name"];
        }
        ?>
    </main>
    <footer>
        <p>Tutti i diritti appartengono ai rispettivi proprietari.</p>
        <cite>SheIn</cite><br/>
    </footer>
    <!-- Includes every script defined by the current page -->
    <?php if(isset($templateParams["js"])):
        foreach ($templateParams["js"] as $script): ?>
    <script src="<?php echo $script; ?>"></script>
    <?php endforeach; endif; ?>
</body>
</html>