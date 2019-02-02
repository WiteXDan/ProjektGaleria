<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
include_once('menu.php');
include ('connect.php');

// Moje-Albumy
if(isset($_POST['submit'])){
  if($_POST['submit'] == 'deleteAlbum')  deleteAlbum();
  else  changeCollectionName();
} // Moje- // Moje-Albumy

//Moje-Zdjecia
if(isset($_POST['submitZdj'])){
  if($_POST['submitZdj'] == 'deleteZdj') deleteZdj();
 else if($_POST['submitZdj'] == 'changeOpis') changeOpis();
} // Moje-Zdjecia

// Moje-Dane
if(isset($_POST['Zmiana2'])){
  if(md5($_POST['ZmianaConf']) == $_SESSION['password']) {
	  if($_POST['ZmianaHasla'] == $_POST['ZmianaHaslaConf']){
		 if(!empty($_POST['ZmianaHasla']) && !empty($_POST['ZmianaHaslaConf'])) changePass(md5($_POST['ZmianaHasla']));
		 if(!empty($_POST['ZmianaEmail']) && $_POST['ZmianaEmail'] != $_SESSION['email']) changeEmail($_POST['ZmianaEmail']);}
	  else echo "Hasła się nie zgadzają";
  } else echo "Podane błędne aktualne hasło";
}
 ?>

<!-------- MOJE-DANE ------------>
<div id="MojeDane">

	  <table id="TwojeDane">
		 <tr> <th colspan="2">Twoje Dane</th> </tr>
		 <tr> <th>Login:</th> <td><?php echo $_SESSION['login'];?></td> </tr>
		 <tr> <th>Email:</th> <td><?php echo $_SESSION['email'];?></td> </tr>
		 <tr> <th>Typ konta:</th> <td><?php echo $_SESSION['uprawnienia'];?></td> </tr>
	  </table>

	<br>
	<div id="ZmianaDanych">
    <form method="post" name="Zmiana">
      <label style="margin-left: ">Zmiana hasła lub email:</label><br>
      <label for="ChangePass"> Podaj nowe hasło: </label>
        <input type="password" id="ChangePass" name="ZmianaHasla">
          <br>
      <label for="ConfChangePass"> Potwierdź nowe hasło: </label>
        <input type="password" id="ConfChangePass" name="ZmianaHaslaConf">
        <br>
      <label for="ChangeEmail"> Podaj nowy email: </label>
        <input type="email" id="ChangeEmail" name="ZmianaEmail">
          <br>
          <br>
      <label for="OldPassword"> Podaj stare hasło: </label>
        <input type="password" id="OldPassword" name="ZmianaConf" required>
          <br>
      <input type="Submit" name="Zmiana2" value="Zmień">
    </form>
  </div>
</div>

<!-------- MOJE-ALBUMY ---------->
<div id="MojeAlbumy">
    <?php
  echo "<b><p style='color: #bfd7ff; font-size:23px;'>Albumy</p></b>";

	/*Sortowanie*/{
			if(!isset($_SESSION['konto']['jak'])) $_SESSION['konto']['jak']= 'ASC';

			if(!isset($_SESSION['konto']['sort'])) $_SESSION['konto']['sort']='tytul';
			if(isset($_GET['sort'])) $_SESSION['konto']['sort']=$_GET['sort'];

			if($_SESSION['konto']['jak'] == $_GET['jak'])
			{

			  if($_SESSION['konto']['jak'] == 'ASC') $_SESSION['konto']['jak'] = 'DESC';
			  else $_SESSION['konto']['jak'] = 'ASC';
			} // jeśli tak samo to zamień
			if($_SESSION['konto']['sort'] != $_GET['sort'])
			{
			  $_SESSION['konto']['jak'] = 'ASC';
			} // jeśli nowe sortowanie to przywróć na rosnąco

  echo "<div class='sortu'>";
			if($_SESSION['konto']['jak']=='ASC'){echo "Sortuj wg: rosnąco <br>";}else{echo "Sortuj wg: malejąco <br>";}


      if($_SESSION['konto']['sort']=='tytul'){
			  echo "<a href = '".$_SERVER["PHP_SELF"]."?sort=tytul&jak=".$_SESSION['konto']['jak']."' class='aktywny'>Tytuł   |</a>";}
			else {
			  echo "<a href = '".$_SERVER["PHP_SELF"]."?sort=tytul&jak=".$_SESSION['konto']['jak']."' class='nieaktywny'>Tytuł   |</a>";}
			if($_SESSION['konto']['sort']=='data'){
			  echo "<a href = '".$_SERVER["PHP_SELF"]."?sort=data&jak=".$_SESSION['konto']['jak']."' class='aktywny'>Data powstania  </a>";}
			else {
			  echo "<a href = '".$_SERVER["PHP_SELF"]."?sort=data&jak=".$_SESSION['konto']['jak']."' class='nieaktywny'>Data powstania   </a>";}
      echo "</div>";
  }
	/*Koniec Sortowania*/

	/******Wyświetlanie zdjęć********/{
      $sql = "SELECT albumy.*, min(zdjecia.id) AS foto_id, uzytkownicy.login FROM albumy
              LEFT JOIN zdjecia ON albumy.id=zdjecia.id_albumu
              LEFT JOIN uzytkownicy ON albumy.id_uzytkownika=uzytkownicy.id
              WHERE uzytkownicy.id =".$_SESSION['id']."
              GROUP BY albumy.id
              ORDER BY ".$_SESSION['konto']['sort']." ".$_SESSION['konto']['jak'].";";

        echo "<br>";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
          printf("Error: %s\n", mysqli_error($conn));
          exit();
        }

        while($row = mysqli_fetch_array($result))
        {
          echo "<form style='display:inline-block; padding-left: 15vw' method='post' action='konto.php' onSubmit='return confirm(\"?\")'>
          ".$row['tytul']."<br><img src='img/".$row['id']."/m".$row['foto_id']."'
              width='180px' height='180px'
              title='".$row['tytul'].", ".$row['login'].", ".$row['data']."'/>
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

<!-------- MOJE-ZDJECIA --------->
<div id="MojeZdjecia">

	<?php
	  echo "<b><p style='color: #bfd7ff; font-size:23px;'>Zdjecia</p></b>";

    echo "<select name='lal' id='WybierzAlb' onChange=\"if(this.value !=0)zmiana(this.value)\"> ";

      //echo $_SESSION['id_albumu'];

        $sql = mysqli_query($conn, "SELECT `tytul`, `albumy`.`id` FROM `albumy`
                                        LEFT JOIN zdjecia ON zdjecia.id_albumu = albumy.id
                                      WHERE `id_uzytkownika` = ".$_SESSION['id']."
                                        AND EXISTS(SELECT NULL FROM zdjecia WHERE albumy.id  = zdjecia.id_albumu)
                                      GROUP BY albumy.id"); // Y wybiera z bazy tytuly i id istniejacych albumow

        $n=0;
         while ( $results[] = mysqli_fetch_object( $sql )){  // Y zapytanie przekazuje do tabeli w formie obiektów
         if($n==0){$id = $results[0]->id; $n =1;} // Y $results[0]->id odwołuje się  do id pierwszego wyniku zapytania i przypisuje go do zmiennej $id
         }
        array_pop($results);  // Y usuwa ostatni element tablicy (bo jest pusty)

         foreach ( $results as $option ){
         echo '<option value='.$option->id.'';
        //  if(intval($_GET['id'])==$option->id) echo ' selected'; // Y tworzy wszystkie opcje Selecta. $_POST['id_albumu'] to zmienna z dodaj-album. Tak by nowy album był od razu wybrany
         echo ">".$option->tytul."</option>";}

    echo "</select>";



	?>
<div id="Ajax">

</div>
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


   //   mysqli_multi_query($conn, $sql); // Nie zadziała jak by miało działać
  	mysqli_query($conn, $sql1);
  	mysqli_query($conn, $sql2);

  	delete_files('img/'.$_POST['idAlbumu'].'/');
  	echo "Usunięto album i wszystkie jego zdjęcia.";
}


function changePass($pass){
  global $conn;
	echo "<br> HASLO:";
	echo $pass;
  $callback = "";

  if(empty($pass)){
     $callback .= "Podaj hasło.\\n";
     if(!(preg_match('/((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]))/', $haslo))){
        $callback .= "Hasło - Minimum 1 duża litera, 1 mała litera i 1 cyfra\\n";
       if(mb_strlen($pass) <6 && mb_strlen($haslo) >20){
          $callback .= "Hasło może mieć od 6 do 20 znaków.\\n";

              $sql = "UPDATE uzytkownicy SET haslo = '".$pass."' WHERE login = '".$_SESSION['login']."';";

              mysqli_query($conn, $sql);
              echo "<br>Haslo zostało zmienione";
               $_SESSION['password'] = $pass;
               exit();
             }
           }
         }
         else   return $callback;
}

function changeEmail($email){
	global $conn;
	 echo "<br> EMAIL:";
	 echo $email;

	$sql = "UPDATE uzytkownicy SET email = '".$email."' WHERE login ='".$_SESSION['login']."'";

	mysqli_query($conn, $sql);

	echo "<br>Email został zmieniony";
	 $_SESSION['email'] = $email;
}

function changeOpis(){
	global $conn;
	// PUSTE
  if(strlen($_POST['changeOpis'])<=255){
    $sql = "UPDATE zdjecia SET opis ='".$_POST['changeOpis']."' WHERE id=".$_POST['idZdjecia'].";";
      echo $sql;
    mysqli_query($conn, $sql);

    echo "Wykonano aktualizacje opisu";
  }
  else {
    echo "<script type='text/javascript'> alert('Opis zdjęcia może mieć do 255 znaków.'); </script>";
  }

}// PUSTE


function deleteZdj(){
	global $conn;

	$sql = "DELETE FROM `zdjecia` WHERE id = '".$_POST['idZdjecia']."';";

	mysqli_query($conn, $sql);
	delete_files('img/'.$_POST['idAlbumu'].'/'.$_POST['idZdjecia'].'/');

} // NIE DZIAŁA


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

<script type="text/javascript">
function zmiana(id){
$.ajax({
method: "POST", // przesyla POSTem zmienną id (dostarczaną w OnChange this)
url: "some0.php", // wywołuje ten plik
data: { id: id  }, // zmienna wykorzystywana w pliku
success:function(msg){ // jesli funkcja zadziała to:
  console.log(msg);
 $("#Ajax").html(msg); // do htmla z ID kot bedzie wstawione $msg. msg to pobrane zdjecia wybranego albumu z some.php
}
})
}
zmiana(<?php echo($id); ?>)</script>
