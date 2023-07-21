
<div class="container my-4">
    <a href="<?= $router->generate('type-browse'); ?>" class="btn btn-success float-end">Retour</a>
    <h2>Ajouter un type</h2>

    <form action="" method="POST" class="mt-5">
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" id="name" name="name" type="text" class="form-control" placeholder="Nom de la catégorie">
        </div>
       
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5" >Valider</button>
        </div>
    </form>
</div>
