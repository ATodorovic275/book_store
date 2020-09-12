<?php

namespace app\Controllers;

use app\Controllers\MainController;
use app\Models\Autor;
use app\Models\Category;
use app\Models\Book;

class BookController extends MainController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function bookForm()
    {
        try {
            $modelAutor = new Autor($this->db);
            $modelCategory = new Category($this->db);
            $autors = $modelAutor->getAutors();
            $categories = $modelCategory->getCategory();
            $this->loadViewAdmin("add_book", ["autors" => $autors, "categories" => $categories]);
        } catch (\PDOException $ex) {
            $this->errorLog(__FUNCTION__, $ex->getMessage());
        }
    }

    public function books()
    {

        try {
            $modelBook = new Book($this->db);
            $bookAutor = $modelBook->getBooksAutors(); //knjige sa autorima
            foreach ($bookAutor as $book) {
                $kategorije = $this->booksCategory($book->id_book);
                // var_dump($kategorije);
                $book->categories = $kategorije;
            }

            $this->loadViewAdmin("books", ["books" => $bookAutor]);
        } catch (\PDOException $ex) {
            $this->errorLog(__FUNCTION__, $ex->getMessage());
        }
    }


    public function booksCategory($idBook)
    {
        try {
            $modelBook = new Book($this->db);
            return $modelBook->getBookCategories($idBook);
        } catch (\PDOException $ex) {
            $this->errorLog(__FUNCTION__, $ex->getMessage());
        }
    }



    public function insertBook()
    {
        if (isset($_POST['btn_submit_book'])) {
            //var_dump($_FILES['image']);

            //image data
            $name = $_FILES['image']['name'];
            $type = $_FILES['image']['type'];
            $tmpName = $_FILES['image']['tmp_name'];
            $size = $_FILES['image']['size'];
            $folder = "assets/img/books/";


            //data
            $title = $_POST['title'];
            $autor = $_POST['autor'];
            $categories = $_POST['category']; // array
            $price = $_POST['price'];

            $titleReg = "/^[A-Z][a-z]+(\s[A-Za-z]+$)?/";
            $priceReg = "/^[0-9]+$/";

            // var_dump($categories);
            // echo count($categories);

            $error = [];
            $allowedFormats = ['image/jpg', "image/jpeg", "image/png"];
            define("IMAGE_SIZE", 300000);

            if (!in_array($type, $allowedFormats)) {
                array_push($error, "Dozvoljini formati slike su jpg, jpeg i png");
            }
            if ($size > IMAGE_SIZE) {
                array_push($error, "Dozvoljena velicina fajla je 3MB");
            }
            if (!preg_match($titleReg, $title)) {
                array_push($error, "Ime nije ok");
            }
            if (!preg_match($priceReg, $price)) {
                array_push($error, "Cena nije ok");
            }
            if (count($categories) == 0) {
                array_push($error, "Izaberite karegoriju");
            }
            if ($autor == 0) {
                array_push($error, "Izaberite autora");
            }




            if (count($error)) {
                $_SESSION['error'] = $error;
                $this->redirectAdmin("add_book");
            } else {
                $newImageName = time() . $name;
                $path = $folder . $newImageName;
                $alt = explode(".", $name)[0];
                // echo "</br>";
                // echo $newImageName;
                // echo "</br>";

                // echo $path;
                // echo "</br>";

                // echo $alt;

                list($width, $height) = getimagesize($tmpName);

                $temporary = null;
                switch ($type) {
                    case 'image/jpeg':
                    case "image/jpg":
                        $temporary = imagecreatefromjpeg($tmpName);
                        break;

                    case "image/png":
                        $temporary = imagecreatefrompng($tmpName);
                        break;
                }


                $newWidth = 1280;
                $newHeight = 720;
                $empty = imagecreatetruecolor($newWidth, $newHeight);

                imagecopyresampled($empty, $temporary, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);


                $save = null;

                switch ($type) {
                    case 'image/jpeg':
                    case 'image/jpg':
                        $save = imagejpeg($empty, $path);
                        break;
                    case "image/png":
                        $save = imagepng($empty, $path);
                        break;
                }

                if ($save) {
                    $marker = true;


                    try {
                        // echo "Slika je sauvana";
                        //upis u bazu
                        $modelBook = new Book($this->db);
                        $idImage = $modelBook->insertImage($newImageName, $alt); //unos slike
                        // $IdImage = $this->db->lastInsertId();
                        // echo "Response: $responseImage";
                        //cuvanje knjige
                        $idBook = $modelBook->insertBook($title, $price, $autor); //unos knjge
                        $bookRespone = $modelBook->insertBookCategory($idBook, $categories); //unos knjige i slike


                        $modelBook->insertBookImage($idBook, $idImage);
                        $this->redirectAdmin("books");
                    } catch (\PDOException $ex) {
                        $this->errorLog(__FUNCTION__, $ex->getMessage());
                    }


                    // // echo "Slika je sauvana";
                    // //upis u bazu
                    // $modelBook = new Book($this->db);
                    // $idImage = $modelBook->insertImage($newImageName, $alt); //unos slike
                    // // $IdImage = $this->db->lastInsertId();
                    // if ($idImage) {
                    //     // echo "Response: $responseImage";
                    //     //cuvanje knjige
                    //     $idBook = $modelBook->insertBook($title, $price, $autor); //unos knjge
                    //     if ($idBook) {
                    //         $bookRespone = $modelBook->insertBookCategory($idBook, $categories); //unos knjige i slike

                    //         if ($bookRespone) {

                    //             $modelBook->insertBookImage($idBook, $idImage);
                    //         } else {
                    //             $marker = false;

                    //             echo "Knjiga nije uneta";
                    //         }
                    //     } else {
                    //         $marker = false;

                    //         echo "response: knjiga nije upisana u bazu";
                    //     }
                    // } else {
                    //     $marker = false;

                    //     echo "Response: ne radi";
                    // }
                    // // echo "id: $idImage";
                    // if (!$marker) {
                    //     echo "greska...";
                    // } else {
                    //     echo "Proizvod je unet u bazu";
                    // }
                } else {
                    echo "nije sacuvana";
                }
            }
        } else {
            http_response_code(404);
        }
    }


    public function shopingCartBooks()
    {
        if (isset($_POST['idBooks'])) {

            $idBooks = $_POST['idBooks'];
            $string = [];
            for ($i = 0; $i < count($idBooks); $i++) {
                array_push($string, "?");
            }
            $string = implode(", ", $string);
            try {
                $modelBook = new Book($this->db);
                $books = $modelBook->shopBooks($string, $idBooks);
                $this->json(202, $books);
            } catch (\PDOException $ex) {
                $this->errorLog(__FUNCTION__, $ex->getMessage());
            }
        }
    }
}
