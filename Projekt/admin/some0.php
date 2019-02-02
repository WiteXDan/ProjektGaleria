<?php
  include_once('../connect.php');
  session_start();


  $sql = "SELECT zdjecia.id, zdjecia.data, zdjecia.id_albumu, zdjecia.opis FROM zdjecia
        LEFT JOIN albumy ON zdjecia.id_albumu = albumy.id
        LEFT JOIN uzytkownicy ON albumy.id_uzytkownika=uzytkownicy.id
        WHERE albumy.id ='".$_POST['id']."'
        GROUP BY zdjecia.id
        ORDER BY zdjecia.data";


  $result = mysqli_query($conn, $sql);

   if (!$result) {
    printf("Error: %s\n", mysqli_error($conn));
     exit();
   }

   while($row = mysqli_fetch_array($result))
   {
          echo "<form style='display:inline-block; padding-left: 15vw' method='post' action='konto.php' onSubmit='return confirm(\'?\')'>
           <br>".$row['opis']."<br><img src='img/".$row['id_albumu']."/m".$row['id']."'
              width='180px' height='180px'
              title='".$row['opis'].", ".$row['data'].", ".$row['id_albumu'].", ".$row['id']."'/>
              <br><br>
                <input type='hidden' name='idZdjecia"."' value='".$row['id']."'>
           <input type='hidden' name='idAlbumu' value='".$row['id_albumu']."'>
                <input name='changeOpis"."' type='text' value='".$row['opis']."'>
                <button name='submitZdj' type='Submit' value='changeOpis'>Zmień tytuł</button>
                <button name='submitZdj' type='Submit' value='deleteZdj' onclick='return confirm('Na pewno chcesz usunąć zdjecie?')'>Usuń zdjecie</button>
                <hr><br><br>
              </form>";
   }
 ?>
