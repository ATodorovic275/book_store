<div class="content-wrapper">
    <div class="content">
        <!-- Top Statistics -->
        <div class="row">
            <div class="card card-default">
                <div class="card-header">
                    <h2>Knjige</h2>
                </div>
                <div class="card-body">
                    <table class="scroll">
                        <tr>
                            <th>Naslov</th>
                            <th>Autor</th>
                            <th>Cena</th>
                            <th>Kategorije</th>
                            <th>Slika</th>
                        </tr>
                        <?php
                        // var_dump($books);
                        foreach ($books as $book) : ?>
                            <tr>
                                <td><?= $book->title ?></td>
                                <td><?= $book->first_name . " " . $book->last_name ?></td>
                                <td><?= $book->price ?></td>
                                <td>
                                    <?php foreach ($book->categories as $cat) : ?>
                                        <?= $cat->name . " " ?>

                                    <?php endforeach; ?>
                                </td>
                                <td><img height="50px" src="assets/img/books/<?= $book->src ?>" alt=""></td>

                                <!-- <td><a href="#" data-id=<?= $book->id_book ?>>Obrisi</a></td>
                                <td><a href="#" data-id=<?= $book->id_book ?>>Izmeni</a></td> -->
                            </tr>
                        <?php endforeach; ?>
                    </table>

                </div>

            </div>
        </div>
    </div>
</div>