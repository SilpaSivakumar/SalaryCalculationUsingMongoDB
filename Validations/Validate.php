<?php


include_once 'Dbconnect.php';
include_once 'DataModels/Employee_Model.php';


Class EmployeeValidator
{

    Public function ValidateEmployee($data)
    {



       


$Empmodel=new EmployeeModel();


$Empmodel->setName($data['Name']);
$Empmodel->setAge($data['Age']);
$Empmodel->setBand($data['Band']);
$Empmodel->setRating($data['Rating']);
$Empmodel->setManaged($data['ManagedBy']);

$Name= $Empmodel->getName();
$Age = $Empmodel->getAge();
$Band = $Empmodel->getBand();
$Rating = $Empmodel->getRating();
$Managedby = $Empmodel->getManaged();

$message = "True";

if (trim($Name)=="") {
    $message = "false";
    $data2[] = array("error" => "Please enter a name");
    echo json_encode(array("Status" => $message, "data" => $data2));
    return $message;
}

if (filter_var($Age, FILTER_VALIDATE_INT, array("options" => array("min_range" => 0, "max_range" => 120))) === false) {

    $message = "false";
    $data2[] = array("error" => "Age is incorrect ");
    echo json_encode(array("Status" => $message, "data" => $data2));
    return $message;

}

if (filter_var($Rating, FILTER_VALIDATE_INT, array("options" => array("min_range" => 0, "max_range" => 5))) === false) {

    $message = "false";
    $data2[] = array("error" => "Rating is not within the legal range");
    echo json_encode(array("Status" => $message, "data" => $data2));
    return $message;
}



if (!filter_var($Band, FILTER_VALIDATE_INT)) {
    $message = "false";
    $data2[] = array("error" => "SalaryBand not found");
    echo json_encode(array("Status" => $message, "data" => $data2));
    return $message;
    

}

$db = new Dbquery ();
$results = $db->FindQuerry("Tbl_BandSalary", ['_id' => $Band]);

foreach ($results as $Salaryband) {
    $SalaryBandid = $Salaryband->_id;

}

if (!$SalaryBandid) {
    $message = "false";
    $data2[] = array("error" => "SalaryBand not found ");
    echo json_encode(array("Status" => $message, "data" => $data2));
    return $message;
}






if ($Managedby> 0) {

    
  
    $dataEmployeeExist = $db->FindQuerry("Tbl_Employee", ['_id' => $Managedby]);

    foreach ($dataEmployeeExist as $EmployeeMaster) {
        $Empid = $EmployeeMaster->_id;
        $EmpBand = $EmployeeMaster->Band;


    }

    

}



    if ($Empid) {

        $dataCheckmangedby = $db->FindQuerry("Tbl_BandSalary", ['_id' => $EmpBand]);

        foreach ($dataCheckmangedby as $dataCheckmanged) {
            $Bandid = $dataCheckmanged->_id;
           

        }
    }

    
    else {

        $message = "false";
        $data2[] = array("error" => "Manger not found ");
        echo json_encode(array("Status" => $message, "data" => $data2));
        return  $message;
    }
   
        if ($Bandid == 3 && $Band == 1) {

            $message = "false";
            $data2[] = array("error" => "Manager cannot manage a junior employee");
            echo json_encode(array("Status" => $message, "data" => $data2));
            return  $message;

        }
        return $message;
     
    }

}