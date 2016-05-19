@echo off
set PHP_BIN="php.exe"
set PHP_INI="php.ini"
set HOST_PORT=9000

rem Navigate to /web folder
cd web

rem Execute built-in server (use only to development)
%PHP_BIN% -S localhost:%HOST_PORT% -c %PHP_INI% "index.php"

rem pause is used for retrieve erros in setup variables (remove if setup is ok)
pause
