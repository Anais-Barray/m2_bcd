<!-- //http://localhost/~abarray/php-test/ -->
<html>
<body>
 	<p>Paragraphe</p>
 	<?php
 		echo "Salut!"."<br/>";
 		echo 3+5 . "<br/>";
		$a=2; //creation variable
		$b=3;
		$c=$a+$b;
		echo '<h3>texte avec php</h3>'."$c<br/><br/>";
		echo "a = ".$a."<br/>"."b = ".$b."<br/>"."a+b = ".($a+$b).'<h4>boucle : </h4>';
		for ($i=0; $i<=5; $i++){
			echo ($i*2)."<br/>";
		}
 		echo date('Y-m-d H:i:s') . "<br/>";
 		echo $_SERVER["REMOTE_ADDR"]."<br/>";
 		echo $_GET["p"]; // http://localhost/~abarray/php-test/ex.php?p=toto
 	?>
</body>
</html>
