<?php

// POINT D'ENTRÉE UNIQUE :
// FrontController

// inclusion des dépendances via Composer
// autoload.php permet de charger d'un coup toutes les dépendances installées avec composer
// mais aussi d'activer le chargement automatique des classes (convention PSR-4)


require_once __DIR__ . '/../vendor/autoload.php';

// on démarre la session
// cela nous permettra d'utiliser le tableau $_SESSION

session_start();
/* ------------
--- ROUTAGE ---
-------------*/


// création de l'objet router
// Cet objet va gérer les routes pour nous, et surtout il va
$router = new AltoRouter();

// le répertoire (après le nom de domaine) dans lequel on travaille est celui-ci
// Mais on pourrait travailler sans sous-répertoire
// Si il y a un sous-répertoire
if (array_key_exists('BASE_URI', $_SERVER)) {
    // Alors on définit le basePath d'AltoRouter
    $router->setBasePath($_SERVER['BASE_URI']);
    // ainsi, nos routes correspondront à l'URL, après la suite de sous-répertoire
} else { // sinon
    // On donne une valeur par défaut à $_SERVER['BASE_URI'] car c'est utilisé dans le CoreController
    $_SERVER['BASE_URI'] = '/';
}

// On doit déclarer toutes les "routes" à AltoRouter,
// afin qu'il puisse nous donner LA "route" correspondante à l'URL courante
// On appelle cela "mapper" les routes
// 1. méthode HTTP : GET ou POST (pour résumer)
// 2. La route : la portion d'URL après le basePath
// 3. Target/Cible : informations contenant
//      - le nom de la méthode à utiliser pour répondre à cette route
//      - le nom du controller contenant la méthode
// 4. Le nom de la route : pour identifier la route, on va suivre une convention
//      - "NomDuController-NomDeLaMéthode"
//      - ainsi pour la route /, méthode "home" du MainController => "main-home"

/* MAIN */

$router->map(
    'GET',
    '/',
    [
        'method' => 'home',
        'controller' => 'MainController', // On indique le FQCN de la classe
        // 'acl' => ['admin', 'catalog-manager'] on pourrait stocker les roles autorisés à cet endroit
    ],
    'main-home'
);

$router->map(
    'GET',
    '/login',
    [
        'method' => 'login',
        'controller' => 'MainController' 
    ],
    'main-login'
);

$router->map(
    'POST',
    '/login',
    [
        'method' => 'loginExecute',
        'controller' => 'MainController' 
    ],
    'main-loginExecute'
);

$router->map(
    'GET',
    '/logout',
    [
        'method' => 'logout',
        'controller' => 'MainController' 
    ],
    'main-logout'
);
/* CATEGORY */ 

$router->map(
    'GET',
    '/category', // partie qui doit correspondre avec ce qu'on a dans la barre de navigation
    [
        'method' => 'browse', // correspond au nom de la méthode dans la classe
        'controller' => 'CategoryController' 
    ],
    'category-browse' // correspond à l'identifiant utilisé dans la méthode $router->generate
);

$router->map(
    'GET',
    '/category/add',
    [
        'method' => 'add',
        'controller' => 'CategoryController'
    ],
    'category-add'
);

$router->map(
    'POST',
    '/category/add',
    [
        'method' => 'addExecute',
        'controller' => 'CategoryController'
    ],
    'category-addExecute'
);

$router->map(
    'GET',
    '/category/edit/[i:id]',
    [
        'method' => 'edit',
        'controller' => 'CategoryController'
    ],
    'category-edit'
);

$router->map(
    'POST',
    '/category/edit/[i:id]',
    [
        'method' => 'editExecute',
        'controller' => 'CategoryController',
    ],
    'category-editExecute'
);

$router->map(
    'GET',
    '/category/delete/[i:id]',
    [
        'method' => 'delete',
        'controller' => 'CategoryController'
    ],
    'category-delete'
);

/* PRODUCT */ 

$router->map(
    'GET',
    '/product',
    [
        'method' => 'browse',
        'controller' => 'ProductController'
    ],
    'product-browse'
);

$router->map(
    'GET',
    '/product/add',
    [
        'method' => 'add',
        'controller' => 'ProductController'
    ],
    'product-add'
);

$router->map(
    'POST',
    '/product/add',
    [
        'method' => 'addExecute',
        'controller' => 'ProductController'
    ],
    'product-addExecute'
);

$router->map(
    'GET',
    '/product/edit/[i:id]',
    [
        'method' => 'edit',
        'controller' => 'ProductController'
    ],
    'product-edit'
);

$router->map(
    'POST',
    '/product/edit/[i:id]',
    [
        'method' => 'editExecute',
        'controller' => 'ProductController'
    ],
    'product-editExecute'
);

/* APPUSER */ 

$router->map(
    'GET',
    '/user', // dans l'url du navigateur
    [
        'method' => 'browse', // le nom de la méthode qui va être exécutée
        'controller' => 'AppUserController' // depuis ce controleur
    ],
    'appuser-browse' // id de la route pour altorouter ( utile pour générermethod des urls dans notre code )
);

$router->map(
    'GET',
    '/user/add',
    [
        'method' => 'add',
        'controller' => 'AppUserController'
    ],
    'appuser-add'
);

$router->map(
    'POST',
    '/user/add',
    [
        'method' => 'addExecute',
        'controller' => 'AppUserController'
    ],
    'appuser-addExecute'
);

/* -------------
--- DISPATCH ---
--------------*/

// On demande à AltoRouter de trouver une route qui correspond à l'URL courante
$match = $router->match();
// dd($match);

// Ensuite, pour dispatcher le code dans la bonne méthode, du bon Controller
// On délègue à une librairie externe : https://packagist.org/packages/benoclock/alto-dispatcher
// 1er argument : la variable $match retournée par AltoRouter
// 2e argument : le "target" (controller & méthode) pour afficher la page 404
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');

// permet à altodispatcher de préfixer tous les FQCN de nos controller
$dispatcher->setControllersNamespace('App\Controllers');


// setControllerArguments permet d'envoyer des arguments aux controller instanciés.
// on en profite pour envoyer le tableau $match utilisé pour les ACL
$dispatcher->setControllersArguments($match, $router);
// Une fois le "dispatcher" configuré, on lance le dispatch qui va exécuter la méthode du controller
$dispatcher->dispatch();