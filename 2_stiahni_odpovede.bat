@echo off
chcp 65001
echo Stiahne aktuálne odpovede. Potrebuje program curl.
echo.
set /p kviz=<kviz.include
curl -o odpovede-%kviz%.csv https://tiborepcek.com/kviz-demo/odpovede-%kviz%.csv
echo.
echo Po stlačení ľubovoľného tlačidla sa skript ukončí.
echo.
pause > nul