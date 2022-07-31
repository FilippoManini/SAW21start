<?php
session_start();
require_once('validation.php');
require_once('common.php');

if(isset($_SESSION['SID']))
{
    $maxDonation = 100000;
    $donation = inputValidation($_POST["inputQuantity"]);

    require_once('../db/database.php');
    
    $query = "INSERT INTO donation (date, email, qta) VALUES (?,?,?);";
    if (!$stmt = $conn->prepare($query)) { 
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        exit("Something went wrong, visit us later");
    }

    $donation = $conn->real_escape_string($donation);

    //Conversione da string a float
    $donation = floatval($donation);

    //controllo che il numero sia 
    // - effettivamente un float 
    // - Positivio
    if( !(filter_var($donation,FILTER_VALIDATE_FLOAT)) || $donation <= 0 )
    {
        error_log("Invalid value for the donation");
        redirect("crowdfunding.php");
        exit("Something went wrong, visit us later");
    }

    $now = date("Y-m-d H:i:s");

    if(!$stmt->bind_param('ssd', $now, $_SESSION['SID'], $donation)){
        error_log("Binding failed: (" . $stmt->errno . ") " . $stmt->error);
        exit("Something went wrong, visit us later");
    }

    $res = $stmt->execute();
        if (!$res){
            error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            exit("Something went wrong, visit us later");
        }

    $stmt->close();
    redirect("../index.php");
}

?>