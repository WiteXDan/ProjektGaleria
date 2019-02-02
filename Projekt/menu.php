<?php
//session_start();
error_reporting(E_ALL ^ E_NOTICE);
  if(!isset($_SESSION['logged'])) $_SESSION['logged'] = 0;
  if(!isset($_SESSION['uprawnienia'])) $_SESSION['uprawnienia'] = 0;
//print_r($_SESSION);
 ?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Zadanie 1</title>
    <link rel="stylesheet" href="/Projekt/css/style0.css">
    <link rel="icon" href="css/favicon.gif" type="image/gif">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  </head>
  <body>

    <nav class="navbar" >
      <li class="sub-menu-parent" tab-index="0">Menu.
        <ul class="sub-menu">
            <!-- Galeria – przechodzi do głównej strony galeria.php -->
            <a href="/Projekt/galeria.php"><button>Przejdź do strony głównej.</button>

            <li >   <a <?php if(($_SESSION['logged'])){ echo "href='/Projekt/dodaj-album.php'"; }else echo "href='/Projekt/index.php'"; ?> class="menuCol" >Załóż album.</a></li>
              <!-- • Załóż album – przejście do strony umożliwiającej zakładanie nowego albumu (dodajalbum.php)
              lub do strony logowania, jeżeli odwiedzający nie jest zalogowany -->

            <li >   <a <?php if(($_SESSION['logged'])){ echo "href='/Projekt/dodaj-foto.php'"; }else echo "href='/Projekt/index.php'"; ?>  class="menuCol">Dodaj zdjęcie.</a></li>
              <!-- • Dodaj zdjęcie - przejście do strony umożliwiającej zdjęć do albumu (dodaj-foto.php) lub do
              strony logowania, jeżeli odwiedzający nie jest zalogowany  -->

            <li class="menuBest">   <a <?php if(($_SESSION['logged'])){ echo "href='/Projekt/top-foto.php'"; }else echo "href='/Projekt/index.php'"; ?>  >Najlepsze zdjęcia.</a></li>
              <!-- Najlepiej oceniane – lista zdjęć z najwyższymi ocenami (top-foto.php)  -->

            <li class="menuBest">   <a <?php if(($_SESSION['logged'])){ echo "href='/Projekt/nowe-foto.php'"; }else echo "href='/Projekt/index.php'"; ?> >Najnowsze zdjęcia.</a></li>
              <!-- • Najnowsze – lista ostatnio dodanych zdjęć (nowe-foto.php)  -->

<?php              if($_SESSION['logged']){
              echo "<li>  <a href='/Projekt/konto.php' class='menuBest'>Moje konto.</a> </li>";}

          if(!($_SESSION['logged'])){
          echo ("<li>  <a href='/Projekt/index.php' class='account'>Zaloguj się.</a></li>
                <li>  <a href='/Projekt/index.php' class='account'>Zarejestruj się.</a></li>");}
          else
            echo "<li>  <a href='wyloguj.php' class='account'>Wyloguj się.</a></li> ";

          if(!($_SESSION['uprawnienia'] == 'administator' || $_SESSION['uprawnienia'] == 'moderator')) echo "
          <li>  <a href='admin/index.php' class='admin'>Panel administracyjny. </a></li>";
  ?>
        </ul>
      </li>
<?php echo "<div class='IsLogged'>";

          if(!($_SESSION['logged'])) echo "Nie zalogowano";
            else echo "Zalogowano jako ".$_SESSION["login"]."</div>"; //Czemu <b> i <strong> przenosi login na pocżatek?
   ?>
    </nav>

    <!-- <link href="https://fonts.googleapis.com/css?family=Mali" rel="stylesheet">  -->

  </body>
</html>
