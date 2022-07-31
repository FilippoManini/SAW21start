<?php
    $title = 'Profile';
    require_once('common.php');
    getBaseUrl();
    require_once('../common/head.php');
    require_once('../common/navbar.php');
?>
<body>
<?php 
    if(!isset($_SESSION['SID']))
    {
        echo "<div class='wrapper'>";
            echo "<img src='../img/reservedArea/reservedArea.jpg' alt='reserved area please login' class='center'>";
        echo "</div>";
    }
    else
    {
        require_once('../db/database.php');
        $query = sprintf("SELECT * FROM user WHERE email = '%s'", $_SESSION['SID']);
        $result = $conn->query($query); 
        $row = $result->fetch_array(MYSQLI_ASSOC);
    ?>

        <section class="py-5 my-5">
            <div class="container">
                <h2 class="mb-5">Profile Settings</h2>
                <div class="bg-white shadow rounded-lg d-block d-sm-flex">
                    <div class="profile-tab-nav border-right">
                        <div class="p-4">
                            <div class="img-circle text-center mb-3">
                                <img src="../img/user.png" alt="dummy user icon" class="shadow">
                            </div>
                            <h4 class="text-center"><?php echo $row['name'].' '.$row['surname']?></h4>
                        </div>
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="account-tab" data-toggle="pill" href="#account" role="tab" aria-controls="account" aria-selected="true">
                                <i class="fa fa-home text-center mr-1"></i> 
                                Account
                            </a>
                            <a class="nav-link" id="password-tab" data-toggle="pill" href="#password" role="tab" aria-controls="password" aria-selected="false">
                                <i class="fa fa-key text-center mr-1"></i> 
                                Password
                            </a>
                        </div>
                    </div>
                    <div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                            <h3 class="mb-4">Account Settings</h3>
                            <form method='post' action='update_profile.php' class='profile' id='profile_update'>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type='text' class="form-control" id='firstname' name='firstname' placeholder='Name' value='<?php echo $row['name']?>'required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type='text' class="form-control" id='lastname' name='lastname' placeholder='Surname' value='<?php echo $row['surname']?>'required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type='email' class="form-control" id='email' name='email' placeholder='Email Address' value='<?php echo $row['email']?>'required />
                                        </div>
                                    </div>
                                    <div class="col-md-12"><div id="email_error"></div></div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone number</label>
                                            <input type='text' class="form-control" id='phone' name='phone' placeholder='+39 xxxxxxxxxx' pattern='[\+][0-9]{2}[\s][0-9]{10}' value='<?php echo $row['phone_number']?>'/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type='text' class="form-control" id='address' name='address' placeholder='Via XX Settembre' value='<?php echo $row['address']?>'/>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Bio</label>
                                            <textarea class="form-control" rows="4" id='bio' name='bio' placeholder='Add a biography'><?php echo $row['bio']?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col-md-6"> 
                                            <div class="form-group"> 
                                                <input class="btn btn-primary" id='button_update' type='submit' value='Update'> 
                                            </div> 
                                        </div>
                                        <div class="col-md-6"> 
                                            <div class="form-group"> 
                                                <input class="btn btn-secondary"id='button_reset' type='reset' value='Cancel'> 
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                            <h3 class="mb-4">Password Settings</h3>
                            <form method='post' action='update_pass.php' id='password_update'>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Old password</label>
                                            <input type="password" class="form-control" id="oldP" name="oldP" placeholder="Old Password" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>New password</label>
                                            <input type="password" class="form-control" id="newP" name="newP" placeholder="New Password" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Confirm new password</label>
                                            <input type="password" class="form-control" id="confirmP" name="confirmP" placeholder="Re-type New Password" required />
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col-md-6"> 
                                            <div class="form-group"> 
                                                <input class="btn btn-primary" id='button_updateP' type='submit' value='Update'> 
                                            </div> 
                                        </div>
                                        <div class="col-md-6"> 
                                            <div class="form-group"> 
                                                <input class="btn btn-secondary" id='button_resetP' type='reset' value='Cancel'> 
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="../js/email.js"></script>
    <script src="../js/password.js"></script>
    <script>
        //Alert for Account update
        let f_Account = document.getElementById("profile_update");
        f_Account.addEventListener("submit",function(event){
            var val = confirm("Are you sure you want to change the profile info?");
            //Se premo OK
            if(val == true)
                console.log("you pressed OK");
            else
            {
                event.preventDefault();
                window.history.back();
                console.log("you pressed Cancel");
            }
        });

        //Alert for Password update
        let f_Pass = document.getElementById("password_update");
        f_Pass.addEventListener("submit",function(event){
            var val = confirm("Are you sure you want to change the Password?");
            //Se premo OK
            if(val == true)
                console.log("you pressed OK");
            else
            {
                event.preventDefault();
                window.history.back();
                console.log("you pressed Cancel");
            }
        });

        //Check if email already exists
        let m = document.getElementById("email");
        m.addEventListener("change",function(event){ checkMail('checkEmail.php');})
    </script>
    </body>
</html>