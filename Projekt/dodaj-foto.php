<!-- Podstrona dodaj-foto.php:
• dostępne tylko dla zalogowanych użytkowników
• po wejściu wyświetla listę wszystkich albumów zalogowanego użytkownika
• po wybraniu albumu wyświetla miniatury wszystkich zdjęć (również niezaakceptowanych) z
wybranego albumu przeskalowane do wymiarów 180x180px
• nad listą miniatur znajduje się formularz do dodania nowego zdjęcia z polami na przesłanie
zdjęcia i dodanie do niego opcjonalnego opisu (maksymalnie 255 znaków)
Po przesłaniu zdjęcia i opcjonalnego opisu zdjęcie zostaje zapisane w katalogu wybranego albumu z
nazwą taką, jak jego ID zdjęcia zapisany w bazie. Zdjęcie należy przeskalować tak, żeby jego dłuższy
bok nie przekraczał 1200px (mniejszych zdjęć nie powiększamy). Dopisując do bazy ustaw pole
zaakceptowane na 0.

https://www.thefreedictionary.com/words-that-end-in-ss#w4
https://en.wikipedia.org/wiki/Ajax_(programming)
https://en.wikipedia.org/wiki/JSON-->
<?php
    session_start();
include_once('connect.php');
include_once('menu.php');
include_once('class.img.php');
 ?>
<html>
<head></head>
  <body>
<div class="container">
<br><br>
<h1 style="text-align: left; margin-left: 200px;">Dodawanie zdjęć</h1>
<div class='album' style="float:left;">
      <form action="dodaj-foto.php" method="post" enctype="multipart/form-data" style="margin-left: 10%; ">
        <label for="nazwaZdj">Opis zdjecia</label>
          <input type="text" name="opis" id="nazwaZdj" value=''><br>

        <label for="WybierzAlb">Wybierz album</label>
      <!-- <input list="ListaAlbumy" name="nazwaAlb" id="WybierzAlb" required> -->
            <select name="lal" id="WybierzAlb" onChange="if(this.value !=0)zmiana(this.value)"> 
					
					<!-- X onChange - wywołuje przy zmianie wyboru w selecte funkcje 'zmiana' z wartością wybranej  -->
                <!-- <option value=0>Wybierz album</option> -->
              <?php
              //echo $_SESSION['id_albumu'];

                $sql = mysqli_query($conn, "SELECT `tytul`, `id` FROM `albumy` WHERE `id_uzytkownika` = ".$_SESSION["id"]); // Y wybiera z bazy tytuly i id istniejacych albumow
					
                $n=0;
                 while ( $results[] = mysqli_fetch_object( $sql )){  // Y zapytanie przekazuje do tabeli w formie obiektów
                 if($n==0){$id = $results[0]->id; $n =1;} // Y $results[0]->id odwołuje się  do id pierwszego wyniku zapytania i przypisuje go do zmiennej $id
}
                array_pop($results);  // Y usuwa ostatni element tablicy (bo jest pusty)

                 foreach ( $results as $option ){
                 echo '<option value='.$option->id.'';
                  if(intval($_GET['id'])==$option->id) echo ' selected'; // Y tworzy wszystkie opcje Selecta. $_POST['id_albumu'] to zmienna z dodaj-album. Tak by nowy album był od razu wybrany
                 echo ">".$option->tytul."</option>";}
              ?>
            </select>
               <br>

        <label for="fileToUpload">Wybierz zdjęcie</label>
          <input type="file" name="plik" id="fileToUpload" required> <br>

        <input type="Submit" value="Dodaj Zdjęcie" name="submit">
      </form>
</div>
<div id="kot" style="float:left;"></div>
          <?php
          if(($_FILES) && $_POST['lal']){ // upewnia się ze wysyłany jest plik, bo inaczej wywali Undefined_Index
          $f = $_FILES['plik']; // przypisuje przesłany plik do $f
        //  $plik_tmp = $_FILES['plik']['tmp_name'];
        //  $plik_nazwa = $_FILES['plik']['name'];
        //  $plik_rozmiar = $_FILES['plik']['size'];

          		if($f['type'] == 'image/png' or $f['type'] == 'image/jpeg' or $f['type'] == 'image/gif' or $f['type'] == 'image/jpg' ) // Sprawdza czy poprawny format pliku
          			{
          			$sql = "INSERT INTO zdjecia
          					SET opis='".$_POST['opis']."',
          						id_albumu='".$_POST['lal']."',
          						data=now()";
          						mysqli_query($conn, $sql); // wstawia do bazy danych zdjęcie


          							$plyk = mysqli_insert_id($conn); // pobiera ostatnie id tabeli zdjęcia (czyli to dodane)
                        //  var_dump($_POST['lal']);
                        if(!is_dir("img/".$_POST['lal'])) mkdir("img/".$_POST['lal'].""); // sprawdza czy istnieje folder albumu. jesli nie to towrzy

          							$img = new Image($f['tmp_name']); // tworzy obiekt klasy Image do zapisania zdjęcia

                          $img->SetMaxSize(1200);
                          $img->Save("img/".$_POST['lal']."/$plyk");  // zapisuje zdjecie

          					          $img->SetSize(180, 180);
                              $img->Save("img/".$_POST['lal']."/m$plyk"); // zapisuje miniaturke zdjecia
                      //        print_r($img);
                        $_GET['id']=$_POST['lal']; // wrzuca do tej zmiennej by po przeslaniu nadal byl wybrany ten album

                              echo "<script type='text/javascript'> alert('Kongratulacja! Dodano zdjęcie.') </script>";
          			}
                else if($_FILES['plik'])   echo "<script type='text/javascript'> alert('Nie zostało podane zdjęcie.')</script>";
              }
           ?>
	
           <script type="text/javascript">
           function zmiana(id){
           $.ajax({
          method: "POST", // przesyla POSTem zmienną id (dostarczaną w OnChange this)
          url: "some.php", // wywołuje ten plik
          data: { id: id  }, // zmienna wykorzystywana w pliku
          success:function(msg){ // jesli funkcja zadziała to:
            $("#kot").html(msg); // do htmla z ID kot bedzie wstawione $msg. msg to pobrane zdjecia wybranego albumu z some.php
          }
        })
      }
           zmiana(<?php echo($id); ?>)</script>
         </div>
   </div>
  </body>
</html>
