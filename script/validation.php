<?php
    //Funzione per prima validazione
    function inputValidation($data){
        if(isset($data)){                   //isset — Determina se una variabile è dichiarata ed è diversa da null
            $data = trim($data);            //Rimuove spazi bianchi dall'inzio e alla fine
            $data = stripslashes($data);    //Rimuove le virgolette di una stringa tra virgolette.
            $data = htmlspecialchars($data); //converte i caratteri speciali nelle entità HTML corrispondenti
            return $data;
        }
        else{
            exit("Error: invalid data");
        }
    }

    //funzione per validazione email
    function emailValidation($mail){
        if (empty($mail)) {
            echo "Email is required.";
            return false;
        } 
        else {
            // check if e-mail address is well-formed
            if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {       
                echo "Invalid email format."; 
                return false;
            } 

        // now returns the true- means you can proceed with this mail
        return true;
        }
    }

    //funzione per validazione password
    function passwordValidation($pass,$confirmpass){
        // Your validation code.
        if (empty($pass)) {
            echo "Password is required.";
            return false;
        } 
        else if ($pass !== $confirmpass) {
            // error matching passwords
            echo 'Your passwords do not match. Please type carefully.';
            return false;
        }
        // passwords match
        return true;
    }
?>