<?php
    require_once('common.php');
    require_once('validation.php');

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        //Gestione "ipotetici" campi vuoti
        if(empty($_POST['email']) || empty($_POST['pass']) || empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['confirm']))
            exit();

        //SANITIFICAZIONE DEI DATI IN INPUT (per Client)
        $name = inputValidation($_POST["firstname"]);
        $surname = inputValidation($_POST["lastname"]);
        $email = inputValidation($_POST["email"]);
        $password = trim($_POST["pass"]);
        $confirmPsw = trim($_POST["confirm"]);
        
        //SANITIFICAZIONE DEI DATI IN INPUT (per Server)
        require_once("../db/database.php");
        $name = $conn->real_escape_string($name);
        $surname = $conn->real_escape_string($surname);
        $email = $conn->real_escape_string($email);
        $password = $conn->real_escape_string($password);
        $confirmPsw = $conn->real_escape_string($confirmPsw);

        //Controllo lunghezza parametri per inserimento nella tabella del db
        if(strlen($email)>100 || strlen($name)>25 || strlen($surname)>25 || strlen($password)>70 || strlen($confirmPsw)>70) exit("Invalid field lenght");
        //Validazione email
        if(!emailValidation($email)) exit("Invalid e-mail ");
        //Controllo che pass e confirm siano uguali
        if(!passwordValidation($password,$confirmPsw)) exit("Passwords do not match");


        //------------------------------[UTENTE GIA' REGISTRATO]----------------------------
        $query = sprintf("SELECT * FROM user WHERE email='%s';", $email);
        $res = $conn->query($query);
        if($res===FALSE){
            error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            exit("Something went wrong, visit us later");
        }

        //Controllo cosa mi ha ritornato
        $row = $res->num_rows;
        if($row === 1)
        {
            //L'utente è già registrato quindi lo reinderizzo alla login
            $conn->close();
            redirect("loginPage.php");
            exit();
        }
        $res->close();

        //------------------------------[UTENTE NON REGISTRATO]----------------------------
        //Cifratura password
        $password = password_hash($password,PASSWORD_DEFAULT);

        $query = "INSERT INTO user (name, surname, email, password) VALUES (?, ?, ?, ?);";
        //Prepara un'istruzione per l'esecuzione e restituisce un oggetto istruzione  
        if (!$stmt = $conn->prepare($query)) { 
            error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            exit("Something went wrong, visit us later");
        }

        if(!$stmt->bind_param('ssss', $name, $surname, $email, $password)){
            error_log("Binding failed: (" . $stmt->errno . ") " . $stmt->error);
            exit("Something went wrong, visit us later");
        }

        //ESECUZIONE QUERY
        $res = $stmt->execute();
        if (!$res){
            error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            exit("Something went wrong, visit us later");
        }

        $stmt->close();
        $conn->close();
        redirect("../index.php");   
        exit();
    }
?>