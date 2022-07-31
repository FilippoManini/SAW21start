<?php
    $title = 'Cart';
    require_once('common.php');
    getBaseUrl();
    require_once('../common/head.php');
    require_once('../common/navbar.php');
    require_once('../db/database.php');
?>
<body>
<?php
    if(!isset($_SESSION['SID']))
    {
        echo"<div class='wrapper'>";
            echo"<img src='../img/reservedArea/reservedArea.jpg' alt='reserved area please login' class='center'>";
        echo"</div>";
    }
    else
    {
        $totale = 0; //totale carrello
        $iva = 0; //totale tasse

        $query = "SELECT * FROM cart WHERE email = ?;";
        if (!$stmt = $conn->prepare($query)) { 
            error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            exit("Something went wrong, visit us later");
        }

        if(!$stmt->bind_param('s', $_SESSION['SID'])){
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

        //Se il carello ha almeno un elemento
        if($nRows > 0)
        {
            echo'
            <div class="shopping-margin">
                <h2>Shopping Cart</h2>
                <div class="shopping-cart">
                    <div class="column-labels">
                        <label class="product-image">Image</label>
                        <label class="product-details">Product</label>
                        <label class="product-price"><strong>Price</strong></label>
                        <label class="product-quantity"><strong>Quantity</strong></label>
                        <label class="product-removal">Remove</label>
                        <label class="product-line-price"><strong>Total</strong></label>
                    </div>';
            
            //per ogni prodotto presente nel carrello
            while($row = $stmt_result->fetch_assoc())
            {
                $id_product = $row['product'];
                $qta = $row['qta'];

                //Recupero il singolo prodotto
                $queryProd = "SELECT * FROM product WHERE id = ?;";
 
                if (!$stmtP = $conn->prepare($queryProd)) { 
                    error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
                    exit("Something went wrong, visit us later");
                }
        
                if(!$stmtP->bind_param('s', $id_product)){
                    error_log("Binding failed: (" . $stmtP->errno . ") " . $stmtP->error);
                    exit("Something went wrong, visit us later");
                }
    
                $resultProd = $stmtP->execute(); 
                if (!$resultProd){
                    error_log("Execute failed: (" . $stmtP->errno . ") " . $stmtP->error);
                    exit("Something went wrong, visit us later");
                }
                
                if(!$stmt_resultProd = $stmtP->get_result()){
                    error_log("Get result failed: (" . $stmtP->errno . ") " . $stmtP->error);
                    exit("Something went wrong, visit us later");
                }

                //Recupero i dati del prodotto
                $product = $stmt_resultProd->fetch_assoc();
                ?>
                    <div class="product">
                        <div class="product-image">
                            <img src=<?php echo '../'.$product['img']?> alt=<?php echo $product['name']?>>
                        </div>
                        <div class="product-details">
                            <div class="product-title"><h4><strong><?php echo $product['name']?></strong></h4></div>
                                <p class="product-description"><?php echo $product['description']?></p>
                            </div>
                            <div class="product-price"><?php echo $product['price']?></div>
                            <div class="product-quantity">
                                <p class="product-description"><?php echo $qta?></p>
                            </div>
                            <div class="product-removal">
                                <form method='post' action='removeFromCart.php'>
                                    <button type="submit" class="remove-product" name="removeButton" id="removeButton">Remove</button>
                                    <input type="hidden" id="productId" name="productId" value=<?php echo $product["id"]?>>
                                </form>
                            </div>
                            <div class="product-line-price"><?php echo $product['price']*$qta?></div>
                        </div>
                    
                    <?php
                    $totale = $totale + ($product['price']*$qta);
                    $iva = $iva + (($product['price']*$qta)*22)/100;
            }
                    ?>
                    <div class="totals">
                        <div class="totals-item">
                            <label><strong>Subtotal</strong></label>
                            <div class="totals-value" id="cart-subtotal"><?php echo $totale?></div>
                        </div>
                        <div class="totals-item">
                            <label><strong>Tax (22%)</strong></label>
                            <div class="totals-value" id="cart-tax"><?php echo round($iva,2,PHP_ROUND_HALF_UP)?></div>
                        </div>
                        <div class="totals-item totals-item-total">
                            <label><strong>Grand Total</strong></label>
                            <div class="totals-value" id="cart-total"><?php echo $totale+round($iva,2,PHP_ROUND_HALF_UP)?></div>
                        </div>
                    </div>
                    <form action="checkout.php" method="POST"> 
                        <button type="submit" class="checkout">Checkout</button> 
                    </form>
                </div>
            </div>
            <?php
        }
        else
        {
            //il carrello è vuoto, quindi nascondo tutta la parte di sopra
            echo"<div class='wrapper'>";
                echo "<h5>Cart is empty</h5>";
            echo"</div>";
        }         
    }
    $conn->close();
?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>