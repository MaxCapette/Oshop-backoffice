<?PHp
use App\Controllers\AppUserController;
use App\Controllers\MainController;
use App\Controllers\ErrorController;
use App\Controllers\BrandController;
use App\Controllers\CategoryController;
use App\Controllers\ProductController;
use App\Controllers\TypeController;
require_once __DIR__ . '/../vendor/autoload.php';
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

$router->map('GET', '/', ['home', MainController::class], 'main-home');

$router->map('GET', '/login', ['login', AppUserController::class], 'user-login');
$router->map('POST', '/login', ['loginExecute', AppUserController::class]);
$router->map('GET', '/admin', ['browse', AppUserController::class], 'admin-browse');
$router->map('GET', '/admin/add', ['add', AppUserController::class], 'admin-add');
$router->map('POST', '/admin/add', ['addExecute', AppUserController::class]);
$router->map('GET', '/admin/edit/[i:id]', ['edit', AppUserController::class], 'admin-edit');
$router->map('POST', '/admin/edit/[i:id]', ['editExecute', AppUserController::class]);
$router->map('GET', '/admin/delete/[i:id]', ['deleteAppUser', AppUserController::class], 'admin-delete');

$router->map('GET', '/category', ['browse', CategoryController::class], 'category-browse');
$router->map('GET', '/category/add', ['add', CategoryController::class], 'category-add');
$router->map('POST', '/category/add', ['addExecute', CategoryController::class], 'category-addExecute');
$router->map('GET', '/category/edit/[i:id]', ['edit', CategoryController::class], 'category-edit');
$router->map('POST', '/category/edit/[i:id]', ['editExecute', CategoryController::class], 'category-editExecute');
$router->map('GET', '/category/delete/[i:id]', ['deleteCategory', CategoryController::class], 'category-delete');

$router->map('GET', '/product', ['browse', ProductController::class], 'product-browse');
$router->map('GET', '/product/add', ['add', ProductController::class], 'product-add');
$router->map('POST', '/product/add', ['addExecute', ProductController::class], 'product-addExecute');
$router->map('GET', '/product/edit/[i:id]', ['edit', ProductController::class], 'product-edit');
$router->map('POST', '/product/edit/[i:id]', ['editExecute', ProductController::class], 'product-editExecute');
$router->map('GET', '/product/delete/[i:id]', ['deleteProduct', ProductController::class], 'product-delete');

$router->map('GET', '/brand', ['browse', BrandController::class], 'brand-browse');
$router->map('GET', '/brand/add', ['add', BrandController::class], 'brand-add');
$router->map('POST', '/brand/add', ['addExecute', BrandController::class], 'brand-addExecute');
$router->map('GET', '/brand/edit/[i:id]', ['edit', BrandController::class], 'brand-edit');
$router->map('POST', '/brand/edit/[i:id]', ['editExecute', BrandController::class], 'brand-editExecute');

$router->map('GET', '/type', ['browse', TypeController::class], 'type-browse');
$router->map('GET', '/type/add', ['add', TypeController::class], 'type-add');
$router->map('POST', '/type/add', ['addExecute', TypeController::class], 'type-addExecute');
$router->map('GET', '/type/edit/[i:id]', ['edit', TypeController::class], 'type-edit');
$router->map('POST', '/type/edit/[i:id]', ['editExecute', TypeController::class], 'type-editExecute');


//si tu veux "préremplir" une fonction dans un parent, tu peux faire ça :
// public function parentFunction() {
// parent->parent::parentFunction();
// ce que tu veux rajouter dans la fonction de la classe enfant
// }