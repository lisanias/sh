<?php
session_start();
$_SESSION = array();
session_destroy();
setcookie("stringid");
header("Location: ./../index.html");
?>