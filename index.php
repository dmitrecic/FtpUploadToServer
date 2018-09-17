<?php
require("classes/FtpUploadToServer.class.php");

$ftp=new FtpUploadToServer("croatia-accommodation.info","testclass","d02061973","21");
$ftp->setShowMessages(1);
$ftp->setShowStatus(1);
$ftp->setCreateFolder(1);
$ftp->setFileOverwrite(1);
$ftp->setFolder("testclass/insidefolder");
$ftp->setFile("test.txt");
$ftp->ftpUpload();

?>