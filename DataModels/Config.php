<?php
error_reporting(1);
ini_set('max_execution_time', 0);
ini_set('post_max_size', '64M');
ini_set('upload_max_filesize', '64M');
if (!session_start()) {session_start();}

class ConfigModels
{

    private $host;
    private $Database;
    private $Port;

    public function getHost()
    {
        return $this->host;
    }

    public function setHost($host)
    {
        if (!$host) {
            print_r("Please add host name in .env file");
            exit();
        }
        $this->host = $host;
    }

    public function getDatabase()
    {
        return $this->Database;
    }

    public function setDatabase($Database)
    {
        if (!$Database) {
            print_r("Please add Database name in .env file");
            exit();
        }
        $this->Database = $Database;
    }

    public function getPort()
    {
        return $this->Port;
    }

    public function setPort($Port)
    {
        $this->Port = $Port;

        return $this;
    }
}

?>