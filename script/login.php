<?php
session_start();
require_once('common.php');
require_once('validation.php');

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $email = $password = "";
    $email = inputValidation($_POST["email"]);
    $password = trim($_POST["pass"]);

    require_once('../db/database.php');
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);


    $query = "SELECT password FROM user WHERE email = ?";
    if(!$stmt = $conn->prepare($query)){
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        exit("Something went wrong, visit us later");
    }

    if(!$stmt->bind_param('s',$email)){
        error_log("Binding failed: (" . $stmt->errno . ") " . $stmt->error);
        exit("Something went wrong, visit us later");
    }

    $res = $stmt->execute();
    if (!$res){
        error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        $auth = false;
    }
    else
    {
        $data = $stmt->get_result();
        $row = $data->fetch_assoc();
        $auth = password_verify($password, $row['password']);
    }

    $stmt->close();
    $conn->close();
    
    //Se $auth è true creo la variabile di sessione contenente l'email
    
    if($auth)
    {
        $_SESSION['SID'] = $email;
        redirect("../index.php");
    }
    else{ //altrimenti rimando alla pagina di login
        //require_once("logout.php");
        redirect("loginPage.php");
    }
}

?>