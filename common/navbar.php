<!-- Navigation-->
<?php session_start();?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href=<?php echo $baseURL.'/index.php'?>><img src=<?php echo $baseURL.'/img/ico.png'?> width="60" height="60" alt="Ultimate Cloud logo"/></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href=<?php echo $baseURL.'/index.php'?>>Home</a></li>
                <?php
                    if(!isset($_SESSION['SID'])) //session_id() == '' ||  || session_status() === PHP_SESSION_NONE
                    {
                        echo '<li class="nav-item"><a class="nav-link" href="'.$baseURL.'/script/registrationPage.php">Signup</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="'.$baseURL.'/script/loginPage.php">Login</a></li>';
                    }
                    else
                    {
                        echo '<li class="nav-item"><a class="nav-link" href="'.$baseURL.'/script/crowdfunding.php">Donate</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="'.$baseURL.'/script/show_profile.php">Profile</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="'.$baseURL.'/script/logout.php">Logout</a></li>';
                    }
                ?>
            </ul>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item">
                    <form method="post" action=<?php echo $baseURL.'/script/searchPage.php'?> class="search">
                        <input type="text" placeholder="Search.." name="search_product" required>
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </li>
            </ul>
            <?php
                if(isset($_SESSION['SID']))
                {
                    echo '<form class="d-flex" action="'.$baseURL.'/script/shopping_cart.php">';
                        echo '<button class="btn btn-outline-dark" type="submit">';
                            echo '<i class="bi-cart-fill me-1"></i>';
                                echo 'Cart';
                        echo '</button>';
                    echo '</form>';
                }
            ?>
        </div>
    </div>
</nav>