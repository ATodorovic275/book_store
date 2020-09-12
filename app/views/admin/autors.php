<div class="content-wrapper">
    <div class="content">
        <!-- Top Statistics -->
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-default">
                    <div class="card-header">
                        <h2>Autori</h2>
                    </div>
                    <div id="autors" class="card-body">
                        <table>
                            <tr>
                                <td>Id</td>
                                <td>Ime</td>
                                <td>Prezime</td>
                                <td>Obrisi</td>
                                <td>izmeni</td>
                            </tr>
                            <?php foreach ($autors as $autor) : ?>
                                <tr>
                                    <td><?= $autor->id_autor ?></td>
                                    <td><?= $autor->first_name ?></td>
                                    <td><?= $autor->last_name ?></td>
                                    <td><a href="#" class='delete_autor' data-id=<?= $autor->id_autor ?>>Obrisi</a></td>
                                    <td><a href="#" class="edit_autor" data-id=<?= $autor->id_autor ?>>Izmeni</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>

                    </div>

                </div>
            </div>

            <div class="col-lg-6">
                <div id="edit_form_autor" class="card card-default">

                </div>
            </div>
        </div>
    </div>
</div>