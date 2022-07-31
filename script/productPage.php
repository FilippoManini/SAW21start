<?php
    $title = 'Product';
    require_once('common.php');
    getBaseUrl();
    require_once('../common/head.php');
    require_once('../common/navbar.php');
    require_once('../db/database.php');
    require_once('validation.php');

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $id = inputValidation($_POST["product_id"]);
        $id = $conn->real_escape_string($id);

        $query = "SELECT * FROM product WHERE id=?;";
        if (!$stmt = $conn->prepare($query)) { 
            error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            exit("Something went wrong, visit us later");
        }

        if(!$stmt->bind_param('i', $id)){
            error_log("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
            exit("Something went wrong, visit us later");
        } 

        $res = $stmt->execute();
        if (!$res){
            error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            exit("Something went wrong, visit us later");
        }

        $data = $stmt->get_result();
        $row = $data->fetch_assoc();
        $stmt->close();
    
?>
<body>
<!-- Product section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src=<?php echo '../'.$row["img"]?> alt=<?php echo $row["name"]?> style="width:80%;"/></div>
            <div class="col-md-6">
                <h2 class="display-5 fw-bolder"><?php echo $row["name"]?></h2>
                <div class="fs-5 mb-5">
                    <span><?php echo $row["price"]?>$</span>
                </div>
                <p class="lead"><?php echo $row["description"]?></p>

                <?php
                if(isset($_SESSION['SID']))
                {
                    echo 
                    '<div class="d-flex">
                        <form class="d-flex" method="POST" action="addToCart.php">
                            <div class="row">
                                <div class="col-md-5"> 
                                    <div class="form-group"> 
                                        <input id="inputQuantity" name="inputQuantity" type="number" min="1" value="1" required/>
                                    </div> 
                                </div>
                                <div class="col-md-2"></div>
                                <div class="col-md-5"> 
                                    <div class="form-group"> 
                                        <input class="btn btn-outline-dark flex-shrink-0" id="addCart" type="submit" value="Add to cart"> 
                                    </div> 
                                </div>
                            </div>
                            <input type="hidden" id="productId" name="productId" value='.$row["id"].'>
                        </form>
                    </div>';
                }
                else
                {
                    echo '<div class="d-flex">';
                        echo '<p><strong> ⚠️ You should be logged to purchase products ⚠️</strong></p>';
                    echo '</div>';
                }
                
                ?>
            </div>
        </div>
    </div>
</section>
<?php
}
$conn->close();
?>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


