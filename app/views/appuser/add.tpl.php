
<div class="container my-4">
    
    <a href="<?= $router->generate('appuser-browse'); ?>" class="btn btn-success float-end">Retour</a>
    <h2>Ajouter un utilisateur</h2>

    <form action="" method="POST" class="mt-5" novalidate>
        <input type="text" name="csrf-token" value="<?= $token; ?>" />
        <?php require __DIR__ . '/../partials/errormessage.tpl.php'; ?>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" required class="form-control" id="email" name="email" value="<?= $user->getEmail(); ?>" placeholder="E-mail">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" required class="form-control" id="password" name="password" placeholder="Mot de passe">
        </div>
        <div class="mb-3">
            <label for="firstname" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="firstname" name="firstname" value="<?= $user->getFirstname(); ?>" placeholder="Prénom">
        </div>
        <div class="mb-3">
            <label for="lastname" class="form-label">Nom</label>
            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Nom">
        </div>
        <!-- TODO Présélectionner les valeurs en cas d'erreur -->
        <div class="mb-3">
            <label for="role" class="form-label">Rôle</label>
            <select id="role" name="role" class="form-control">
                <option value="admin">Administrateur</option>
                <option value="catalog-manager">Catalog Manager</option>
            </select>
        </div>
        <!-- TODO Présélectionner les valeurs en cas d'erreur -->
        <div class="mb-3">
            <label for="status" class="form-label">Statut</label>
            <select id="status" name="status" class="form-control">
                <option value="1">Actif</option>
                <option value="2">Inactif</option>
            </select>
        </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>
    </form>
</div>