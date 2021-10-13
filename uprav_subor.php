<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Cache-Control" content="no-store" />
		<meta http-equiv="Cache-Control" content="no-cache" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="expires" content="mon, 27 sep 2010 14:30:00 GMT" />
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Úprava otázok kvízu</title>
		<script>
		function validateForm() {
		  var x = document.forms["uprava"]["text"].value;
		  if (x == "") {
			alert("Zadaj text, ktorý chceš uložiť.");
			return false;
		  }
		}
		</script>
	</head>

	<body>
		<h1>Úprava otázok kvízu</h1>
		<?php $text = file_get_contents($_GET["subor"]); ?>
		<form name="uprava" action="zapis_upravu_suboru.php" onsubmit="return validateForm()" method="post">
		<textarea name="text" required><?php echo htmlspecialchars($text) ?></textarea>
		<input type="hidden" name="subor" value="<?php echo $_GET["subor"] ?>" />
		<input type="submit" name="uloz" value="Uložiť" />
		</form>
		<p class="centrovane"><a href="sprava.php">Späť na správu kvízov</a></p>
	</body>
</html>


