<?php
include_once('connect.php');
session_start();



  //  $reting_default_number = 1;
  //  $points = $_POST['points'];
    $id_zdjecia = $_POST['id_zdjecia'];
    $ocena = $_POST['val'];
    var_dump($ocena);
    mysqli_query($conn, "INSERT INTO zdjecia_oceny (id_uzytkownika, id_zdjecia, ocena) VALUES ($_SESSION['id'], $id_zdjecia, $ocena)");

    $sql = mysqli_query($conn, "SELECT COUNT(ocena) AS liczba_ocen, FORMAT((SUM(ocena) / COUNT(ocena)),1) as srednia_ocena FROM zdjecia_oceny");
      $results = mysqli_fetch_assoc($sql);

      echo $results['liczba_ocen'];
      echo $results['srednia_ocena'];
?>
