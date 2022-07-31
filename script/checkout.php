<?php
$title = 'Checkout';
require_once('common.php');
getBaseUrl();
require_once('../common/head.php');
require_once('../common/navbar.php');
require_once('validation.php');
require_once('../db/database.php');

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['SID']))
{
    //Controllo se l'utente ha già nel carrello il prodotto ed in caso aumento solo la quantità
    $query = "DELETE FROM cart WHERE email = ?;";
    if(!$stmt = $conn->prepare($query)){
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        exit("Something went wrong, visit us later");
    }

    if(!$stmt->bind_param('s',$_SESSION['SID'])){
        error_log("Binding failed: (" . $stmt->errno . ") " . $stmt->error);
        exit("Something went wrong, visit us later");
    }

    $res = $stmt->execute();
    if(!$res){
        error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        exit("Something went wrong, visit us later");
    }
}
?>
<body>
    <div class='wrapper'>
        <h5>Thanks for your shopping</h5>
    </div>

<?php
$stmt->close();
$conn->close();
?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    </body>
</html>