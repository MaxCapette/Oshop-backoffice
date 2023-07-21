<?php

namespace App\Controllers;

use App\Models\AppUser;
use App\Models\Category;
use App\Models\Product;

// Si j'ai besoin du Model Category
// use App\Models\Category;

class MainController extends CoreController
{
    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function home()
    { 
       

        // Préparer les données ( = en général les récupérer depuis la BDD )
        $lastUpdatedCategoryList = Category::findLast3();
        $lastUpdatedProductList = Product::findLast3();

        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
       
        $this->show('main/home', [
            'categoryList' => $lastUpdatedCategoryList,
            'productList' => $lastUpdatedProductList,
        ]);
    }
    /**
     * Affiche le formulaire de login
     *
     * @return void
     */
    public function login()
    {
        $this->show('main/login');
    }

    /**
     * Traite le formulaire de connexion
     *
     * @return void
     */
    public function loginExecute()
    {
        // 1. Récupérer les données
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        // dd($email, $password);
        // 2. Valider / Nettoyer les données
        // on va pouvoir chercher s'il y a un enregistrement dans la table app_user pour l'email fourni
        // Récupérer un enregistrement en utilisant l'email fourni ( findByEmail )
        // une fois l'objet récupéré, comparer le password fourni et le password de l'objet
        $userInDB = AppUser::findByEmail($email);

        $errorList = [];

        if ($userInDB === false)
        {
            $errorList[] = 'Identifiant ou mot de passe incorrect';
            $this->show('main/login', ['errorList' => $errorList]);
            die();
        }
        $passwordIsCorrect = password_verify($password, $userInDB->getPassword());
        if ($passwordIsCorrect === false)
        {
            $errorList[] = 'Identifiant ou mot de passe incorrect';
            $this->show('main/login', ['errorList' => $errorList]);
            die();
        }

        // 3. Faire le traitement ( ici authentifier l'utilisateur)
        else
        {
            // connexion de l'utilisateur
            $_SESSION['user_id'] = $userInDB->getId();
            $_SESSION['user_object'] = $userInDB;
        }
        // s'ils sont égaux => tada on affiche "ok !!!"
        // si le mot de passe est incorrect ou l'email inconnu, afficher un message d'erreur simple avec echo
        // on améliorera l'affichage des erreurs en bonus

        // 4. Redirection
        $this->redirectToRoute('main-home');
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_object']);

        $this->redirectToRoute('main-login');
    }

   
                
}
