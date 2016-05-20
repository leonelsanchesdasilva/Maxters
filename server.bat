@echo off

rem setup PHP
set PHP_BIN="c:\php\php.exe"
set PHP_INI="c:\php\php.ini"
set HOST_PORT=9000

rem Navigate to web folder
cd web

rem execute built-in server
%PHP_BIN% -S localhost:%HOST_PORT% -c %PHP_INI%

rem Prevent close if PHP failed to start
pause
