<!-- Poprawnić skalowanie -->
<?php
include_once('connect.php');
session_start();
/* Wykonanie zaputania SQL */
$login = $_POST['login'];
$haslo = $_POST['password'];
$email = $_POST['email'];

function sprawdz()
{ global $login, $haslo, $email, $conn;
  $callback = "";

  $sql = mysqli_query($conn, "SELECT `login` FROM `uzytkownicy` WHERE `login` LIKE '".$login."'");

//  print_r( mysqli_num_rows($sql));
 if(mysqli_num_rows($sql)) $callback .= "Podany login jest zajęty.\\n";
  if(empty($login)) $callback .= "Podaj login.\\n";
  if(!ctype_alnum($login)) $callback .= "Login może zawierać tylko litery lub cyfry.\\n";
  if(!(mb_strlen($login) >=6 && mb_strlen($login) <=20)) $callback .= "Login może mieć od 6 do 20 znaków.\\n";

  if(empty($haslo)) $callback .= "Podaj hasło.\\n";
  if(!(preg_match('/((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]))/', $haslo))) $callback .= "Hasło - Minimum 1 duża litera, 1 mała litera i 1 cyfra\\n";
  if(mb_strlen($haslo) <6 && mb_strlen($haslo) >20) $callback .= "Hasło może mieć od 6 do 20 znaków.\\n";
  if($_POST['passwordConf']!=$haslo) $callback .= "Hasła muszą być identynczne.\\n";

  if(empty($email)) $callback .= "Podaj email.\\n";
   return $callback;
}
  $callback = sprawdz();
//  echo $callback;

if($callback == '') {
    $sql = "INSERT INTO uzytkownicy
            SET login ='".$login."',
                haslo ='".md5($haslo)."',
                email ='".$email."',
                zarejestrowany = now()";
  mysqli_query($conn, $sql);
  $_SESSION["login"] = $login;
  $_SESSION["password"] = md5($haslo);
  $_SESSION["email"] = $email;
  $_SESSION['logged'] = 1;
    $plyk = mysqli_insert_id($conn);
  $_SESSION['id'] = $plyk;
  $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT `uprawnienia` FROM `uzytkownicy` WHERE `login` LIKE '".$login."'"));
$_SESSION["uprawnienia"] = $r['uprawnienia'];
  header("Location: rejestracja-ok.php");
}
else{
  $_SESSION["callback"] = $callback;

  $_SESSION["login"] = $login;
  $_SESSION["password"] = $haslo;
  $_SESSION["email"] = $email;
  header("Location: index.php");
}
?>
