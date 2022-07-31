<?php
    session_start();
    require_once('validation.php');
    require_once('common.php');
    require_once('../db/database.php');

    if(isset($_SESSION['SID']))
    {
        $old = trim($_POST["oldP"]);
        $new = trim($_POST["newP"]);
        $confirm = trim($_POST["confirmP"]);

        $old = $conn->real_escape_string($old);
        $new = $conn->real_escape_string($new);
        $confirm = $conn->real_escape_string($confirm);

        $query = "SELECT password FROM user WHERE email = ?";
        if(!$stmt = $conn->prepare($query)){
            error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            $conn->close();
            exit("Something went wrong, visit us later");
        }

        if(!$stmt->bind_param('s',$_SESSION['SID'])){
            error_log("Bind failed: (" . $stmt->errno . ") " . $stmt->error);
            $stmt->close();
            exit("Something went wrong, visit us later");
        }

        $res = $stmt->execute();
        if (!$res){
            error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            $stmt->close();
            exit("Something went wrong, visit us later");
        }

        $data = $stmt->get_result();
        $row = $data->fetch_assoc();

        //Verifico che la vecchia password sia corretta
        if(!$auth = password_verify($old, $row['password']))
        {
            error_log("Password verify returned: (" . $auth . ") ");
            $stmt->close();
            exit("Something went wrong, visit us later");
        }
            
        //Verifico che la nuova password sia diversa dalla vecchia
        if(password_verify($new, $row['password']))
        {
            error_log("The old and the new password are the same");
            $stmt->close();
            exit("Something went wrong, visit us later");
        }

        //Verifico che la nuoova password e la sua conferma siano uguali
        if(!passwordValidation($new,$confirm))
        {
            error_log("Passwords do not match");
            $stmt->close();
            exit("Something went wrong, visit us later");
        }

        //Cifratura nuova password
        $new = password_hash($new,PASSWORD_DEFAULT);

        $stmt->close();

        //Query per update della password
        $query = "UPDATE user SET password=? WHERE email=?;";
        if (!$stmt = $conn->prepare($query)) { 
            error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            $conn->close();
            exit("Something went wrong, visit us later");
        }

        if (!$stmt->bind_param('ss', $new, $_SESSION['SID'])){
            error_log("Bind failed: (" . $stmt->errno . ") " . $stmt->error);
            $stmt->close();
            exit("Something went wrong, visit us later");
        }

        $res = $stmt->execute();
        if (!$res){
            error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            $stmt->close();
            exit("Something went wrong, visit us later");
        }
        
        $conn->close();
        redirect("show_profile.php");

    }
    else
    {
        $conn->close();
        redirect("../index.php");
    }
?>
