<?php

namespace App\Controllers;

use App\Models\Category;

class CategoryController extends CoreController
{
    /**
     * Méthode s'occupant de l'affichage du formulaire d'ajout
     *
     * @return void
     */
    public function add()
    {
      
        // On appelle la méthode show() de l'objet courant
        $this->show('category/add');
    }
 
   

    public function addExecute()
    {
        $name = filter_input(INPUT_POST, 'name');
        $subtitle = filter_input(INPUT_POST, 'subtitle');
        $picture = filter_input(INPUT_POST, 'picture');

        // Pour insérer en DB, je crée d'abord une nouvelle instance du Model correspondant
        // (ici categorie pour la table categorie).
        $category = new Category();

        // Puis je renseigne les valeurs pour chaque propriété correspondante dans l'instance.
        $category->setName($name);
        $category->setSubtitle($subtitle);
        $category->setPicture($picture);


        // En dernier, j'appelle la méthode du Model permettant d'ajouter en DB.
        $category->save();
        
        // une fois le formulaire traité on redirige l'utilisateur
        $this->redirectToRoute('category-browse');
    }
       /**
     * Méthode s'occupant de l'affichage de la liste des catégories
     *
     * @return void
     */
    public function browse()
    {
        // Préparer les données ( = en général les récupérer depuis la BDD )
        $allCategoryList = Category::findAll();
        // dd($allCategoryList);

        // On appelle la méthode show() de l'objet courant
        $this->show('category/browse', [
            'categoryList' => $allCategoryList
        ]);
    }



    public function edit($id)
    {          // On récupère l'id de la category

        $category = Category::find($id);

        // On appelle la méthode show() de l'objet courant
        $this->show('category/edit', [
            'category' => $category,
            'id' => $id
        ]);
    }


    public function editExecute(int $id)
    {
        $name = filter_input(INPUT_POST, 'name');
        $subtitle = filter_input(INPUT_POST, 'subtitle');
        $picture = filter_input(INPUT_POST, 'picture');
        $home_order = filter_input(INPUT_POST, 'home_order');

        // valider / nettoyer les données
        if (strlen($name) === 0) {
            die('Nom manquant');
        }
        if ($picture === false) {
            die('L\'image doit etre une url complète');
        }
        // Récupérez l'instance de la catégorie existante avec la méthode `find`
        $category = Category::find($id);


        // Puis je renseigne les valeurs pour chaque propriété correspondante dans l'instance.
        $category->setName($name);
        $category->setSubtitle($subtitle);
        $category->setPicture($picture);
        $category->setHomeOrder($home_order);



        // En dernier, j'appelle la méthode du Model permettant d'ajouter en DB.
        $category->save();
  // une fois le formulaire traité on redirige l'utilisateur
  $this->redirectToRoute('category-browse');
     
    }

    public function delete($id)
    {

        Category::delete($id);
       
        // une fois le formulaire traité on redirige l'utilisateur
        $this->redirectToRoute('category-browse');
    }
}
