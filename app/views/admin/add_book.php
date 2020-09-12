<div class="content-wrapper">
    <div class="content">
        <!-- Top Statistics -->
        <div class="row">
            <div class="card card-default">
                <div class="card-header">
                    <h2>Dodaj knjigu</h2>
                </div>
                <div class="card-body">
                    <form id="add_book_form" action="index.php?page=admin&param=insert_book" method="post" enctype="multipart/form-data">
                        <input type="text" name="title" id="title" placeholder="Naziv"><br>
                        <input type="text" name="price" id="price" placeholder="Cena knjige"><br>

                        <select name="autor" id="autor">
                            <option value="0">Autor</option>
                            <?php foreach ($autors as $autor) : ?>
                                <option value="<?= $autor->id_autor ?>"><?= $autor->first_name . " " . $autor->last_name ?></option>
                            <?php endforeach; ?>
                        </select><br>
                        <span id="kategorije">Kategorije</span>
                        <select name="category[]" id="category" multiple>
                            <!-- <option value="0">Kategorije</option> -->
                            <?php foreach ($categories as $cat) : ?>
                                <option value="<?= $cat->id_category ?>"><?= $cat->name ?></option>
                            <?php endforeach; ?>
                        </select><br>
                        <a href="#" id="file_btn">Dodaj sliku</a>
                        <input type="file" name="image" id="image" hidden><br>
                        <input type="submit" name="btn_submit_book" value="Dodaj">
                    </form>
                    <div class="error">
                        <?php
                        if (isset($_SESSION['error'])) {
                            // var_dump($_SESSION['error']);
                            $error =  $_SESSION['error'];
                            foreach ($error as $e) {
                                echo $e . "</br>";
                            };
                            unset($_SESSION['error']);
                        }
                        ?>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>