<?php include 'menu.php'; ?>
<body>
<div id="outer-galeria">
	<div id="container-galeria">
		<?php

			echo "<h1>Najnowsze Zdjęcia</h1><br>";
		 	
			$sql = "SELECT zdjecia.* , albumy.id AS album_id,  uzytkownicy.login FROM zdjecia
						LEFT JOIN albumy ON zdjecia.id_albumu = albumy.id
						LEFT JOIN uzytkownicy ON albumy.id_uzytkownika = uzytkownicy.id
						WHERE zdjecia.zaakceptowane 
                        GROUP BY id
						ORDER BY data DESC
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