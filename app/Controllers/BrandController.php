<?php

namespace App\Controllers;

use App\Models\Brand;

class BrandController extends CoreController
{
    /**
     * Méthode s'occupant de l'affichage du formulaire d'ajout
     *
     * @return void
     */
    public function add()
    {
        // Préparer les données ( = en général les récupérer depuis la BDD )

        // On appelle la méthode show() de l'objet courant
        $this->show('brand/add');
    }
    /**
     * Méthode s'occupant de l'affichage de la liste des catégories
     *
     * @return void
     */
    public function browse()
    {
        // Préparer les données ( = en général les récupérer depuis la BDD )
        $allBrandList = Brand::findAll();
        // dd($allBrandList);

        // On appelle la méthode show() de l'objet courant
        $this->show('brand/browse', [
            'brandList' => $allBrandList
        ]);
    }
    /**
     * addExecute()
     *
     * @return void
     */
    public function addExecute(){
        $name = filter_input(INPUT_POST, 'name');
    
        
        // Pour insérer en DB, je crée d'abord une nouvelle instance du Model correspondant
        // (ici categorie pour la table categorie).
        $brand = new Brand();

        // Puis je renseigne les valeurs pour chaque propriété correspondante dans l'instance.
        $brand->setName($name); 
       


        // En dernier, j'appelle la méthode du Model permettant d'ajouter en DB.
        $brand->save();
        header('Location: ../brand');
        exit();

    }


    
    public function edit($urlParam)
    {          // On récupère l'id de la brand
        
        $brand = Brand::find($urlParam);
        
        // On appelle la méthode show() de l'objet courant
        $this->show('brand/edit', [
            'brand' => $brand,
            'id' => $urlParam
        ]);
    }


    public function editExecute($id){
        $name = filter_input(INPUT_POST, 'name');
     
       
        
        // Récupérez l'instance de la catégorie existante avec la méthode `find`
        $brand = Brand::find($id);
    

        // Puis je renseigne les valeurs pour chaque propriété correspondante dans l'instance.
        $brand->setName($name); 
        
      


        // En dernier, j'appelle la méthode du Model permettant d'ajouter en DB.
        $brand->save();

        header('Location: ../../brand');
        exit();

    }
    public function deleteBrand($id)
    {

        Brand::delete($id);
       
        // une fois le formulaire traité on redirige l'utilisateur
        $this->redirectToRoute('brand-browse');
    }
}

