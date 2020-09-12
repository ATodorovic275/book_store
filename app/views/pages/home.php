<!-- banner part start-->
<section class="banner_part">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="banner_slider owl-carousel">
                    <div class="single_banner_slider">
                        <div class="row">
                            <div class="col-lg-5 col-md-8">
                                <div class="banner_text">
                                    <div class="banner_text_iner">

                                    </div>
                                </div>
                            </div>
                            <div class="banner_img d-none d-lg-block">
                                <img src="assets/img/banner/banner2.jpg" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="single_banner_slider">
                        <div class="row">
                            <div class="col-lg-5 col-md-8">
                                <div class="banner_text">
                                    <div class="banner_text_iner">

                                    </div>
                                </div>
                            </div>
                            <div class="banner_img d-none d-lg-block">
                                <img src="assets/img/banner/banner3.jpeg" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="single_banner_slider">
                        <div class="row">
                            <div class="col-lg-5 col-md-8">
                                <div class="banner_text">
                                    <div class="banner_text_iner">

                                    </div>
                                </div>
                            </div>
                            <div class="banner_img d-none d-lg-block">
                                <img src="assets/img/banner/banner1.jpg" alt="">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="slider-counter"></div>
            </div>
        </div>
    </div>
</section>
<!-- banner part start-->



<!-- product_list start-->
<section class="product_list section_padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="section_tittle text-center">
                    <h2>awesome <span>shop</span></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="product_list_slider owl-carousel">
                    <div class="single_product_list_slider">
                        <div class="row align-items-center ">
                            <?php
                            // var_dump($books);
                            foreach ($books as $book) : ?>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="single_product_item">
                                        <img src="assets/img/books/<?= $book->src ?>" alt="<?= $book->alt ?>">
                                        <div class="single_product_text">
                                            <h4><?= $book->title ?></h4>
                                            <h3>$<?= $book->price ?></h3>
                                            <a href="#" class="add_cart" data-id=<?= $book->id_book ?>>+ add to cart</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- product_list part start-->
