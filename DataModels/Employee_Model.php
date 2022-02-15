<?php
error_reporting(1);
ini_set('max_execution_time', 0);
ini_set('post_max_size', '64M');
ini_set('upload_max_filesize', '64M');
if (!session_start()) {session_start();}

class EmployeeModel
{

    private $Name;
    private $Age;
    private $Band;
    private $Rating;
    private $Managed;
    

  public function getName()
    {
        return $this->Name;
    }

   
    public function setName($Name)
    {
        $this->Name = $Name;

        return $this;
    }


     public function getAge()
    {
        return $this->Age;
    }
 
    public function setAge($Age)
    {
        $this->Age = $Age;

        return $this;
    }
 
    public function getBand()
    {
        return $this->Band;
    }
 
    public function setBand($Band)
    {
        $this->Band = $Band;

        return $this;
    }

    
    public function getRating()
    {
        return $this->Rating;
    }

   
    public function setRating($Rating)
    {
        $this->Rating = $Rating;

        return $this;
    }
 
    public function getManaged()
    {
        return $this->Managed;
    }

   
    public function setManaged($ManagedBy)
    {
        $this->Managed = $ManagedBy;

        return $this;
    }
    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    public function __unset($name)
    {
        unset($this->data[$name]);
    }
    
}

?>
