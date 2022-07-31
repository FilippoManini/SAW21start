<?php
$title = 'Crowdfunding';
require_once('common.php');
getBaseUrl();
require_once('../common/head.php');
require_once('../common/navbar.php'); ?>
<body>
<?php
    if(!isset($_SESSION['SID']))
    {
        echo"<div class='wrapper'>";
            echo"<img src='img/reservedArea/reservedArea.jpg' alt='reserved area please login' class='center'>";
        echo"</div>";
    }
    else
    {
        $maxDonation = 100000;
        require_once('../db/database.php');

        $query = "SELECT SUM(qta) FROM donation";
        $result = $conn->query($query);
        $row = $result->fetch_array(MYSQLI_ASSOC);

        if($row['SUM(qta)'] === 'NULL')
            $row['SUM(qta)'] = 0;
        
        $perc = (floatval($row['SUM(qta)'])*100)/100000;
        //Header
        
        echo"<header class='bg-dark py-5'>";
        echo"<div class='container px-4 px-lg-5 my-5'>";
            echo"<div class='text-center text-white'>";
                echo"<h1 class='display-4 fw-bolder'>Cloud Gaming</h1>";
                    echo"<p class='lead fw-normal text-white-50 mb-0'>Play on any device, wherever you want</p>";
                echo"</div>";
            echo"</div>";
        echo"</header>";
        
        //Donation section
        echo"<section class= 'py-5'>";
            echo"<div class='container px-4 px-lg-5 my-5'>";
                echo"<div class='row gx-4 gx-lg-5 align-items-center'>";
                    echo"<div class='col-md-6'><img class='card-img-top mb-5 mb-md-0' src='".$baseURL."/img/reservedArea/cloud-games.jpg' alt='cloud gaming' width='888' height='400'/></div>";
                        echo"<div class='col-md-6'>";

                            //Se la soglia stabilita NON è stata raggiunta
                            if($perc < 100)
                            {
                                echo"<h2 class='display-5 fw-bolder'>Support our project</h2>";
                                echo"<p class='lead'> Xbox Cloud Gaming is Microsoft's streaming service that allows you to play whenever you want on consoles, smartphones and PCs. 
                                    The platform leverages Microsoft's data centers around the world. Help us expand our stock portfolio and increase the number and power of our data 
                                    centers around the world</p>";
                                echo "<p><strong>Help us reach the threshold of $100,000 to improve the quality of our service</strong></p>";
                            
                                echo"<div class='d-flex'>";
                                    echo"<form method='post' action='update_donation.php'>";
                                        echo"<input class='form-control text-center me-3' name='inputQuantity' id='inputQuantity' type='num' value='1.00' style='max-width: 100px' /><br>";
                                        echo"<button class='btn btn-outline-dark flex-shrink-0' type='submit'> Donate </button>";
                                    echo"</form>";
                                echo"</div>";
                                echo"<br>";
                            }
                            //Se la soglia stabilita è stata raggiunta
                            else
                            {
                                echo "<h2 class='display-5 fw-bolder'>Target reached,<br>thank you all for the support</h2><br>";
                            }
                            
                            echo "<div class='progress' style='height: 20px;'>";
                                echo"<div class='progress-bar progress-bar-striped bg-success' role='progressbar' style='width: ".$perc."%;' aria-valuenow='".$perc."' aria-valuemin='0' aria-valuemax='".$maxDonation."'>".round($perc, 0, PHP_ROUND_HALF_UP)."%</div>";
                            echo"</div>";

                        echo"</div>
                    </div>
                </div>
            </section>";
        $conn->close();
    }
    require_once('../common/footer.php');
?>