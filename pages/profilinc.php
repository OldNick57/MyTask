
<div class="main">
       <!-- Profile -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Profile</h2>

                            <div class="form-group">
                           <h4>Hello,&nbsp; <?php echo $_SESSION['username'] ?><h4><br />
                           <?php if($_SESSION['username'] == 'admin') {

echo 'Explore:&nbsp;&nbsp;<a href="members">Members</a>&nbsp;&nbsp;&nbsp;<a href="sessions">Sessions</a>&nbsp;&nbsp;&nbsp;<a href="failed">Failed</a>';

}

?>
                            </div>
                            <form method="POST" class="register-form" id="register-form" action="email">
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="You can change your email"/>
                            </div>
                            <div class="form-group">
                                  <div class="form-group form-button">
                                <input type="submit" name="save" id="save" class="form-submit" value="Change"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="images/kabinet.jpg" alt="sing up image"></figure>
                        <a href="logout" class="signup-image-link">Logout</a>
                    </div>
                </div>
            </div>
        </section>

    </div>
