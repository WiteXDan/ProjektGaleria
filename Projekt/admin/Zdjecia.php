<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<?php

include('../connect.php');
session_start();

	  echo "<b><p style='color: #bfd7ff; font-size:23px;'>Zdjecia</p></b>";
		echo "<form name='lal' id='WybierzAlb'  onChange=\"if(this.value !=0)zmiana(this.value)\">";
			// echo "Niezaakceptowane: <input name='zdj' value='niezaakceptowane' type='radio'><br>";
			// echo "Wszystkie: <input name='zdj' value='wszystkie' type='radio'><br>";
    echo "<select name='album'> ";

      //echo $_SESSION['id_albumu'];

        $sql = mysqli_query($conn, "SELECT `tytul`, `albumy`.`id`, zdjecia.id FROM `albumy`
                                        LEFT JOIN zdjecia ON zdjecia.id_albumu = albumy.id
                                      WHERE EXISTS(SELECT NULL FROM zdjecia
													 WHERE albumy.id  = zdjecia.id_albumu)
													 AND zaakceptowane = 0
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

    echo "</select>
		</form>";


	?>
<div id="ajax">

</div>


<script type="text/javascript">
function zmiana(id){
$.ajax({
method: "POST", // przesyla POSTem zmienną id (dostarczaną w OnChange this)
url: "some0.php", // wywołuje ten plik
data: { id: id,
  		}, // zmienna wykorzystywana w pliku
success:function(msg){ // jesli funkcja zadziała to:
  console.log(msg);
 $("#ajax").html(msg); // do htmla z ID kot bedzie wstawione $msg. msg to pobrane zdjecia wybranego albumu z some.php
}
})
}

zmiana(<?php echo($id); ?>)</script>
