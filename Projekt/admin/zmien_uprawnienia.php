<?php
session_start();
include '../connect.php';

$uprawnienia = $_POST['uprawnienia'];
$user = $_POST['id'];

$sql = "UPDATE uzytkownicy SET uprawnienia = '".$uprawnienia."' WHERE uzytkownicy.id = '".$user."';";
mysqli_query($conn, $sql);
$callback = ''.$user.' Otrzymał uprawnienia: '.$uprawnienia.' \\n';
print_r($user);
if(!empty($callback)){
	echo"<script type='text/javascript'>alert('$callback'); window.location = 'index.php?page=uzytkownicy_admin&sort=".$_SESSION['user']['sort']."&id=".$user."';</script> ";
}
//header("Location: index.php?content=uzytkownicy_admin&sort=".$_SESSION['user']['sort']."&id=".$row['id']."");
?>
