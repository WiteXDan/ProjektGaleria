
<?php
session_start();
include '../connect.php';

$user = $_SESSION['user']['id'];
print_r($user);

$sql = "SELECT id FROM albumy WHERE id_uzytkownika = ".$user."";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result))
{
	$dirPath="../img/".$row['id']."/";
	$files = glob($dirPath . '*', GLOB_MARK);
			foreach ($files as $file) {
					if (is_dir($file)) {
							self::deleteDir($file);
					} else {
							unlink($file);
					}
			}
	rmdir($dirPath);
	$sqlb = "DELETE FROM zdjecia WHERE id_albumu = ".$row['id']."";
	mysqli_query($conn, $sqlb);
}
$row = mysqli_fetch_array($result);
$sqla = "DELETE FROM albumy WHERE id_uzytkownika = ".$user."";
mysqli_query($conn, $sqla);
$sqlc = "DELETE FROM uzytkownicy WHERE uzytkownicy.id = ".$user.";";
mysqli_query($conn, $sqlc);
$callback = ''.$user.' został usunięty \\n';

if(!empty($callback)){
	echo"<script type='text/javascript'>alert('$callback'); window.location = 'index.php?page=uzytkownicy_admin&id=".$user."';</script> ";
}
//header("Location: index.php?content=uzytkownicy_admin&sort=".$_SESSION['user']['sort']."&id=".$row['id']."");
?>
