<?php
## Author Davide Calignano
## BackupToDropbox v1.0

# Include class to make zip
require_once "pclzip.lib.php";

# Include config
require_once "config.php";

# Include the Dropbox SDK libraries
require_once "dropbox-sdk/lib/Dropbox/autoload.php";
use \Dropbox as dbx;


function createZip($files, $output_file){
    $archive = new PclZip($output_file);
    $v_list = $archive->create($files);
    if ($v_list == 0) {
        die("Error : ".$archive->errorInfo(true));
    }
}


function uploadOnDropbox($zip_file){
    $appInfo = dbx\AppInfo::loadFromJsonFile("config-dropbox.json");
    $dbxClient = new dbx\Client(ACCESSTOKEN, "backups");

    echo("Uploading $zip_file to Dropbox\n");
    $f = fopen($zip_file, "rb");
    $result = $dbxClient->uploadFile("/backups/".$zip_file, dbx\WriteMode::force(), $f);
    fclose($f);
}


function backupDB(){
    $cmd = "mysqldump --hex-blob --routines --skip-lock-tables --log-error=mysqldump_error.log -h ".SERVERNAME." -u ".USERNAME." -p".PASSWORD." ".DBNAME." > " . SQL_NAME;
    $arr_out = array();
    unset($return);

    exec($cmd, $arr_out, $return);

    if($return !== 0) {
        echo "mysqldump for ".SERVERNAME." : ".DBNAME." failed with a return code of {$return}\n\n";
        echo "Error message was:\n";
        $file = escapeshellarg("mysqldump_error.log");
        $message = `tail -n 1 $file`;
        echo "- $message\n\n";
    }
}


# Compose array of files to backup
$filesToBackup = array();
if(BACKUP_FILE){
    array_push($filesToBackup, DIR_TO_BACKUP.implode (",".DIR_TO_BACKUP, array_diff( scandir(DIR_TO_BACKUP), array_merge(array(".", ".."), $excludeFromBackup) )));
}
if(BACKUP_DB){
    backupDB();
    array_push($filesToBackup, SQL_NAME);
}
if(!count($filesToBackup)){
    echo "no backup, check your config.php file";
    exit;
}


# Create zip archive locally
createZip(implode(",", $filesToBackup), BACKUP_NAME);
# Upload on Dropbox
uploadOnDropbox(BACKUP_NAME);


# Remove file locally
if(BACKUP_FILE){ unlink(BACKUP_NAME); }
if(BACKUP_DB){ unlink(SQL_NAME); }

?>