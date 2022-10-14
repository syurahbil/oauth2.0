<?php
    unset($_SESSION['_CAPTCHA']);
    unset($_SESSION['captcha']);
    unset($_SESSION['token']);
    unset($_SESSION['userid']);
    session_unset();
    session_destroy();
    header("Location: ./"); 
?>
