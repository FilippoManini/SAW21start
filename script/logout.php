<?php
    session_start();
    require_once('common.php');
    getBaseUrl();
    // remove session variable
    unset($_SESSION["SID"]);
    // destroy the session
    session_destroy();
    session_write_close();
    setcookie(session_name(), "", time() - 3600,'/');
    session_regenerate_id(true);

    redirect($baseURL);
?>