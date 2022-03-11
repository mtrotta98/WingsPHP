cd C:\xampp\mysql\bin

REM set anio=%date:~6,4%
REM set mes=%date:~3,2%
REM set dia=%date:~0,2% 

mysqldump --host=localhost --user=root --password= wings > C:\xampp\htdocs\Backup\backup.sql
color F4
REM ******************************

REM >>>>>>BACKUP COMPLETADO<<<<<<<

REM ******************************

pause