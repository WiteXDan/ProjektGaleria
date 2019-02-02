<!--
 Podstrona foto.php:
• wyświetla duże zdjęcie z albumu
• nad zdjęciem należy wyświetlić tytuł albumu, datę dodania zdjęcia, Nick użytkownika, który
zdjęcie dodał i opis zdjęcia o ile został podany
• na górze i na dole strony umieść linki umożliwiające powrót do listy zdjęć w przeglądanym
albumie
• pod zdjęciem należy wyświetlić ocenę tego zdjęcia z podaniem ilości oceniających
• jeżeli użytkownik jest zalogowany i jeszcze nie oceniał tego zdjęcia, to powinien mieć
możliwość dodania oceny (w skali od 1 do 10)
• jeżeli użytkownik jest zalogowany, to pod listą komentarzy umieść pole tekstowe
umożliwiające dodanie kolejnego komentarza, w przeciwnym razie wyświetl komunikat, że
musi się zalogować aby dodawać komentarze

• pod oceną wyświetl listę komentarzy do zdjęcia od najnowszych do najstarszych lub
komunikat o tym, że jeszcze nie ma żadnego komentarza


 -->
<?php
   session_start();
   include_once('menu.php');
   include_once('connect.php');
?>
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.11.3/jquery.min.js"></script> -->
<html>
<head>
</head>
<body>
  <h1>Zdjecie</h1>
<div class='foto'>
<?php
        $_SESSION['zdj'] = $_GET['img'];
        if(!$_SESSION['results']) {echo "<form action='' method='post'> <button name='odswiez' type='submit' value='sql'>Kliknij tutaj jeśli nie wyświetlają się informacje o zdjęciu.</button></form>";        }
        if($_POST['odswiez']=='sql'){   $php =  "SELECT zdjecia.*, uzytkownicy.login, albumy.tytul FROM zdjecia
                                  LEFT JOIN albumy ON albumy.id=zdjecia.id_albumu
                                  LEFT JOIN uzytkownicy ON albumy.id_uzytkownika=uzytkownicy.id
                                  WHERE albumy.id like '".$_GET['alb']."';";
                                $results = mysqli_query($conn, $php);

             while($row = mysqli_fetch_assoc($results))
             {
               $data[$row['id']] = $row;
             }
           $_SESSION['results']=$data;
         }

  echo"<br><a href='album.php?alb=".$_GET['alb']."'>Powrót do albumu</a><br>";

    echo("TYTUL ALBUMU: ".$_SESSION['results'][$_GET['img']]['tytul'].
         "<br>Data wstawienia: ".$_SESSION['results'][$_GET['img']]['data'].
         "<br>Autor: ".$_SESSION['results'][$_GET['img']]['login'] );
      if($_SESSION['results'][$_GET['img']]['opis']) echo "<br>Opis: ".$_SESSION['results'][$_GET['img']]['opis'];

  echo "<br><br><img src=img/".$_GET['alb']."/".$_GET['img'].">";

  echo"<br><a href='album.php?alb=".$_GET['alb']."'>Powrót do albumu</a><br>";
//  print_r($_SESSION['results']);


if(isset($_SESSION['login']))
{
  $sql = "SELECT id_uzytkownika
          FROM zdjecia_oceny
          LEFT JOIN zdjecia ON zdjecia_oceny.id_zdjecia=zdjecia.id
          WHERE zdjecia_oceny.id_uzytkownika = '".$_SESSION['id']."' AND  zdjecia_oceny.id_zdjecia = '".$_SESSION['zdj']."';";
  $result = mysqli_query($conn, $sql);
  $lel = mysqli_fetch_assoc($result);
  if($lel['id_uzytkownika']!=$_SESSION['id'])
  {
    echo "<form action = 'foto.php?alb=".$_GET['alb']."&img=".$_SESSION['zdj']."' method = 'post' enctype='multipart/form-data'>
          Ocena: <input type='number' name='ocena' id='ocena' min='1' max='10' required><br>
          <input type='submit' value='Dodaj Ocene'><br>
          </form>";
    if(isset($_POST['ocena']))
    {
      $sql = "INSERT INTO zdjecia_oceny (id_zdjecia, id_uzytkownika, ocena) VALUES ('".$_SESSION['zdj']."','".$_SESSION['id']."','".$_POST['ocena']."')";
      mysqli_query($conn, $sql);
      header("Location: foto.php?alb=".$_GET['alb']."&img=".$_SESSION['zdj']."");
    }
  }
}
$sql = "SELECT ROUND(avg(ocena),1) AS sr_ocena, count(*) AS ile_ocen
        FROM zdjecia_oceny
        LEFT JOIN zdjecia ON zdjecia_oceny.id_zdjecia=zdjecia.id
        WHERE zdjecia_oceny.id_zdjecia = '".$_SESSION['zdj']."';";
$result = mysqli_query($conn, $sql);
$lel = mysqli_fetch_assoc($result);
echo "<p>Ocena: ".$lel['sr_ocena'].", Na podstawie ".$lel['ile_ocen']." ocen. </p><br>";
 ?>
<div style="text-align:left; margin-left:10%;">
<?php
echo "<h2><br><b>Komentarze:</b></h2>";
$sql = "SELECT uzytkownicy.login, komentarz
  FROM zdjecia_komentarze
  LEFT JOIN uzytkownicy ON uzytkownicy.id = zdjecia_komentarze.id_uzytkownika
  WHERE id_zdjecia = '".$_SESSION['zdj']."'
  AND zdjecia_komentarze.zaakceptowany = 1
  ORDER BY zdjecia_komentarze.data DESC;";
$result = mysqli_query($conn, $sql);
$check = mysqli_num_rows($result);
if($check==0) echo "Jeszcze nie ma żadnego komentarza. <br>";
else {
  while($row = mysqli_fetch_assoc($result))
  {
    echo"<br>".$row['login'].": ".$row['komentarz']."";
  }
}


  if($_SESSION['logged'])
  {
echo "<form action='' method='POST' >
      <textarea type='text' rows='4' cols='50' name='dodajKoment' placeholder='Dodaj komentarz...' required></textarea>
      <input type='submit'>
    </form>";

    if(isset($_POST['dodajKoment'])){

  $sql = "INSERT INTO zdjecia_komentarze (id_zdjecia, id_uzytkownika, data, komentarz, zaakceptowany)
                  VALUES ('".$_SESSION['zdj']."','".$_SESSION['id']."', NOW(), '".$_POST['dodajKoment']."', 0)";
    mysqli_query($conn, $sql);
    echo "<script type='text/javascript'> alert('Dodano komentarz.')</script>";
    }

}else echo "<b><br><br>Najpierw się zaloguj aby komentować.</b>";
?>
</div>
</div>

</body>
</html>
