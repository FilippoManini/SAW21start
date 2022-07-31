<?php
$title = 'Signup';
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
                    <h1 class="mb-5">Signup</h1>
                    <form method='post' action='registration.php'>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" required />
                                </div>
                            </div>
                            <div class="col-md-12"><div id="email_error"></div></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Password" pattern="^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])([^\s]){8,16}$" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" class="form-control" id="confirm" name="confirm" placeholder="Re-type Password" pattern="^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])([^\s]){8,16}$" required />
                                </div>
                            </div>
                            <div class="col-md-12"><div id="confirm_error"></div></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Name" required/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Surname" required />
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
                    </form>

                    <div id="message">
                        <p><strong>Password must contain the following:</strong></p>
                        <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                        <p id="capital" class="invalid">A <b>capital</b> letter</p>
                        <p id="number" class="invalid">A <b>number</b></p>
                        <p id="length" class="invalid"><b>8-16 characters</b></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Bootstrap core JS-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/email.js"></script>
    <script src="../js/password.js"></script>
    <script>
        //Check if email already exists
        let m = document.getElementById("email");
        m.addEventListener("change",function(event){ checkMail('checkEmail.php');})

        //check password strenght
        let p = document.getElementById("pass");
        p.addEventListener("keyup", function(event){ startType();})
        p.addEventListener("focus", function(event){ boxOn();})
        p.addEventListener("blur", function(event){ boxOff();})
        
        //Check password and confirm 
        let c = document.getElementById("confirm");
        c.addEventListener("input", function(event) { checkEqual();})
    </script>
    </body>
</html>