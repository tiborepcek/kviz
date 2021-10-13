# Moderovaný online kvíz

Tento moderovaný online kvíz som vytvoril tak, aby nevyžadoval žiadny databázový server. Všetko je ukladané do textových súborov a hosting je tak možný aj na bezplatných platformách s podporou PHP. Tiež nie je potrebná žiadna registrácia alebo inštalácia aplikácie. Všetko funguje rovnako dobre cez web na mobile, tablete, notebooku alebo stolovom počítači.

Na server sú kladené minimálne nároky, pretože som sa kompletne vyhol takému niečomu ako jQuery. Miestami využívam iba veľmi jednoduchý JavaScript.

## Vzhľad

Vzhľad je veľmi jednoduchý a je definovaný pre všetky stránky v `style.css`. Hlavným cieľom vzhľadu je šetrenie životného prostredia pomocou čierneho režimu pri dobrej čitateľnosti textu a dobrej pozerateľnosti obrázkov a videí.

## Bodovanie

Za každú správnu odpoveď hráč získava 4 body. Za každú prvú správnu odpoveď hráč získava 1 bod. Na každú otázku je vždy práve jedna správna odpoveď (A, B, C alebo D). Ak sa po vyhodnotení stane, že niektorí hráči majú rovnaký počet bodov, je pripravená rozstrelová otázka. Kto na ňu odpovie správne prvý, ten vyhráva.

## Takto to funguje

- stránka pre správcu kvízu: https://tiborepcek.com/kviz-demo/sprava.php (heslo: `demo`)
- stránka pre moderátora kvízu: https://tiborepcek.com/kviz-demo/moderator.php?otazka=1 (heslo: `demo`)
- stránka na prihlásenie hráča: https://tiborepcek.com/kviz-demo/

## Závislosti na kóde tretích strán

1. Obrázok s QR kódom (zobrazený v súboroch `index.php` a `popis.php`) vytvára [PHP QR Code](https://sourceforge.net/projects/phpqrcode/) - súbor `phpqrcode.php`
1. Zabezpečenie stránky heslom (súbory `moderator.php` a `sprava.php`) poskytuje [Web Page Password Protect](http://www.zubrag.com/scripts/password-protect.php) - súbor `ochrana.php`

## Textové databázové súbory

1. otázky sú pripravené vo formáte TSV a vypísať ich je možné pomocou `sprava.php`
1. odpovede sa ukladajú vo formáte CSV a vypísať ich je možné pomocou `sprava.php`

Sada otázok (súbor s koncovkou tsv, čiže kvíz) je zapísaná v konfiguračnom súbore `kviz.include`, ktorý obsahuje iba názov kvízu. Tento názov je možné prepísať pomocou `sprava.php`. Podľa názvu sa vyberá sada otázok, čiže kvíz.

## Obslužná časť kvízu

1. `hrac.php` je pre hráča, využíva iba zapis_odpoved.php a ideálne je načítať ho cez mobil, preto obsahuje QR kód s URL generovaný pomocou phpqrcode.php. V prípade, že mobil nedokáže URL z QR kódu načítať, URL je pod QR kódom aj vypísaná. Pod URL je ešte v zátvorkách zapísaný názov kvízu (čiže sady otázok).
1. `moderator.php je` pre moderátora, obsahuje znenie otázok a možností odpovedí, využíva `zablokuj_otazku.php`, `odblokuj_otazku.php`, `odblokuj_vsetky_otazky.php` a ideálne je načítať ho na veľkom monitore (TV), aby hráči na obsah dobre videli. Online moderovanie je možné cez aplikácie ako napr. [Zoom](https://zoom.us/).
1. `sprava.php` je pre administrátora kvízov. Umožňuje nahrávať nové kvízy (text v tsv, obrázky v jpg a png, zvuk v mp3 a video v mp4) pomocou `nahraj_subor.php`, vybrať kvíz (použiť) pomocou `zapis_nazov_kvizu.php`, upravovať text nahraných kvízov pomocou `uprav_subor.php` a `zapis_upravu_suboru.php`, zobrazovať odpovede pomocou `zobraz_odpovede.php` a vymazať odpovede pomocou `vymaz_subor.php`.

### Po ukončení kvízu

1. `1_stiahni_nazov_kvizu.bat` - stiahne súbor `kviz.include`, ktorý je potrebný pre vytvorenie `poradie.html` pomocou `vyhodnot.au3`
1. `2_stiahni_odpovede.bat` - po ukončení kvízu si moderátor stiahne odpovede (súbor s koncovkou TSV), aby ich mohol vyhodnotiť pomocou `vyhodnot.au3` a výsledok zapísať do `poradie.html`
