<?php
require_once("../db/database.php");
require_once("validation.php");
$email = inputValidation($_POST["email"]);
$email = $conn->real_escape_string($email);
$query = "SELECT * FROM user WHERE email=?;";

//Prepara un'istruzione per l'esecuzione e restituisce un oggetto istruzione  
if (!$stmt = $conn->prepare($query)) { 
    error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    exit("Something went wrong, visit us later");
}

if(!$stmt->bind_param('s',$email)){
    error_log("Binding failed: (" . $stmt->errno . ") " . $stmt->error);
    exit("Something went wrong, visit us later");
}

//ESECUZIONE QUERY
$res = $stmt->execute();
if (!$res){
    error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    exit("Something went wrong, visit us later");
}

$res = $stmt->get_result();
if(mysqli_num_rows($res)===1)
    echo "KO";
else
    echo "OK";

$stmt->close();
$conn->close();
?>