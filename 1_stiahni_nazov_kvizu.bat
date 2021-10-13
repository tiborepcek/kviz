@echo off
chcp 65001
curl -o kviz.include https://tiborepcek.com/kviz-demo/kviz.include
set /p kviz=<kviz.include
echo.
echo Názov aktuálne zvoleného kvízu je: %kviz%
echo.
echo Po stlačení ľubovoľného tlačidla sa skript ukončí.
echo.
pause > nul