# Backup-To-Dropbox
###Quick solution to backup files and database on Dropbox, automatically with no costs.

Most web hosts have the ability via their control panel to offer an entire site backup, most not. So this is quick and dirty solution in php to **automatize backup of files and database, pack everything and send to your dropbox account**.

####what you need:
- At least PHP 5.3
- [*PclZip*](http://www.phpconcept.net/pclzip/) lib (included into the master) or any lib to handle zip
- [*Dropbox PHP SDK*](https://www.dropbox.com/developers/core/sdks/php) (included into the master)
- Dropbox API keys

####Steps:
- download the master, decompress and upload it on your hosting
- Register an app on [Dropbox App Console](https://www.dropbox.com/developers/apps) to get API key, secret and accesstoken.
- edit *config-dropbox.json* with *key* and *secret*
- edit *config.php* with accesstoken and other personnel configuration and options
- test it calling *index.php*, then you can **set a cronjob** to call it periodically.

####Options:
- you can backup only data or database, or both
- you can specify a directory to backup
- you can exclude some file or directory from the backup's directory.
