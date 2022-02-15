   <?php
require_once 'DbConnect.php';
require_once 'GetSalary.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type');

$data = file_get_contents('php://input');
$data = json_decode($data, true);

$id = (int) $data['id'];

class CalculateSalary
{
    public function CalculateEmpSalary($id)
    {

        $db = new Dbquery();

        $results = $db->FindQuerry("Tbl_Employee", ['_id' => $id]);
        $datamangerResult = $results->toArray();

        foreach ($datamangerResult as $row) {
            $data[] = (array) $row;
        }

        if (!$data) {
            $message = "false";
            $data2[] = array("error" => "Employee details not found");
            echo json_encode(array("Status" => $message, "data" => $data2));
            return;

        } else {

            $Band = $data[0]['Band'];
            $Rating = $data[0]['Rating'];

            $results = $db->FindQuerry("Tbl_BandSalary", ['_id' => $Band]);
            $dataBandResult = $results->toArray();

            foreach ($dataBandResult as $row) {
                $dataBand[] = (array) $row;

            }

            $Salary = $dataBand[0]['Salary'];

            $dataresult['Salary'] = $Salary;
            $dataresult['Rating'] = $Rating;
            $dataresult['Band'] = $Band;
            $dataresult['id'] = $id;

            return $dataresult;

        }

    }
}

$db = new CalculateSalary();

$Valid = $db->CalculateEmpSalary($id);

$Band = $Valid['Band'];

switch ($Band) {

    case "1":
        $db = new BandSalaryA();
        $Valid = $db->CalculateSalary($Valid);

        
        $message = "true";
        $data2[] = array(

            "Salary" => $Valid,

        );
        echo json_encode(array("Status" => $message, "data" => $data2));
        return;

        break;

    case "2":

        $db = new BandSalaryB();
        $Valid = $db->CalculateSalary($Valid);
        $message = "true";
        $data2[] = array(

            "Salary" => $Valid,

        );

        echo json_encode(array("Status" => $message, "data" => $data2));
        return;

        break;

    case "3":
        $db = new BandSalaryC();

        $Valid = $db->CalculateSalary($Valid);
        $message = "true";
        $data2[] = array(

            "Salary" => $Valid,

        );

        echo json_encode(array("Status" => $message, "data" => $data2));
        return;

        break;

}
?>