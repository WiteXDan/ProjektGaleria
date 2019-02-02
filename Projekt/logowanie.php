<?php
include_once('connect.php');
session_start();
/* Wykonanie zapytania SQL */
$login = $_POST['login'];
$haslo = md5($_POST['password']);

  $result = mysqli_query($conn, "SELECT `login` AND `haslo` FROM `uzytkownicy` WHERE `login` LIKE '".$login."' AND `haslo` LIKE '".$haslo."'");
if(mysqli_num_rows($result)){
$sql = "SELECT `aktywny`  FROM `uzytkownicy` WHERE `login` LIKE '".$login."' AND `haslo` LIKE '".$haslo."' AND `aktywny` = 1";
// $query = "SELECT * FROM user WHERE username = '". mysqli_real_escape_string($user) ."' AND pass = '". mysqli_real_escape_string($pass) ."'" ;
//https://stackoverflow.com/questions/5741187/sql-injection-that-gets-around-mysql-real-escape-string/12118602#12118602
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result)) {
    $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT `id` FROM `uzytkownicy` WHERE `login` LIKE '".$login."'"));
  $_SESSION["id"] = $r['id'];
  $_SESSION["login"] = $login;
  $_SESSION["password"] = $haslo;
    $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT `email` FROM `uzytkownicy` WHERE `login` LIKE '".$login."'"));
  $_SESSION["email"] = $r['email'];
    $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT `uprawnienia` FROM `uzytkownicy` WHERE `login` LIKE '".$login."'"));
  $_SESSION["uprawnienia"] = $r['uprawnienia'];
  $_SESSION["logged"] = 1;
  header("Location: Galeria.php");
} else {
    echo "<script type='text/javascript'>alert('Twoje konto zostało zablokowane.');</script>";
}
}
else {
  echo "<script type='text/javascript'> alert('Błędny login lub hasło!'); window.location.replace(\"index.php\"); </script>";
}

 ?>
