  <!-- Podstrona dodaj-album.php:
• dostępna tylko dla zalogowanych użytkowników
• zawiera formularz z jednym polem do wpisania tytułu dodawanego albumu
Nazwa albumy musi zawierać od 3 do 100 znaków bez początkowych i końcowych spacji.
W przypadku błędnej nazwy należy wrócić do formularza zakładania albumu z informacją o błędzie.
Po przesłaniu poprawnych danych nowy album zostaje zapisany do bazy.
Po dodaniu albumu do bazy skrypt powinien założyć w folderze IMG katalog, którego nazwa ma być
wygenerowanym autonumerem dla zakładanego albumu.
Po zapisie do bazy i utworzeniu katalogu użytkownik zostaje przekierowany do strony dodajfoto.php,
na której może dodawać zdjęcia do właśnie utworzonego albumu.  -->

<?php
session_start();
include_once('connect.php');
include_once('menu.php');
 ?>
<html>
  <head>
  </head>
  <body>
  <div class="container">
    <h1> Dodawanie albumu</h1>
      <div style="padding-top: 5%;" class='album'>
      <form action="dodaj-album.php" method="post">
        <label for="nazwaAlb">Nazwa albumu</label>
          <input type="text" name="nazwa" id="nazwaAlb"><br>

        <input type="Submit" value="Dodaj album">
      </form>

          <?php
//              print_r($_SESSION['id']);
  //$sql = mysqli_query($conn, "SELECT `tytul` FROM `albumy` WHERE `tytul` LIKE '".$_POST['nazwa']."'");
          if(isset($_SESSION['logged'])){
          if(isset($_POST['nazwa']))
          {
            $album = $_POST['nazwa'];
            $output = trim($album);
            $leng = mb_strlen($album);
            if(($leng >2 )&&($leng <101))
            {

                  var_dump($_SESSION['id']);

                          $sql = "INSERT INTO `albumy`
                                    SET `tytul` = '".$_POST['nazwa']."',
                                        `data` = now(),
                                        `id_uzytkownika` = '".$_SESSION['id']."'";
                            mysqli_query($conn, $sql);
                            $id_albumu = mysqli_insert_id($conn);
                          $sql = "SELECT * FROM `albumy` WHERE `tytul` ='".$output."'";
                            $result =  mysqli_query($conn, $sql);
                            $r = mysqli_fetch_assoc($result);
                            //  $_POST['id_albumu'] = $id_albumu;
                            //  var_dump($_POST['id_albumu']);
                              if(!is_dir("img/".$id_albumu))   mkdir ("img/".$id_albumu."");

                          echo "<script type='text/javascript'> alert('Brawo! Dodano album. Ten kawałek kodu działa.'); window.location.replace(\"dodaj-foto.php?id=".$id_albumu."\");</script>";
              //header("Location: Galeria.php");
              }
              else {
                  echo "<script type='text/javascript'> alert('Nazwa albumu musi mieć od 3 do 100 znaków.'); </script>";
              }
            }}
            else{
              echo "<script type='text/javascript'> alert('Zaloguj się!'); window.location.replace(\"index.php\"); </script>";
            //  header("Location: index.php");
              }

             ?>
    </div>
  </div>
  </body>
</html>
