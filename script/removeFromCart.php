<?php
session_start();
require_once('common.php');
require_once('validation.php');
require_once('../db/database.php');

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['SID']))
{
    $productId = $_POST["productId"];

    $query = "DELETE FROM cart WHERE email = ? AND product = ?;";
    if(!$stmt = $conn->prepare($query)){
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        exit("Something went wrong, visit us later");
    }

    if(!$stmt->bind_param('si',$_SESSION['SID'],$productId)){
        error_log("Binding failed: (" . $stmt->errno . ") " . $stmt->error);
        exit("Something went wrong, visit us later");
    }

    $res = $stmt->execute();
    if(!$res){
        error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        exit("Something went wrong, visit us later");
    }
    $stmt->close();
    $conn->close();
    redirect("shopping_cart.php");
}
?>