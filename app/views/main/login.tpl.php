<div class="container my-4">
    <h2>Connexion</h2>

    <!-- // enfin, dans la View, si le tableau n'est pas vide :
        // ajouter une div "alert" au début du formulaire
        // parcourir les messages d'erreur pour les afficher dans cette div -->
    
    <form action="" method="POST" class="mt-5">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Votre email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Votre mot de passe">
        </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>
    </form>
</div>