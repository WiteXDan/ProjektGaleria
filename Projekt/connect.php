<?php

/* Łączenie z serwerem MySQL*/
$conn = mysqli_connect("localhost", "root", "", "michalski_4ta");
/* Kontrola połączenia */
if(mysqli_connect_errno()) {
  echo "Bład połączenia nr: " . mysqli_connect_errno();
  echo "Opis błędu: " . mysqli_connect_error();
  exit();
}
/* Ustawienie strony kodowej */
mysqli_query($conn, 'SET NAMES utf8');
mysqli_query($conn, 'SET CHARACTER SET utf8');
mysqli_query($conn, "SET collation_connection = utf8_polish_ci");
// $conn = mysqli_close($conn);
?>
