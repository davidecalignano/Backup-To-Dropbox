<?php 
## Author Davide Calignano
## BackupToDropbox v1.0

$today = date("Y.m.d_H.i.s");

## APP COSTANTS
## ==============================================
# Choose if backup file, db, or both
define("BACKUP_FILE", true);
define("BACKUP_DB", true);


# Directory to Backup
define("DIR_TO_BACKUP", "../");
# Archive file name 
define("BACKUP_NAME", "Backup_".$today.".zip");
# Database file name 
define("SQL_NAME", "Db_".$today.".sql");
# Access Tocken DropBox
define("ACCESSTOKEN", "YOUR_ACCESS_TOKEN");

# Exclude file and directory from backup,
# you can exclude only the file or folder directly inside DIR_TO_BACKUP)
$excludeFromBackup = array("backup", "other-file-or-folder");

## DB COSTANTS
## ==============================================
define("SERVERNAME", "XXX.XXX.XXX.XXX");
define("USERNAME", "XXXXXXXX");
define("PASSWORD", "XXXXXXXX");
define("DBNAME", "XXXXXXXX");

?>





