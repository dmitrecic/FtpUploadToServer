<?php

class FtpUploadToServer
{
    const VERSION="1.1";            // this version - just for fun :)
                                    // let's set some default variables 
    private $ftp_folder="/";        // folder at the server where the file will be uploaded - set it to root
    private $ftp_file="";           // file to be uploaded to server
    private $createfolder=0;        // if destination folder doesn't exists - 0 = don't create folder ; 1= create folder
    private $fileoverwrite=1;       // if destination file exists - 0=don't overwrite with new file ; 1= overwrite with new file
    private $showmessages=1;        // show FtpUploadToServer? 0=no ; 1=yes
    private $timeout=60;            // FTp connection timeout
    private $passivemode=1;         // passive mode - 0=off ; 1=on
    private $uploadmode=FTP_ASCII;  // FTP upload mode - FTP_ASCII or FTP_BINARY
    private $showstatus=1;            // show upload status 0=none ; 1=show status (success/fail)

    public function setFolder($folder)
    {
        $this->ftp_folder=$folder;
    }

    public function setFile($file)
    {
        $this->ftp_file=$file;
    }

    public function setCreateFolder($cfolder)
    {
        $this->createfolder=$cfolder;
    }

    public function setFileOverwrite($foverwrite)
    {
        $this->fileoverwrite=$foverwrite;
    }

    public function setShowMessages($smessages)
    {
        $this->showmessages=$smessages;
    }

    public function setTimeOut($stimeout)
    {
        $this->timeout=$stimeout;
    }

    public function setPassiveMode($spmode)
    {
        $this->passivemode=$spmode;
    }

    public function setUploadMode($sumode)
    {
        $this->uploadmode=$sumode;
    }

    public function setShowStatus($stmode)
    {
        $this->showstatus=$stmode;
    }

    function __construct($hostname, $username, $password,$port ){
        $this->hostname=$hostname;
        $this->username=$username;
        $this->password=$password;
        $this->port=$port;
    }

    public function ftpUpload()
    {
        $this->showMessage("PHP FTP uploader Version ".self::VERSION);
        if ($this->connectToServer()) {
            if($this->uploadFile()){
                $this->showStatus("success");
            } else {
                $this->showStatus("fail");
            }
            $this->closeConnection();

        } else {
            $this->showStatus("fail");

        }
    }

    private function connectToServer()
    {
           $this->ftpconn_id=@ftp_connect ($this->hostname , $this->port, $this->timeout);
           if(is_resource($this->ftpconn_id)) {
                if (@ftp_login ($this->ftpconn_id, $this->username, $this->password)){
                    @ftp_pasv($this->ftpconn_id,$this->passivemode);
                    $this->showMessage("FTP connection established");
                    $this->showMessage("Logged in");
                    return true;

                } else {
                    $this->showMessage("Login error: Please check your username and password for the host ".$this->hostname);

                }
            } else {
                $this->showMessage("Connection error: check hostname and port (current Host:".$this->hostname."  Port:".$this->port.")");

            }

        return false;
    }

    private function uploadFile()
    {
        if(@ftp_chdir($this->ftpconn_id,$this->ftp_folder)) {

            $remotefileexists=@ftp_size($this->ftpconn_id, $this->ftp_file);

            if ($remotefileexists<0 || ($remotefileexists>=0 && $this->fileoverwrite==1 )) {

                @ftp_chmod($this->ftpconn_id, 0644, $this->ftp_file);
                
                if(ftp_put($this->ftpconn_id,$this->ftp_file,$this->ftp_file, $this->uploadmode))
                {
                    $this->showMessage("File ".$this->ftp_file." successfuly uploaded");
                    return true;

                } else {
                    $this->showMessage("Error! File ".$this->ftp_file." cannot be uploaded!");

                }

            } else {
                $this->showMessage("File ".$this->ftp_file." exists! File not uploaded - fileoverwrite disabled!");

            }

        } else {
            if ($this->createfolder==1) {
                if (@ftp_mkdir($this->ftpconn_id, $this->ftp_folder)){
                    $this->uploadFile();

                } else {
                    $this->showMessage("Cannot create folder at host ".$this->hostname);

                }

            } else {
                $this->showMessage($this->hostname." directory ".$this->ftp_folder." not exists!");

            }
            
        }

        return false;
        
    }


    private function closeConnection()
    {
        ftp_close($this->ftpconn_id);
        $this->showMessage("FTP connection closed");
        return true;
    }

    private function showMessage($message)
    {
        if ($this->showmessages) {
            echo $message."<br/>";

        }
    }

    private function showStatus($message)
    {
        if($this->showstatus){
            echo $message;

        }
    }

    public function __destruct(){
        
    }
}

?>