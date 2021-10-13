<?php
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirect);
    exit();
}

$kviz = file_get_contents("./kviz.include");
$otazky = "otazky-".$kviz.".tsv";
$otazok_spolu = count(file($otazky));
$subor_otazok = file_get_contents($otazky, true);
$subor_otazok_riadok = explode("\n", $subor_otazok);
?>

<html>
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" type="text/css" href="style.css">
      <title>Kvíz <?php echo str_replace("_", " ", ucfirst($kviz)) ?> - hráč</title>
   </head>

   <body>
        <?php
            $meno = $_GET['meno'];
            $email = $_GET['email'];
            $otazka = $_GET['otazka'];
            $dalsia_otazka = $otazka + 1;

            zobraz($otazka);

            function zobraz($otazka) {
                global $kviz, $meno, $email, $otazok_spolu, $subor_otazok, $subor_otazok_riadok, $dalsia_otazka;
                    if (file_exists("otazka".$otazka.".blok") or file_exists("kviz.blok")) {
                        echo '<h1 class="dolezite">Kvíz ' . str_replace("_", " ", ucfirst($kviz)) . ', hráč ' . $meno . ', e-mail ' . $email . ', otázka ' . $otazka . ' - táto otázka je zablokovaná.</h1>
                        ';
                        echo "<h2><a href=\"?meno=" . $meno . "&email=". $email . "&otazka=". $dalsia_otazka ."\">Prejsť na ďalšiu otázku</a></h2>
                        ";
                        echo "</body>
                        ";
                        echo "</html>
                        ";
                        die();
                    }
                    $dalsia_otazka = $otazka + 1;
                    $predosla_otazka = $otazka - 1;
                    echo "<h1>Otázka " . $otazka . " / ". $otazok_spolu . "</h1>
                    ";
                    $subor_otazok_riadok_cast = explode("\t", $subor_otazok_riadok[$predosla_otazka]);
                    echo '<div class="centrovane"><form action="zapis_odpoved.php" method="post"> 
                    ';
                    echo '  <input type="hidden" name="meno" value="' . $meno . '" />
                    ';
                    echo '  <input type="hidden" name="email" value="' . $email . '" />
                    ';
                    echo '  <input type="hidden" name="kviz" value="' . $kviz . '" />
                    ';
                    echo '  <input type="hidden" name="otazka" value="' . $otazka . '" />
                    ';
                    echo '  <input type="hidden" name="otazokSpolu" value="' . $otazok_spolu . '" />
                    ';
                    echo '  <input type="submit" name="odpoved" value="A" />
                    ';
                    echo '  <input type="submit" name="odpoved" value="B" />
                    ';
                    echo '  <input type="submit" name="odpoved" value="C" />
                    ';
                    echo '  <input type="submit" name="odpoved" value="D" />
                    ';
                    echo '</form><p>Kvíz: '.str_replace("_", " ", ucfirst($kviz)).'<br />Hráč: '.$meno.'<br />E-mail: '.$email.'</p></div> 
                    ';
            }
        ?>