<?php
if(isset($_POST['submit'])){
  if($_POST['submit'] == 'deleteAlbum')  deleteAlbum();
  else  changeCollectionName();
}
?>

<div id="MojeAlbumy">
    <?php
  echo "<b><p style='color: #bfd7ff; font-size:23px;'>Albumy</p></b>";

	/*Sortowanie*/{
			if(!isset($_SESSION['admin']['jak'])) $_SESSION['admin']['jak']= 'ASC';

			if(!isset($_SESSION['admin']['sort'])) $_SESSION['admin']['sort']='tytul';
			if(isset($_GET['sort'])) $_SESSION['admin']['sort']=$_GET['sort'];

			if($_SESSION['admin']['jak'] == $_GET['jak'])
			{

			  if($_SESSION['admin']['jak'] == 'ASC') $_SESSION['admin']['jak'] = 'DESC';
			  else $_SESSION['admin']['jak'] = 'ASC';
			} // jeśli tak samo to zamień
			if($_SESSION['admin']['sort'] != $_GET['sort'])
			{
			  $_SESSION['admin']['jak'] = 'ASC';
			} // jeśli nowe sortowanie to przywróć na rosnąco

  echo "<div class='sortu'>";
			if($_SESSION['admin']['jak']=='ASC'){echo "Sortuj wg: rosnąco <br>";}else{echo "Sortuj wg: malejąco <br>";}


      if($_SESSION['admin']['sort']=='tytul'){
			  echo "<a href = '".$_SERVER['REQUEST_URI']."&sort=tytul&jak=".$_SESSION['admin']['jak']."' class='aktywny'>Tytuł   |</a>";}
			else {
			  echo "<a href = '".$_SERVER['REQUEST_URI']."&sort=tytul&jak=".$_SESSION['admin']['jak']."' class='nieaktywny'>Tytuł   |</a>";}
			if($_SESSION['admin']['sort']=='data'){
			  echo "<a href = '".$_SERVER['REQUEST_URI']."&sort=data&jak=".$_SESSION['admin']['jak']."' class='aktywny'>Data powstania  </a>";}
			else {
			  echo "<a href = '".$_SERVER['REQUEST_URI']."&sort=data&jak=".$_SESSION['admin']['jak']."' class='nieaktywny'>Data powstania   </a>";}
      echo "</div>";
  }
	/*Koniec Sortowania*/

	/******Wyświetlanie zdjęć********/{
      $sql = "SELECT albumy.*, min(zdjecia.id) AS foto_id, uzytkownicy.login FROM albumy
              LEFT JOIN zdjecia ON albumy.id=zdjecia.id_albumu
              LEFT JOIN uzytkownicy ON albumy.id_uzytkownika=uzytkownicy.id

              GROUP BY albumy.id
              ORDER BY ".$_SESSION['admin']['sort']." ".$_SESSION['admin']['jak'].";";

        echo "<br>";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
          printf("Error: %s\n", mysqli_error($conn));
          exit();
        }
		//$ileCzeka = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(zdjecia.id) AS ile, albumy.id FROM albumy LEFT JOIN zdjecia ON albumy.id = zdjecia.id_albumu WHERE zdjecia.zaakceptowane=0
		//GROUP BY albumy.id;"));

        while($row = mysqli_fetch_array($result))
        {
          $sql_d = "SELECT count(*) as ile , albumy.id
                    FROM zdjecia
                    LEFT JOIN albumy ON albumy.id=zdjecia.id_albumu
                    WHERE zdjecia.zaakceptowane = 0 AND albumy.id = ".$row['id']."
                    GROUP BY albumy.id";
                    $result_d = mysqli_query($conn, $sql_d);
          					$d = mysqli_fetch_assoc($result_d);
			if($row['id']==$d['id'])
			 echo "<form style='display:inline-block; padding-left: 5vw' method='post' action='index.php?page=album' onSubmit='return confirm(\"?\")'>".$row['tytul']."<br>Na zaakceptowanie czeka: ".$d['ile']."<br><img src='img/".$row['id']."/m".$row['foto_id']."'
              width='180px' height='180px'
              title='".$row['tytul'].", ".$row['login'].", ".$row['id'].",".$row['data']."'/>
              <br><br>
                <input type='hidden' name='idAlbumu"."' value='".$row['id']."'>
                <input name='changeTitle"."' type='text' value='".$row['tytul']."'>
                <button name='submit' type='Submit' value='changeTitle'>Zmień tytuł</button>
                <button name='submit' type='Submit' value='deleteAlbum' onclick='return confirm(\"Na pewno chcesz usunąć album?\")'>Usuń album</button>
                <hr><br><br>
              </form>";
			else
          echo "<form style='display:inline-block; padding-left: 5vw' method='post' action='index.php?page=album' onSubmit='return confirm(\"?\")'>".$row['tytul']."<br>Na zaakceptowanie czeka: 0<br><img src='img/".$row['id']."/m".$row['foto_id']."'
              width='180px' height='180px'
              title='".$row['tytul'].", ".$row['login'].", ".$row['id'].",".$row['data']."'/>
              <br><br>
                <input type='hidden' name='idAlbumu"."' value='".$row['id']."'>
                <input name='changeTitle"."' type='text' value='".$row['tytul']."'>
                <button name='submit' type='Submit' value='changeTitle'>Zmień tytuł</button>
                <button name='submit' type='Submit' value='deleteAlbum' onclick='return confirm(\"Na pewno chcesz usunąć album?\")'>Usuń album</button>
                <hr><br><br>
              </form>";
        }

        echo "<br>";
	}
	/*******Koniec Wyświetlania zdjęć********/
    ?>
</div>

<?php
function changeCollectionName(){
  global $conn;
  $tytul = trim($_POST['changeTitle']);
   $leng = mb_strlen($tytul);
  if(($leng >2)&&($leng <101))
  {
  //  $sql = "UPDATE albumy SET tytul ='".$_POST['changeTitle'].'1'."' WHERE id ='".$_POST['idPhoto'].'1'."';";


      $sql = "UPDATE albumy SET tytul ='".$_POST['changeTitle']."' WHERE id ='".$_POST['idAlbumu']."';";

      mysqli_query($conn, $sql);

      echo "Wykonano aktualizacje tytułów";
  }
  else{
      echo "<script type='text/javascript'> alert('Nazwa albumu musi mieć od 3 do 100 znaków.'); </script>";
  }
}

function deleteAlbum(){
  global $conn;

    //echo "<script type='text/javascript'> if(confirm('Czy na pewno chcesz usunąć album i wszystkie jego zdjęcia?')) else exit(); </script>"; // JAVA W PHP NIE ZADZIAŁA

    $sql1 = "DELETE FROM `zdjecia` WHERE id_albumu = '".$_POST['idAlbumu']."';";
	  $sql2 =	"DELETE FROM `albumy` WHERE id = '".$_POST['idAlbumu']."';";

	echo $sql1;
	echo $sql2;

   //   mysqli_multi_query($conn, $sql); // Nie zadziała jak by miało działać


mysqli_query($conn, 'SET foreign_key_checks = 0');
  	mysqli_query($conn, $sql1);
  	mysqli_query($conn, $sql2);
mysqli_query($conn, 'SET foreign_key_checks = 1');

  	delete_files('../img/'.$_POST['idAlbumu'].'/');
  	echo "Usunięto album i wszystkie jego zdjęcia.";
}


function delete_files($target) {
    if(is_dir($target)){
        $files = glob( $target . '*', GLOB_MARK );

        foreach( $files as $file ){
            delete_files( $file );
        }

        rmdir( $target );
    } elseif(is_file($target)) {
        unlink( $target );
    }
}
?>
