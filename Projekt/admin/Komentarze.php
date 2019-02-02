<?php
  session_start();

  if(isset($_POST['AllComments'])){
    if($_POST['AllComments']=='Usun') deleteComment($_POST['login'], $_POST['data']);
    elseif($_POST['AllComments']=='Zedytuj') editComment($_POST['login'], $_POST['data'], $_POST['ZmienKoment']);
  }
  if(isset($_POST['UnacceptedComments']))
  if($_POST['UnacceptedComments'] == 'Zaakceptuj') acceptComment($_POST['login'], $_POST['data']);

  $sqlAll = "SELECT uzytkownicy.login, zdjecia_komentarze.id_uzytkownika AS id, komentarz, zdjecia.id AS id_zdjecia, zdjecia_komentarze.data
    FROM zdjecia_komentarze
    LEFT JOIN uzytkownicy ON uzytkownicy.id = zdjecia_komentarze.id_uzytkownika
    LEFT JOIN zdjecia ON zdjecia.id = zdjecia_komentarze.id_zdjecia
    ORDER BY zdjecia_komentarze.data DESC;";
  $sqlUnaccepted = "SELECT uzytkownicy.login, zdjecia_komentarze.id_uzytkownika AS id, komentarz, zdjecia.id AS id_zdjecia, zdjecia_komentarze.data
    FROM zdjecia_komentarze
    LEFT JOIN uzytkownicy ON uzytkownicy.id = zdjecia_komentarze.id_uzytkownika
    LEFT JOIN zdjecia ON zdjecia.id = zdjecia_komentarze.id_zdjecia
    WHERE zaakceptowany=0
    ORDER BY zdjecia_komentarze.data DESC;";

    $AllComments = mysqli_query($conn, $sqlAll);
    $UnacceptedComments = mysqli_query($conn, $sqlUnaccepted);
?>
<div id="pojemnik">
  <div id="AllLista">
    <br><h2>Wszystkie komentarze:</h2>
<?php
  while($row = mysqli_fetch_assoc($AllComments))
  {
    echo "<form action=".$_SERVER['REQUEST_URI']." method='POST'>";
    echo "<br><br>".$row['login'].": ".$row['komentarz']."<br>";
      if($_SESSION['uprawnienia']=='administrator')
      {
        echo  "
          <textarea type='text rows='1' cols='20' name='ZmienKoment' >".$row['komentarz']."</textarea>
          <br>
            <input type='hidden' name='login' value='".$row['id']."'>
            <input type='hidden' name='data' value='".$row['data']."'>
            <input type='submit' name='AllComments' value='Usun' onclick='return confirm(\"Na pewno chcesz usunąć?\")'>
            <input type='submit' name='AllComments' value='Zedytuj' onclick='return confirm(\"Na pewno chcesz dokonać edycji?\")'>
          </form>";}
      else
      {
        echo "<form action=".$_SERVER['REQUEST_URI']." method='POST'>
              <br>
                <input type='hidden' name='login' value=".$row['id'].">
                <input type='hidden' name='data' value='".$row['data']."'>
                <input type='submit' name='AllComments' value='Usun' onclick='return confirm(\"Na pewno chcesz usunąć?\")'>
              </form>"; }
  }
 ?>

</div>

<div id="UnacceptedLista">
  <br><h2>Niezaakceptowane komentarze:</h2>
<?php
  while($row = mysqli_fetch_assoc($UnacceptedComments))
  {
    //echo "<br>".$row['login'].": ".$row['komentarz']."";
    echo "<form action=".$_SERVER['REQUEST_URI']." method='POST'>";
    echo "<br><br>".$row['login'].": ".$row['komentarz']."<br>";
      if($_SESSION['uprawnienia']=='administrator')
      {
        echo  "
          <textarea type='text rows='1' cols='20' name='ZmienKoment' >".$row['komentarz']."</textarea>
          <br>
            <input type='hidden' name='login' value='".$row['id']."'>
            <input type='hidden' name='data' value='".$row['data']."'>
            <input type='submit' name='AllComments' value='Usun' onclick='return confirm(\"Na pewno chcesz usunąć?\")'>
            <input type='submit' name='AllComments' value='Zedytuj' onclick='return confirm(\"Na pewno chcesz dokonać edycji?\")'>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input type='submit' name='UnacceptedComments' value='Zaakceptuj'>
          </form>";}
      else
      {
        echo "<form action=".$_SERVER['REQUEST_URI']." method='POST'>
              <br>
                <input type='hidden' name='login' value=".$row['id'].">
                <input type='hidden' name='data' value='".$row['data']."'>
                <input type='submit' name='AllComments' value='Usun' onclick='return confirm(\"Na pewno chcesz usunąć?\")'>
              </form>"; }
  }
?>
</div>
</div>

<?php
  function deleteComment($login, $data){
    global $conn;


    $sql = "DELETE FROM zdjecia_komentarze WHERE id_uzytkownika =".$login." AND data = '".$data."';";

    mysqli_query($conn, $sql);

    echo "Usunięto";
  }

  function editComment($login, $data, $ZmienKoment){
    global $conn;

    $sql = "UPDATE zdjecia_komentarze SET komentarz ='".$ZmienKoment."' WHERE id_uzytkownika='".$login."' AND data ='".$data."';";

    mysqli_query($conn, $sql);

   echo "Zedytowano komentarz";
  }

  function acceptComment($login, $data){
    global $conn;

    $sql = "UPDATE zdjecia_komentarze SET zaakceptowany = 1 WHERE id_uzytkownika ='".$login."' AND data='".$data."';";

    mysqli_query($conn,$sql);

  echo "Zaakceptowano komentarz";
  }
 ?>
