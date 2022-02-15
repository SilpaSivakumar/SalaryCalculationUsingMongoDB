<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database file
include_once 'Dbconnect.php';
include_once 'DataModels/Employee_Model.php';
include_once 'Validations/Validate.php';

$dbname = 'EmployeeDetails';
$collection = 'Tbl_Employee';

//DB connection
$db = new DbManager();
$conn = $db->getConnection();

//record to add
$data = (array) json_decode(file_get_contents("php://input", true));

$EmpValidate = new EmployeeValidator();

$Isvalid = $EmpValidate ->ValidateEmployee($data);

if ($Isvalid == "True") {


    $insert = new MongoDB\Driver\BulkWrite();

    $insert->insert($data);

    $result = $conn->executeBulkWrite("$dbname.$collection", $insert);


    if ($result->getInsertedCount() == 1) {
        echo json_encode(
            array("message" => "Record successfully created")
        );
    } else {
        echo json_encode(
            array("message" => "Error while saving record")
        );
    }
}
else
{
    echo json_encode(
        array("message" => "Error while saving record"));
}