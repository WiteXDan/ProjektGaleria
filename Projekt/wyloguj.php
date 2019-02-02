<?php
/* RESET SESjI*/
session_start();
session_unset();
session_destroy();
header("Location: Galeria.php");
?>
