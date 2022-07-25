<div class="main">
        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="images/signin-image.jpg" alt="sing up image"></figure>
<?php

  if(isset($_SESSION['chmail'])) echo '<h3>Your new email is accepted.</h3>';


  if(isset($_SESSION['confirmed'])) {

  echo '<h3>Congratulations!</h3><h3>Your account is created.</h3>';

  unset($_SESSION['repeat']);

  } else {

  echo '<a href="register" class="signup-image-link">Create an account</a>';

  }



 ?>





                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Login</h2>
                        <form method="POST" class="register-form" id="login-form" action="profile">
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="your_name" id="your_name"

     <?php if(isset($_COOKIE['member_login'])) {
  	 $member_login = $_COOKIE['member_login'];
     echo 'value=" ' . $member_login . '"';
     } else {
     echo 'placeholder="Your Name"';
     } ?> />

                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="your_pass" id="your_pass"

    <?php if(isset($_COOKIE['memberpassword'])) {
  	 $userpassword = $_COOKIE['memberpassword'];
     echo 'value=" ' . $userpassword . '"';
     } else {
     echo 'placeholder="Your password"';
     } ?> />
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                                <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                            </div>
                        </form>
                            <div class="form-group"><br />
                                <b><i><a href="about">About this project</a></i></b>
                            </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
