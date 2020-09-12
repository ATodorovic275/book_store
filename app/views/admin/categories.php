<div class="content-wrapper">
    <div class="content">
        <!-- Top Statistics -->
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-default">
                    <div class="card-header">
                        <h2>Categories</h2>
                    </div>
                    <div id="categories" class="card-body">
                        <table cellspacing="10">
                            <tr>
                                <td>Id</td>
                                <td>Naziv</td>
                                <td>Obrisi</td>
                                <td>izmeni</td>
                            </tr>
                            <?php
                            foreach ($categories as $cat) :
                            ?>
                                <tr>
                                    <td><?= $cat->id_category ?></td>
                                    <td><?= $cat->name ?></td>
                                    <td><a href="#" class="delete_category" data-id=<?= $cat->id_category ?>>Obrisi</a></td>
                                    <td><a href="#" class='edit_category' data-id=<?= $cat->id_category ?>>Izmeni</a></td>
                                </tr>


                            <?php endforeach; ?>
                        </table>

                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div id="edit_form_category" class="card card-default">


                </div>
            </div>

        </div>
    </div>
</div>