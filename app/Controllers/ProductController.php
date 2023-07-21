<?php

namespace App\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Type;

class ProductController extends CoreController
{
    /**
     * Méthode s'occupant de l'affichage du formulaire d'ajout
     *
     * @return void
     */
    public function add()
    {
        $this->checkAuthorization(['admin', 'catalog-manager']);
        $allCategoryList = Category::findAll();
        $allBrandList = Brand::findAll();
        $allTypeList = Type::findAll();

        // TODO dynamiser les listes de catégorie, marque et type
        // On appelle la méthode show() de l'objet courant
        $this->show('product/add', [
            'allCategoryList' => $allCategoryList,
            'allBrandList' => $allBrandList,
            'allTypeList' => $allTypeList,
        ]);
    }




public function addExecute(){
    $name = filter_input(INPUT_POST, 'name');
    $description = filter_input(INPUT_POST, 'description');
    $picture = filter_input(INPUT_POST, 'picture', FILTER_VALIDATE_URL);
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    $rate = filter_input(INPUT_POST, 'rate', FILTER_VALIDATE_INT);
    $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
    $categoryId = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
    $brandId = filter_input(INPUT_POST, 'brand_id', FILTER_VALIDATE_INT);
    $typeId = filter_input(INPUT_POST, 'type_id', FILTER_VALIDATE_INT);
        
    // Pour insérer en DB, je crée d'abord une nouvelle instance du Model correspondant
    // (ici product pour la table product).
    $product = new Product();

    // Puis je renseigne les valeurs pour chaque propriété correspondante dans l'instance.
    $product->setName($name); 
    $product->setDescription($description);
    $product->setPicture($picture);
    $product->setPrice($price);
    $product->setRate($rate);
    $product->setStatus($status);
    $product->setBrandId($brandId);
    $product->setCategoryId($categoryId);
    $product->setTypeId($typeId);


    // on lance la requête d'insertion
    // si une erreur est survenue, on ne fait pas de redirection 
    // pour que l'on puisse avoir le message d'erreur
    if (! $product->insert())
    {
        die();
    }

   
   
  
    // une fois le formulaire traité on redirige l'utilisateur
    $this->redirectToRoute('product-browse');

}

/**
 * Méthode s'occupant de l'affichage de la liste 
 *
 * @return void
 */
public function browse()
{
    // Préparer les données ( = en général les récupérer depuis la BDD )
    $allProductList = Product::findAll();

    // On appelle la méthode show() de l'objet courant
    $this->show('product/browse', [
        'productList' => $allProductList,
    ]);
}

public function edit($id)
{          // On récupère l'id de la product
    
    $product = Product::find($id);
    $allCategoryList = Category::findAll();
    $allBrandList = Brand::findAll();
    $allTypeList = Type::findAll();

    
    // On appelle la méthode show() de l'objet courant
    $this->show('product/edit', [
        'product' => $product,
        'allCategoryList' => $allCategoryList,
        'allBrandList' => $allBrandList,
        'allTypeList' => $allTypeList,
    ]);
}


public function editExecute($id){
// Récupération des données du formulaire
$name = filter_input(INPUT_POST, 'name');
$description = filter_input(INPUT_POST, 'description');
$picture = filter_input(INPUT_POST, 'picture', FILTER_VALIDATE_URL);
$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
$rate = filter_input(INPUT_POST, 'rate', FILTER_VALIDATE_INT);
$status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
$categoryId = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
$brandId = filter_input(INPUT_POST, 'brand_id', FILTER_VALIDATE_INT);
$typeId = filter_input(INPUT_POST, 'type_id', FILTER_VALIDATE_INT);
    
    // Récupérez l'instance de la catégorie existante avec la méthode `find`
    $product = Product::find($id);


    // Puis je renseigne les valeurs pour chaque propriété correspondante dans l'instance.
    $product->setName($name); 
    $product->setDescription($description);
    $product->setPicture($picture);
    $product->setPrice($price);
    $product->setRate($rate);
    $product->setStatus($status);
    $product->setBrandId($brandId);
    $product->setCategoryId($categoryId);
    $product->setTypeId($typeId);
  

 // on lance la requête d'insertion
        // si une erreur est survenue, on ne fait pas de redirection 
        // pour que l'on puisse avoir le message d'erreur
        $product->save() ? null : die();
        // if (! $product->save())
        // {
        //     die();
        // }
    // En dernier, j'appelle la méthode du Model permettant d'ajouter en DB.
    ;

  
   // une fois le formulaire traité on redirige l'utilisateur
   $this->redirectToRoute('product-browse');

}
}