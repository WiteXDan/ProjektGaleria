<div id="outer-galeria-konto">
	<div id="container-galeria-konto">
	<?php
			if(!isset($_SESSION['user']['sort'])) $_SESSION['user']['sort']= 'tytul';
			if(isset($_GET['sort'])) $_SESSION['user']['sort']=$_GET['sort'];
			$_SESSION['user']['id']= $_GET['id'];

				echo"<div id='user_sort-admin'>";
						if($_SESSION['user']['sort']=='wszyscy'){
							echo "<a href = 'index.php?page=uzytkownicy_admin&sort=wszyscy' class='aktywny'>Wszyscy |</a>";}
						else {
							echo "<a href = 'index.php?page=uzytkownicy_admin&sort=wszyscy' class='nieaktywny'>Wszyscy |</a>";}
						if($_SESSION['user']['sort']=='użytkownik'){
							echo "<a href = 'index.php?page=użytkownicy_admin&sort=użytkownik' class='aktywny'>uzytkownicy |</a>";}
						else {
							echo "<a href = 'index.php?page=uzytkownicy_admin&sort=użytkownik' class='nieaktywny'>uzytkownicy |</a>";}
						if($_SESSION['user']['sort']=='moderator'){
							echo "<a href = 'index.php?page=uzytkownicy_admin&sort=moderator' class='aktywny'>moderatorzy |</a>";}
						else {
							echo "<a href = 'index.php?page=uzytkownicy_admin&sort=moderator' class='nieaktywny'>moderatorzy |</a>";}
						if($_SESSION['user']['sort']=='administrator'){
							echo "<a href = 'index.php?page=uzytkownicy_admin&sort=administrator' class='aktywny'>administratorzy |</a>";}
						else {
							echo "<a href = 'index.php?page=uzytkownicy_admin&sort=administrator' class='nieaktywny'>administratorzy |</a>";}
				echo"</div>";
				if($_SESSION['user']['sort']=='wszyscy') {
					$sql = "SELECT *
									FROM uzytkownicy;";
				}
				else{
					$sql = "SELECT *
									FROM uzytkownicy
									WHERE uprawnienia = '".$_SESSION['user']['sort']."';";
				}

				$result = mysqli_query($conn, $sql);
				if (!$result) {
					printf("Error: %s\n", mysqli_error($conn));
					exit();
				}
				echo"<div id='lista_user-admin'>";

				echo "<br>";
				while($row = mysqli_fetch_array($result))
				{
					if($row['id']==$_GET['id']) echo "<a href = 'index.php?page=uzytkownicy_admin&sort=".$_SESSION['user']['sort']."&id=".$row['id']."' class='cur'><div id='user_card'>".$row['id'].", ".$row['login'].", Aktywny: ".$row['aktywny']."</div></a>";
					else echo "<a href = 'index.php?page=uzytkownicy_admin&sort=".$_SESSION['user']['sort']."&id=".$row['id']."'><div id='user_card'>".$row['id'].", ".$row['login'].", Aktywny: ".$row['aktywny']."</div></a>";
				}
				?>
				</div>
				<div id='user_tool-admin'>
						<form action = 'zmien_uprawnienia.php?' method = 'post' enctype="multipart/form-data">
							<?php
							if(isset($_GET['id'])){
								$sql = "SELECT uprawnienia FROM uzytkownicy WHERE id = ".$_GET['id']."; ";
								$result = mysqli_query($conn, $sql);
								$row = mysqli_fetch_array($result);
								echo"<input name='id' type='hidden' value='".$_GET['id']."' >";
								echo 'Uprawnienia: <select name="uprawnienia" selected="'.$row["uprawnienia"].'" required>';
																		if($row["uprawnienia"]=='uzytkownik')	echo '<option value="użytkownik" selected="selected">uzytkownik</option>';
																		else echo '<option value="użytkownik">użytkownik</option>';
																		if($row["uprawnienia"]=='moderator')	echo '<option value="moderator" selected="selected">moderator</option>';
																		else echo '<option value="moderator">moderator</option>';
																		if($row["uprawnienia"]=='administrator')	echo '<option value="administrator" selected="selected">administrator</option>';
																		else echo '<option value="administrator">administrator</option>';
								echo '</select> <br>';
							}
							else echo 'Uprawnienia: <select name="uprawnienia" required>
																		<option value=""></option>
																 </select> <br>';

							if(!isset($_GET['id'])){echo'<input type="submit" value="Zmień Uprawnienia" disabled>';}else{echo'<input type="submit" value="Zmień Uprawnienia">';}
							?>
						</form>
							<?php
										if(!isset($_GET['id'])){echo'<button id="input_usun" onclick="czy_ban() disabled">Zablokuj Konto</button>';}
										else{echo'<button id="input_usun" onclick="czy_ban()">Zablokuj Konto</button>';}
										if(!isset($_GET['id'])){echo'<button id="input_usun" onclick="czy_unban() disabled">Odblokuj Konto</button>';}
										else{echo'<button id="input_usun" onclick="czy_unban()">Odblokuj Konto</button>';}
										if(!isset($_GET['id'])){echo'<button id="input_usun" onclick="czy_usun() disabled">Usuń Konto</button>';}
                                        else{echo'<button id="input_usun" onclick="czy_usun()">Usuń Konto</button>';}

							?>


							<script>
							function czy_ban(){
								if(confirm("Czy chcesz zablokować konto <?php echo "".$_SESSION['user']['id']."" ?>?"))
								window.location.replace("zbanuj_konto.php?");
							}
							function czy_unban(){
								if(confirm("Czy chcesz odblokować konto <?php echo "".$_SESSION['user']['id']."" ?>?"))
								window.location.replace("odbanuj_konto.php?");
							}
							function czy_usun(){
                                if(confirm("Czy chcesz usunąć konto <?php echo "".$_SESSION['user']['id']."" ?>? Usunięte zostaną wszystkie powiązane albumy i zdjęcia!"))
                                window.location.replace("usun_konto.php");
                            }
							</script>
			</div><br>
	</div>
</div>
