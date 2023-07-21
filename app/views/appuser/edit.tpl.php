

<div class="container my-4">
    <a href="<?= $router->generate('admin-browse'); ?>" class="btn btn-success float-end">Retour</a>
    <h2>Modifier un utilisateur</h2>

    <form action="" method="POST" class="mt-5">
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input value="<?= $user->getFirstName() ?>" type="text" id="name" name="firstName" type="text" class="form-control" placeholder="Nom">
        </div>
        <div class="mb-3">
            <label for="subtitle" class="form-label">Prénom</label>
            <input value="<?= $user->getLastName() ?>" type="text" class="form-control" id="subtitle" name="LastName"placeholder="Prénom" aria-describedby="subtitleHelpBlock">
        </div>
        <div class="mb-3">
            <label for="picture" class="form-label">mail</label>
            <input value="<?= $user->getEmail() ?>" type="text" class="form-control" id="picture" name="email" placeholder="email" aria-describedby="pictureHelpBlock">
        </div>
        <div class="mb-3">
            <label for="picture" class="form-label">password</label>
            <input value="<?= $user->getPassword() ?>" type="text" class="form-control" id="picture" name="password" placeholder="mot de passe" aria-describedby="pictureHelpBlock">
        </div>
        <div class="mb-3">
            <label for="picture" class="form-label">role</label>
            <input value="<?= $user->getRole() ?>" type="text" class="form-control" id="picture" name="role" placeholder="role" aria-describedby="pictureHelpBlock">
        </div>
        <div class="mb-3">
            <label for="picture" class="form-label">status</label>
            <input value="<?= $user->getStatus() ?>" type="text" class="form-control" id="picture" name="status" placeholder="status" aria-describedby="pictureHelpBlock">
        </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5" >Valider</button>
        </div>
    </form>
</div>