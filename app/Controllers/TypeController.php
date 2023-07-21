<?php

namespace App\Controllers;

use App\Models\Type;

class TypeController extends CoreController
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
        $this->show('type/add');
    }
    /**
     * Méthode s'occupant de l'affichage de la liste des catégories
     *
     * @return void
     */
    public function browse()
    {
        // Préparer les données ( = en général les récupérer depuis la BDD )
        $allTypeList = Type::findAll();
        // dd($allTypeList);

        // On appelle la méthode show() de l'objet courant
        $this->show('type/browse', [
            'typeList' => $allTypeList
        ]);
    }

    public function addExecute(){
        $name = filter_input(INPUT_POST, 'name');
      
        
        // Pour insérer en DB, je crée d'abord une nouvelle instance du Model correspondant
        // (ici categorie pour la table categorie).
        $type = new Type();

        // Puis je renseigne les valeurs pour chaque propriété correspondante dans l'instance.
        $type->setName($name); 
    


        // En dernier, j'appelle la méthode du Model permettant d'ajouter en DB.
        $type->save();
        header('Location: ../type');
        exit();

    }


    
    public function edit($urlParam)
    {          // On récupère l'id de la type
        
        $type = Type::find($urlParam);
        
        // On appelle la méthode show() de l'objet courant
        $this->show('type/edit', [
            'type' => $type,
            'id' => $urlParam
        ]);
    }


    public function editExecute($id){
        $name = filter_input(INPUT_POST, 'name');
    
       
        
        // Récupérez l'instance de la catégorie existante avec la méthode `find`
        $type = Type::find($id);
    

        // Puis je renseigne les valeurs pour chaque propriété correspondante dans l'instance.
        $type->setName($name); 
      
      


        // En dernier, j'appelle la méthode du Model permettant d'ajouter en DB.
        $type->save();

        header('Location: ../../type');
        exit();

    }
}
