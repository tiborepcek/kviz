<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Cache-Control" content="no-store" />
		<meta http-equiv="Cache-Control" content="no-cache" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="expires" content="mon, 27 sep 2010 14:30:00 GMT" />
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Zápis názvu kvízu</title>
	</head>

	<body>
		<h1>Zápis názvu kvízu</h1>
		<?php
			file_put_contents("kviz.include", $_GET["kviz"]);
		?>
		<p class="centrovane">Kvíz <strong><?php echo $_GET["kviz"] ?></strong> bol práve aktivovaný.</p>
		<p class="centrovane"><a href="sprava.php">Späť na správu kvízov</a></p>
	</body>
</html>