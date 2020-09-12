 <!--================Category Product Area =================-->
 <section class="cat_product_area section_padding">
     <div class="container">
         <div class="row">
             <div class="col-lg-3">
                 <div class="left_sidebar_area">
                     <aside class="left_widgets p_filter_widgets">
                         <div class="l_w_title">
                             <h3>Kategorije</h3>
                         </div>
                         <div class="widgets_inner">
                             <ul class="list">
                                 <?php foreach ($categories as $cat) : ?>
                                     <li>
                                         <span><?= $cat->name ?></span><input type="checkbox" name="categories" id="categories" class="filter_categories" value="<?= $cat->id_category ?>">

                                         <!-- <span>(250)</span> -->
                                     </li>
                                 <?php endforeach; ?>
                             </ul>
                         </div>
                     </aside>

                     <aside class="left_widgets p_filter_widgets">
                         <div class="l_w_title">
                             <h3>Autori</h3>
                         </div>
                         <div class="widgets_inner">
                             <ul class="list">
                                 <?php foreach ($autors as $a) : ?>
                                     <li>
                                         <a href="#" data-id=<?= $a->id_autor ?> class="filter_autor"><?= $a->first_name . " " . $a->last_name ?></a>
                                     </li>
                                 <?php endforeach; ?>
                             </ul>

                         </div>
                     </aside>
                 </div>
             </div>
             <div class="col-lg-9">
                 <div class="row">
                     <div class="col-lg-12">
                         <div class="product_top_bar d-flex justify-content-between align-items-center">

                             <div class="single_product_menu d-flex">
                                 <div class="input-group">
                                     <input type="text" name="search" id="search" class="form-control" placeholder="search" aria-describedby="inputGroupPrepend">
                                     <div class="input-group-prepend">
                                         <span class="input-group-text" id="inputGroupPrepend"><i class="ti-search"></i></span>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="row align-items-center latest_product_inner">
                     <?php
                        // var_dump($books);
                        foreach ($books as $book) : ?>

                         <div class="col-lg-4 col-sm-6">
                             <div class="single_product_item">
                                 <img class="imgProd" src="assets/img/books/<?= $book->src ?>" alt="<?= $book->alt ?>">
                                 <div class="single_product_text">
                                     <h4><?= $book->title ?></h4>
                                     <h3>$<?= $book->price ?></h3>
                                     <a href="#" class="add_cart" data-id="<?= $book->id_book ?>">+ add to cart</a>
                                 </div>
                             </div>
                         </div>
                     <?php endforeach; ?>


                 </div>
             </div>
         </div>
     </div>
 </section>
 <!--================End Category Product Area =================-->
