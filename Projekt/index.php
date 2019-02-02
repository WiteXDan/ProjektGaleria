<!-- Zmienić szatę graficzną  -->
<!--    Spróbować zrobić obiektowo -->
<?php
session_start();
include_once('menu.php');
if(isset($_SESSION['logged'])){
  if($_SESSION['logged']) header('Location: Galeria.php');
}
 ?>

<HTML>
<HEAD></HEAD>
<BODY>
  <div class="container">
  <div id='index2'>
    <?php
//  $_SESSION=array();
    if(isset($_SESSION["callback"]))
      echo "<script type='text/javascript'>alert('".$_SESSION['callback']."');</script>";
      unset($_SESSION["callback"]);
    ?>
      <h1> Witam w klasycznych albumach! </h1>
    <div class="rejestracja">
      <h3>Zarejestruj się</h3>
      <form action="rejestracja.php" method="post">   <!-- Pierwszy formularz - REJESTRACJA  -->

        <label for="loginReg">Podaj login: </label>
              <input type="text" name="login" id="loginReg" <?php if(!empty($_SESSION['login']))echo("value='".$_SESSION['login']."'"); ?>> <br><br>

        <label for="passwordReg">Podaj hasło: </label>
              <input type="password" name="password" id="passwordReg"  <?php //if(!empty($_SESSION['password'])) echo("value='".$_SESSION['password']."'"); ?> required> <br>

        <label for="passwordConf">Potwierdź hasło: </label>
              <input type="password" name="passwordConf" id="passwordConf" <?php //if(!empty($_SESSION['password'])) echo("value='".$_SESSION['password']."'"); ?> required><br><br>

        <label for="emailReg">Podaj email: </label>
              <input type="email" name="email" id="emailReg" <?php if(!empty($_SESSION['email'])) echo("value='".$_SESSION['email']."'"); ?> required><br>

          <input type="Submit" value="Zarejestruj">
      </form>
    </div>

    <div class="logowanie">
    <br><h3>Zaloguj się</h2>
    <form method="post" action="logowanie.php">   <!-- Drugi formularz - LOGOWANIE  -->
      <label for="loginLogin">Podaj swój login: </label>       <input type="text" name="login" id="loginLogin" required><br><br>
      <label for="passwordLogin">Podaj swoje hasło: </label>   <input type="password" name="password" id="passwordLogin" required><br>
        <input type="Submit" value="Zaloguj">
    </form>
  </div>
  </div>
</div>
<?php  include_once('footer.php');?>
</BODY>
</HTML>
