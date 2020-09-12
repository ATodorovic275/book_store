<?php
ob_start();
session_start();
require_once "app/config/autoload.php";
require_once "app/config/config.php";


use app\Controllers\HomeController;
use app\Models\Database;
use app\Controllers\LoginController;
use app\Controllers\RegistrationController;
use app\Controllers\AdminHomeController;
use app\Controllers\AutorController;
use app\Controllers\BookController;
use app\Controllers\CategoryController;
use app\Controllers\ProductsController;
use app\Controllers\FetchBooks;
use app\Controllers\MainController;
use app\Controllers\OrderController;

$database = new Database(SERVER, DBNAME, USERNAME, PASSWORD);
$loginController = new LoginController($database);
$homeController = new HomeController($database);
$registrationController = new RegistrationController($database);
// $adminController = new AdminController($database);
$adminHomeController = new AdminHomeController($database);
$categoryController = new CategoryController($database);
$autorController = new AutorController($database);
$bookController = new BookController($database);
$productsController = new ProductsController($database);
$fetchBooksController = new FetchBooks($database);
$OrderController = new OrderController($database);
$mainController = new MainController();
$mainController->activityLog();

if (isset($_GET['page'])) {
    switch ($_GET["page"]) {
        case 'login':
            $loginController->pageLogin();
            break;
        case 'login_user':
            $loginController->loginUser();
            break;
        case 'logout':
            $loginController->logout();
            break;
        case 'products':
            $productsController->pageProducts();
            break;
        case 'registration':
            $registrationController->pageRegistration();
            break;
        case 'register_user':
            $registrationController->registerUser();
            break;
        case 'fetch':
            $fetchBooksController->fetchProduct();
            break;
        case 'user_id':
            $loginController->idUser();
            break;
        case 'shop_cart':
            $bookController->shopingCartBooks();
            break;
        case 'shoping_cart':
            $productsController->pageShop();
            break;
        case 'order':
            $OrderController->insertOrder();
            break;
        case 'admin':
            if (isset($_GET['param'])) {
                switch ($_GET['param']) {
                    case 'add_book':
                        $bookController->bookForm();
                        break;
                    case 'insert_book':
                        $bookController->insertBook();
                        break;
                    case 'add_category':
                        $categoryController->loadForm();
                        break;
                    case 'add_autor':
                        $autorController->loadForm();
                        break;
                    case 'insert_category':
                        $categoryController->insert();
                        break;
                    case 'categories':
                        $categoryController->categories();
                        break;
                    case 'edit_category':
                        $categoryController->editCategory();
                        break;
                    case "insert_autor":
                        $autorController->insert();
                        break;
                    case "autors":
                        $autorController->autors();
                        break;
                    case "get_one_autor":
                        $autorController->getAutor();
                        break;
                    case "edit_autor":
                        $autorController->editAutor();
                        break;
                    case "all_autors":
                        $autorController->getAutors();
                        break;
                    case "delete_autor":
                        $autorController->removeAutor();
                        break;
                    case "books":
                        $bookController->books();
                        break;
                    case "all_categories":
                        $categoryController->getCategories();
                        break;
                    case "get_one_category":
                        $categoryController->getOneCategory();
                        break;
                    case "delete_category":
                        $categoryController->removeCategory();
                        break;
                    default:
                        $adminController->loadViewAdmin("index");
                        break;
                }
            } else {
                $adminHomeController->pageAdmin();
            }
            break;
        default:
            $homeController->pageHome();
            break;
    }
} else {
    $homeController->pageHome();
}
