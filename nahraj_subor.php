<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Cache-Control" content="no-store" />
		<meta http-equiv="Cache-Control" content="no-cache" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="expires" content="mon, 27 sep 2010 14:30:00 GMT" />
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Nahrávanie súboru</title>
	</head>

	<body>
		<h1>Nahrávanie súboru</h1>
		<?php
		$uploadDirectory = '';
		if(isset($_FILES['subor'])){
			$allowedExtensions = array(
				'png', 'jpg', 'mp3', 'mp4', 'tsv', 'html'
			);
			$file = $_FILES['subor'];
			$name = $file['name'];
			$extension = pathinfo($name, PATHINFO_EXTENSION);
			$extension = strtolower($extension);
			if(!in_array($extension, $allowedExtensions)){
				echo '<p class="dolezite centrovane">Koncovka súboru <strong>' . $extension . '</strong> nie je povolená.</p>';
			} else{
				$tmpLocation = $file['tmp_name'];
				$newLocation = $uploadDirectory . $name;
				$move = move_uploaded_file($tmpLocation, $newLocation);
				echo '<p class="centrovane">Súbor <strong>' . $name . '</strong> bol práve nahratý.</p>';
			}    
		}
		?>
		<p class="centrovane"><a href="sprava.php">Späť na správu kvízov</a></p>
	</body>
</html>
