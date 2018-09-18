<?php

// How to use FtpUploadToServer class
// Example as follows
// you can loop if there is more then one website where you need to upload your file
// include class file
require("class/FtpUploadToServer.class.php");

// initialize class (format: "ftp server name", "ftp username", "ftp password", "ftp port")

$ftp=new FtpUploadToServer("example.com","username","password","21");

// show messages while trying to connect to FTP? (1=yes, 0=no, default:1)
$ftp->setShowMessages(1);

// show status when upload is finished? (status: succes or fail, 1=yes, 0=no, default:1)
$ftp->setShowStatus(1);

// create folder if destination folder not exists? (1=yes, 0=no, default:0)
$ftp->setCreateFolder(1);

// overwrite destination file if exist? (1=yes, 0=no, default:1)
$ftp->setFileOverwrite(1);

// set destination folder (default:/ - root)
$ftp->setFolder("testclass/insidefolder");

// set file to upload
$ftp->setFile("test.txt");

// finally - upload :)
$ftp->ftpUpload();

?>
