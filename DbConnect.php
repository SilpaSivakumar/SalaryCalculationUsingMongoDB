<?php

require_once 'DataModels/Config.php';


class DbManager
{
    private $dbname;
    public function __construct()
    {

        $ENV = __DIR__ . '\.env';

        if (!file_exists($ENV)) {
            print_r("Pls add .env file");
            exit();
        }

        require_once realpath(__DIR__ . '/vendor/autoload.php');
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        $Conf = new ConfigModels();

        $Conf->Sethost($_ENV['HOST']);
        $Conf->SetDatabase($_ENV['DATABASE_NAME']);
        $Conf->SetPort($_ENV['PORT']);

        $server = $Conf->Gethost();
        $this->dbname = $Conf->GetDatabase();
        $dbport = $Conf->GetPort();

        

        try {
            $this->conn = new MongoDB\Driver\Manager('mongodb://' . $server . ':' . $dbport);
        } catch (MongoDBDriverExceptionException $e) {
            echo $e->getMessage();
            echo nl2br("n");
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function getDbname()
    {
        return $this->dbname;
    }
}


class Dbquery extends DbManager
{

    public function FindQuerry($Tablename,$filter)
    {
        $conn = parent::getConnection();

        $options = [
           
        ];

        $read = new MongoDB\Driver\Query($filter, $option);
        $dbname = $this->getDbname() . "." . $Tablename;

          $result = $conn->executeQuery($dbname, $read);

          

         return $result;


        }


}




?>