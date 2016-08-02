<html>
<body>
<form action="http://localhost/~abarray/php-test/tp4_2.php" method="POST">

	<fieldset>
	
	<legend>Contactez nous</legend>
	<br>
	<label>Destinataire : </label>

	<select id="dest" name="dest">
		<option value="anais.barray@gmail.com">Cerise@gmail</option>
		<option value="siana0_0@hotmail.com">Cerise@hotmail</option>
	</select>
	<br><br>
	
	<input type="text" id="name" name="name" placeholder="Nom Prenom" value="<?php echo isset($_REQUEST['name'])? $_REQUEST['name'] : '' ?>">
	<input type="text" id="objet" name="objet" placeholder="Objet du mail" value="<?php echo isset($_REQUEST['objet'])? $_REQUEST['objet'] : '' ?>">
	<br>
	
	<textarea id="corps" name="corps" placeholder="Veuillez ecrire votre message" cols="49" rows="10"><?php echo isset($_REQUEST['corps'])? $_REQUEST['corps'] : '' ?></textarea>
	<br><br>
	
	Format de l'email :
	<input type="radio" name="enc" id="enc-html">
	<label for="enc">HTML</label>
	<input type="radio" name="enc" id="enc-text" checked>
	<label for="enc">texte</label>
	<br><br>
	
	<input type="submit" value="Envoyer">
	
	</fieldset>
	
</form>
</body>
</html>
