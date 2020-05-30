<?php
    // $_SESSION["admin"] = FALSE;
    // session_unset();
    
    // set the expiration date to one hour ago
    setcookie("userr", "", time() + (86400 * 30), "/");
    header('Location: index.php');
?>