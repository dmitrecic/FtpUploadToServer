<?php
require("class/FtpUploadToServer.class.php");

//
// If you want to upload one file to several websites via FTP, here is how to use:
// Insert all websites, where you would like to connect and upload your file, into array
// with FTP details as follows:
//

$websites=array(
        array("ftp.examplesite-1.com", "ftpusername", "ftppassword","21"),
        array("ftp.examplesite-2.com", "ftpusername", "ftppassword","21"),
        array("ftp.examplesite-3.com", "ftpusername", "ftppassword","21"),
);


//
// Now loop array and upload file to each of those websites 
//

foreach($websites as $website=>$ftpdata){

    $ftp=new FtpUploadToServer($ftpdata[0],$ftpdata[1],$ftpdata[2],$ftpdata[3]);
    $ftp->setShowMessages(1);
    $ftp->setShowStatus(1);
    $ftp->setCreateFolder(1);
    $ftp->setFileOverwrite(1);
    $ftp->setFolder("testclass/insidefolder");
    $ftp->setFile("test.txt");
    $ftp->ftpUpload();

}

?>
