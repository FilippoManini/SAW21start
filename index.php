<?php
$title = 'Ultimate Cloud';
require_once('script/common.php');
getBaseUrl();
require_once('common/head.php');
require_once('common/navbar.php');
?>
<body>
    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Choose the plan that's right for you</h1>
                <p class="lead fw-normal text-white-50 mb-0">Do you prefer to play on PC? Are you a console devotee? There is a subscription plan that's right for you<br>Or get all the content plus the ability to play games via the cloud</p>
            </div>
        </div>
    </header>

    <?php 
        require_once('db/database.php'); 
        $query = "SELECT * FROM product LIMIT 8;";
        
        if (!$stmt = $conn->prepare($query)) { 
            error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            exit("Something went wrong, visit us later");
        }

        $res = $stmt->execute(); 
        if (!$res){
            error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            exit("Something went wrong, visit us later");
        }
        
        if(!$stmt_result = $stmt->get_result()){
            error_log("Get result failed: (" . $stmt->errno . ") " . $stmt->error);
            exit("Something went wrong, visit us later");
        }
        $nRows = $stmt_result->num_rows;

        if($nRows > 0)
        {
            echo'<section class="py-5">';
                echo '<div class="container px-4 px-lg-5 mt-5">';
                    echo '<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">';
        
            while( $row = $stmt_result->fetch_assoc())
            {
                ?>
                <!--Product-->
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                        <form method="POST" action="script/productPage.php">
                            <button type="submit" class="item-button" name="product_id" id="product_id" value=<?php echo $row["id"]?>>
                                <img class="card-img-top" src=<?php echo $row["img"]?> alt=<?php echo $row["name"]?> />
                            </button>
                        </form>
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder"><?php echo $row["name"]?></h5>
                                <!-- Product price-->
                                <strong> <?php echo $row["price"]?>$</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
            }
                    echo '</div>';
                echo '</div>';
            echo '</section>';
        }
        $stmt->close();
        $conn->close();
    ?>

<?php require_once('common/footer.php');?>