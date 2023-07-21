<div class="container my-4">
    <a href="<?= $router->generate('appuser-add'); ?>" class="btn btn-success float-end">Ajouter</a>
    <h2>Liste des utilisateurs</h2>
    <table class="table table-hover mt-4">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">E-mail</th>
                <th scope="col">Prénom</th>
                <th scope="col">Nom</th>
                <th scope="col">Rôle</th>
                <th scope="col">Actif</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php /** @var AppUser[] $userList */ ?>
            <?php foreach ($userList as $currentUser) : ?>
            <tr>
                <th scope="row"><?= htmlentities($currentUser->getId()); ?></th>
                <td><?= htmlentities($currentUser->getfirstname()); ?></td>
                <td><?= htmlentities($currentUser->getLastname()); ?></td>
                <td><?= htmlentities($currentUser->getEmail()); ?></td>
                <!-- <?php // todo afficher les emojis en fonction du statut  ✅ ❌ ?> -->
                <td><?= htmlentities($currentUser->getRole()); ?></td>
                <td><?= htmlentities($currentUser->getStatus()); ?></td>
             

                <td class="text-end">
                    <a href="<?= $router->generate('admin-edit', ['id' => $currentUser->getId()])?>" class="btn btn-sm btn-warning">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                    <!-- Example single danger button -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-danger dropdown-toggle"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= $router->generate('category-delete', ['id' => htmlentities($currentUser->getId())])?>">Oui, je veux supprimer</a>
                            <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

