<div class="content-wrapper">
    <div class="content">
        <!-- Top Statistics -->
        <div class="row">
            <div class="card card-default">
                <div class="card-header">
                    <h2>Dodaj autora</h2>
                </div>
                <div class="card-body">
                    <form action="index.php?page=admin&param=insert_autor" method="post">
                        <input type="text" name="first_name" id="first_name" placeholder="First name">
                        <span class="hidden_err">Ime nije ok</span>
                        <input type="text" name="last_name" id="last_name" placeholder="Last name">
                        <span class="hidden_err">Prezime nije ok</span>
                        <input type="button" name="btn_add_autor" value="Dodaj" id="btn_add_autor">

                    </form>
                    <div class="error">


                    </div>
                </div>


            </div>
        </div>
    </div>
</div>