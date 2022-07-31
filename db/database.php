<?php
    ini_set('display_errors', false);
    ini_set('error_log', 'php.log');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 
    $conn = new mysqli('localhost','S4840761','&2&6PMHt','S4840761');
    
    if ($conn->connect_errno) {
        throw new RuntimeException('mysqli connection error: ' . $conn->connect_error);
        exit();
    }
?>