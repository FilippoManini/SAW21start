<?php
session_start();
require_once('common.php');
require_once('validation.php');
require_once('../db/database.php');

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['SID']))
{
    $qta = inputValidation($_POST["inputQuantity"]);
    $qta = $conn->real_escape_string($qta);
    $productId = $_POST["productId"];

    //Controllo se l'utente ha già nel carrello il prodotto ed in caso aumento solo la quantità
    $query = "SELECT * FROM cart WHERE email = ? AND product = ?";
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
    $nRow = $stmt->get_result()->num_rows;
    $stmt->close();

    if($nRow === 1)
    {
        //Significa che ha tornato una tupla e che quindi il prodotto è già nel carrello
        $query = "UPDATE cart SET qta = qta+? WHERE email=? AND product=?;";
        if(!$stmt = $conn->prepare($query)){
            error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            exit("Something went wrong, visit us later");
        }

        if(!$stmt->bind_param('isi', $qta, $_SESSION['SID'], $productId)){
            error_log("Binding failed: (" . $stmt->errno . ") " . $stmt->error);
            exit("Something went wrong, visit us later");
        }

        $res = $stmt->execute();
        if(!$res){
            error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            exit("Something went wrong, visit us later");
        }
        $stmt->close();
    }
    else if($nRow === 0)
    {
        //Il prodotto non è presente nel carrello dell'utente, quindi lo aggiungo
        $query = "INSERT INTO cart (product, qta, email) VALUES (?,?,?)";
        if(!$stmt = $conn->prepare($query)){
            error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            exit("Something went wrong, visit us later");
        }

        if(!$stmt->bind_param('iis', $productId, $qta, $_SESSION['SID'])){
            error_log("Binding failed: (" . $stmt->errno . ") " . $stmt->error);
            exit("Something went wrong, visit us later");
        }

        $res = $stmt->execute();
        if(!$res){
            error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            exit("Something went wrong, visit us later");
        }
        $stmt->close();
    }
    $conn->close();
    redirect("../index.php");
}
?>