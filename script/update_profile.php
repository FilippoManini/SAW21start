<?php
    session_start();
    require_once('validation.php');
    require_once('common.php');

    if(isset($_SESSION['SID']))
    {
        $email = $name = $surname = "";
        $email = inputValidation($_POST["email"]);
        $name = inputValidation($_POST["firstname"]);
        $surname = inputValidation($_POST["lastname"]);

        isset($_POST["phone"]) ? $number = inputValidation($_POST["phone"]) : $number = NULL;
        isset($_POST["address"]) ? $address = inputValidation($_POST["address"]) : $address = NULL;
        isset($_POST["bio"]) ? $bio = inputValidation($_POST["bio"]) : $bio = NULL;

        require_once('../db/database.php');

        $query = sprintf("UPDATE user SET name=?, surname=?, email=?, phone_number=?, address=?, bio=? WHERE email='%s';", $_SESSION['SID']);

        //Prepara un'istruzione per l'esecuzione e restituisce un oggetto istruzione  
        if (!$stmt = $conn->prepare($query)) { 
            error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            exit("Something went wrong, visit us later");
        }

        //Validazione
        $name = $conn->real_escape_string($name);
        $surname = $conn->real_escape_string($surname);
        $email = $conn->real_escape_string($email);
        $number = $conn->real_escape_string($number);
        $address = $conn->real_escape_string($address);
        $bio = $conn->real_escape_string($bio);

        if (!$stmt->bind_param('ssssss', $name, $surname, $email, $number, $address, $bio)){
            error_log("Bind failed: (" . $stmt->errno . ") " . $stmt->error);
            exit("Something went wrong, visit us later");
        }
        
        $res = $stmt->execute();
        if (!$res){
            error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            exit("Something went wrong, visit us later");
        }
        else{
            //Reimposto la variabile di sessione con la mail aggiornata
            $_SESSION['SID'] = $email;

            //redirect
            redirect("show_profile.php");
        }

        $stmt->close();
    }
?>