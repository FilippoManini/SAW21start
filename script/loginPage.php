<?php
$title = 'Login';
require_once('common.php');
getBaseUrl();
require_once('../common/head.php');
require_once('../common/navbar.php'); 
?>
<body>
<section class="py-5 my-5">
    <div class="container">
        <div class="bg-white shadow rounded-lg d-block d-sm-flex">
            <div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                    <h1 class="mb-5">Login</h1>
                    <form method='post' action='login.php' class='profile'>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" required />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Password" required />
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="row">
                                <div class="col-md-6"> 
                                    <div class="form-group"> 
                                        <input class="btn btn-secondary"id='button_reset' type='reset' value='Cancel'> 
                                    </div> 
                                </div>
                                <div class="col-md-6"> 
                                    <div class="form-group"> 
                                        <input class="btn btn-primary" id='button_signup' type='submit' value='Signup'> 
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="signup-link">
                                    Not a member? <a href="registrationPage.php">Signup now</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>