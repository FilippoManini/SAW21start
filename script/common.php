<?php
function redirect($url) {
    ob_start();
    header('Location: '.$url);
    ob_end_flush();
    exit();
}

function getBaseUrl(){
    global $baseURL;
    $pathExploded = explode('/',$_SERVER['SCRIPT_NAME']);
    $baseURL = 'https://'.$_SERVER['HTTP_HOST'].'/'.$pathExploded[1];//.'/'.$pathExploded[2];
    //$baseURL = 'http://localhost/'.$pathExploded[1].'/'.$pathExploded[2];
}
?>