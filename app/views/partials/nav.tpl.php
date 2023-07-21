
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= $router->generate('main-home'); ?>">oShop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <?php if (isset($_SESSION['user_id'])) : ?>
                <?php if ($_SESSION['user_object']->getRole() === 'admin') : ?>
                    <li class="nav-item">
                    <a class="nav-link active" href="<?= $router->generate('appuser-browse'); ?>">Utilisateurs <span class="sr-only">(current)</span></a>
                </li>
                <?php endif; ?>
              
                <li class="nav-item">
                    <a class="nav-link" href="<?= $router->generate('category-browse'); ?>">Catégories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $router->generate('product-browse'); ?>">Produits</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $router->generate('type-browse'); ?>">Types</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $router->generate('brand-browse'); ?>">Marques</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Tags</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Sélection Accueil</a>
                </li>
               
                <li class="nav-item">
                    <a class="nav-link btn btn-danger text-light" href="<?= $router->generate('main-logout'); ?>">Déconnexion</a>
                </li>
                <li class="nav-item nav-link text-light">( <?= $_SESSION['user_object']->getEmail(); ?> ) </li>
                <?php else : ?>
                <li class="nav-item">
                    <a class="nav-link btn btn-success text-light" href="<?= $router->generate('main-login'); ?>">Connexion</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>