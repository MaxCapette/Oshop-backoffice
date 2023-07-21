
<div class="container my-4">
    <a href="<?= $router->generate('brand-add'); ?>" class="btn btn-success float-end">Ajouter</a>
    <h2>Liste des marques</h2>
    <table class="table table-hover mt-4">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($brandList as /* $key => */ $currentBrand) : ?>
            <tr>
                <th scope="row"><?= htmlentities($currentBrand->getId()); ?></th>
                <td><?= htmlentities($currentBrand->getName()); ?></td>
             
                <td class="text-end">
                    <a href="<?= $router->generate('brand-edit', ['id' => htmlentities($currentBrand->getId())])?>" class="btn btn-sm btn-warning">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                    <!-- Example single danger button -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-danger dropdown-toggle"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= $router->generate('brand-delete', ['id' => $currentBrand->getId()]); ?>">Oui, je veux supprimer</a>
                            <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
