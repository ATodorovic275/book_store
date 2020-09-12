<div class="content-wrapper">
    <div class="content">
        <!-- Top Statistics -->
        <div class="row">
            <div class="card card-default">
                <div class="card-header">
                    <h2>Dodaj kategoriju</h2>
                </div>
                <div class="card-body">
                    <form action="index.php?page=admin&param=insert_category" method="post">
                        <input type="text" name="name" id="name" placeholder="Name">
                        <span class='hidden_err'>Ime nije ok</span>
                        <?php
                        if (isset($_SESSION['error'])) {
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                        }
                        ?>
                        <input type="button" value="Dodaj" id="add_category_btn">
                    </form>
                    <div id="error">
                        <?php

                        if (isset($_SESSION['error'])) {
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                        }
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>