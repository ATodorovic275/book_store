 <!-- breadcrumb start-->
 <section class="breadcrumb breadcrumb_bg">
     <div class="container">
         <div class="row justify-content-center">
             <div class="col-lg-8">
                 <div class="breadcrumb_iner">
                     <div class="breadcrumb_iner_item">
                         <h2>Log in</h2>
                         <p>Home <span>-</span> Log in</p>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </section>
 <!-- breadcrumb start-->

 <!--================login_part Area =================-->
 <section class="login_part padding_top">
     <div class="container">
         <div class="row align-items-center">
             <div class="col-lg-6 col-md-6">
                 <div class="login_part_text text-center">
                     <div class="login_part_text_iner">
                         <h2>New to our Shop?</h2>
                         <p>There are advances being made in science and technology
                             everyday, and a good example of this is the</p>
                         <a href="index.php?page=registration" class="btn_3">Create an Account</a>
                     </div>
                 </div>
             </div>
             <div class="col-lg-6 col-md-6">
                 <div class="login_part_form">
                     <div class="login_part_form_iner">
                         <h3>Welcome Back ! <br>
                             Please Sign in now</h3>
                         <?php
                            // if (isset($_SESSION['error'])) {
                            //     // var_dump($_SESSION['error']);
                            //     echo "<h3>" . $_SESSION['error'] . "</h3>";
                            //     unset($_SESSION['error']);
                            // }
                            ?>
                         <div id="login_error">

                         </div>
                         <form class="row contact_form" action="index.php?page=login_user" method="post">
                             <div class="col-md-12 form-group p_star">
                                 <input type="text" class="form-control" id="username" name="username" value="" placeholder="Username">
                                 <span class='hidden_err'>Username is not good</span>
                             </div>
                             <div class="col-md-12 form-group p_star">
                                 <input type="password" class="form-control" id="password" name="password" value="" placeholder="Password">
                                 <span class='hidden_err'>Password is not good</span>

                             </div>
                             <div class="col-md-12 form-group">
                                 <div class="creat_account d-flex align-items-center">
                                     <input type="checkbox" id="f-option" name="selector">
                                     <label for="f-option">Remember me</label>
                                 </div>

                                 <input type="button" id="btn_log" name='login_button' value="submit" class="btn_3">
                                 <a class="lost_pass" href="#">forget password?</a>
                             </div>
                         </form>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </section>
 <!--================login_part end =================-->