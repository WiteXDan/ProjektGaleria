<?php include 'menu.php'; ?>
<body>
<div id="outer-galeria">
	<div id="container-galeria">
		<?php

			echo "<h1>Najwyżej Oceniane Zdjęcia</h1><br>";
		 	
			$sql = "SELECT zdjecia.* , albumy.id AS album_id,  uzytkownicy.login, round(AVG(ocena),1) AS ocen FROM zdjecia
						LEFT JOIN albumy ON zdjecia.id_albumu = albumy.id
						LEFT JOIN uzytkownicy ON albumy.id_uzytkownika = uzytkownicy.id
						LEFT JOIN zdjecia_oceny ON zdjecia_oceny.id_zdjecia = zdjecia.id
						WHERE zdjecia.zaakceptowane AND zdjecia_oceny.ocena != 'NULL'
                        GROUP BY id
						ORDER BY zdjecia_oceny.ocena DESC
						LIMIT 20;";
				
				$result = mysqli_query($conn, $sql);
				if (!$result) {
					printf("Error: %s\n", mysqli_error($conn));
					exit();
				}
				while($row = mysqli_fetch_array($result))
				{
					echo "<a href='foto.php?zdj=".$row['id']."'
							class='zdjecie'><img src='img/".$row['album_id']."/m".$row['id']."'
							title='".$row['opis'].", ".$row['login'].", ".$row['data'].", ".$row['ocen']."'/></a></td>";
				}
				echo "<br>";
				
		?>
	</div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>