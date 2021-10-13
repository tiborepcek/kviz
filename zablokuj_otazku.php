<?php
    $subor_blokovanie = 'otazka'.$_POST['otazka'].'.blok';
    $subor_blokovanie_otvorit = fopen($subor_blokovanie, "a") or die("Nepodarilo sa otvoriť súbor!");
    fclose($subor_blokovanie_otvorit);
?>

<html>
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" type="text/css" href="style.css">
      <title>Kvíz - blok</title>
   </head>

   <body>
        <?php
            $dalsia_otazka = $_POST["otazka"] + 1;
            if ($dalsia_otazka <= $_POST["otazokSpolu"]):
                echo '<h1>Otázka zablokovaná: kvíz ' . str_replace("_", " ", ucfirst($_POST["kviz"])) . ', otázka ' . $_POST["otazka"] . '</h1>
                ';
                echo '<h2 class="centrovane"><a href="moderator.php?otazka='. $_POST["otazka"] .'">Späť na otázku</a> alebo <a href="moderator.php?otazka='. $dalsia_otazka .'">Prejsť na ďalšiu otázku</a></h2>
                ';
            else:
                echo "<h1>Otázka zablokovaná: kvíz " . str_replace("_", " ", ucfirst($_POST["kviz"])) . ", otázka " . $_POST["otazka"] . "</h1>
                ";
                echo '<h2 class="centrovane">Toto bola posledná otázka kvízu. Počkajte na výsledky, ktoré oznámi moderátor.</h2>
                ';
                echo '<h2 class="centrovane"><a href="moderator.php?otazka='. $_POST["otazka"] .'">Späť na otázku</a></h2>
                ';
            endif;
        ?>
   
   </body>
</html>
