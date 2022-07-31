<?php
$title = 'Search';
require_once('common.php');
getBaseUrl();
require_once('../common/head.php');
require_once('../common/navbar.php'); 
require_once('validation.php');
?>
<body>
    <?php
        require_once('../db/database.php');
        if(isset($_POST['search_product']))
        {
            $search = inputValidation($_POST["search_product"]);
            $search = $conn->real_escape_string($search);

            $query = "SELECT * FROM product WHERE name LIKE ?;";
            if (!$stmt = $conn->prepare($query)) { 
                error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
                exit("Something went wrong, visit us later");
            }
    
            $search = "%".$search."%";
            if(!$stmt->bind_param('s', $search)){
                error_log("Binding failed: (" . $stmt->errno . ") " . $stmt->error);
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
                            <form method="POST" action="productPage.php">
                                <button type="submit" class="item-button" name="product_id" id="product_id" value=<?php echo $row["id"]?>>
                                    <img class="card-img-top" src=<?php echo '../'.$row["img"]?> alt=<?php echo $row["name"]?> />
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
            else
            {
                //La ricerca non ha dato risultati
                echo"<div class='wrapper'>";
                    echo "<h5>No products were found matching your selection</h5>";
                echo"</div>";
            }    
            $stmt->close();
        }
        $conn->close();
    ?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>