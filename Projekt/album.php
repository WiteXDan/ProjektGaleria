<!-- Podstrona album.php:
• wyświetla miniatury wszystkich zaakceptowanych zdjęć z wybranego albumu przeskalowane
do wymiarów 180x180px w kolejności od najnowszego do najstarszego
• na stronie można wyświetlić maksimum 20 miniatur. Jeżeli zdjęć w albumie będzie więcej, to
pod listą miniatur powinna pokazać się paginacja (możliwość przejścia do kolejnych stron z
listą zdjęć)
• kliknięcie na zdjęcie przenosi użytkownika na stronę foto.php
• na górze i na dole strony umieść linki umożliwiające powrót do listy albumów  -->

<?php
  session_start();
  include_once('menu.php');
  include ('connect.php');
 ?>
 <html>
   <head> </head>
  <body>
  <div class="container">
    <div class='album'>
      <h1 id="nagl"> Znajdujesz się w albumie </h1><br><br>
      <div id="container-galeria">
    <a href='galeria.php'> Powrót do galerii. </a><br><br>
    <?php
    	$str = (isset($_GET['str'])) ? $_GET['str'] : 1;

  $php =  "SELECT zdjecia.id, zdjecia.data, zdjecia.opis, uzytkownicy.login, albumy.tytul FROM zdjecia
                          LEFT JOIN albumy ON albumy.id=zdjecia.id_albumu
                          LEFT JOIN uzytkownicy ON albumy.id_uzytkownika=uzytkownicy.id
                          WHERE albumy.id like '".$_GET['alb']."'
                          ORDER BY albumy.data ASC LIMIT ".(($str - 1) * 20).",20;";
    $results = mysqli_query($conn, $php);

     while($row = mysqli_fetch_assoc($results))
     {

       $data[$row['id']]['opis'] = $row['opis'];
       $data[$row['id']]['data'] = $row['data'];
       $loginAlb = $row['login'];
       $tytulAlb = $row['tytul'];

       echo "<a href=foto.php?alb=".$row['id_albumu']."&img=".$row['id']."><img src=img/".$row['id_albumu']."/m".$row['id']."></a>";
     }
     ?>

     <script type='text/javascript'> $("#nagl").append('<?php echo $tytulAlb;?>'); </script>

     <?php
     $_SESSION['results']=$data;
     $sql_c = "SELECT count(*) AS ile FROM zdjecia";
     $result_c = mysqli_query($conn, $sql_c);
     $r = mysqli_num_rows($result_c);

      $ile_stron = ceil($r / 20);
        for($i=1; $i<=$ile_stron; $i++)
        {
          echo "<br><a href='album.php?alb=".$_GET['alb']."&str=".$i."'><button>".$i."</button></a><br>";
        }
    ?>
      <br><a href='galeria.php'> Powrót do galerii. </a><br>
    </div>
  </div>
</div>
  </body>
</html>
