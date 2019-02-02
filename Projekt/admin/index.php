<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<?php
	session_start();
	include_once('../connect.php');
	include('../menu.php');
	error_reporting(E_ALL ^ E_NOTICE);
?>
<body>
	<div class='subbar'>
	<a href="index.php?page=album">
		<div id="Albumy">
			Albumy
		</div>
	</a>

	<a href="index.php?page=zdjecia">
		<div id="Zdjecia">
			Zdjecia
		</div>
	</a>

	<a href="index.php?page=komentarze">
		<div id="Komentarze">
			Komentarze
		</div>
	</a>

	<a href="index.php?page=uzytkownicy_admin">
		<div id="Uzytkownicy">
			Uzytkownicy
		</div>
	</a>

<a href="index.php?page=album">
	<div id="Powrot">
		Powrot
	</div>
</a>
</div>
</body>

<?php
	if(isset($_GET['page']))
		if($_GET['page']=='album') include_once('Albumy.php');
		elseif($_GET['page']=='zdjecia') include_once('Zdjecia.php');
		elseif($_GET['page']=='komentarze') include_once('Komentarze.php');
		elseif($_GET['page']=='uzytkownicy_admin')    include 'uzytkownicy_admin.php';
?>
