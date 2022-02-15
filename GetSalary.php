<?php
require_once 'DbConnect.php';
require_once 'EmployeeSalary.php';

class BandSalaryA 
{
    public function CalculateSalary($data)
    {

        $Salary = $data['Salary'];

        $this->rating = $data['Rating'];
        $this->id = $data['id'];

        return $Salary;

    }

}

class BandSalaryB extends BandSalaryA
{public function CalculateSalary($data)
    {
    $data = parent::CalculateSalary($data);

    $Salary = $data + ($data * $this->rating / 5);

    return $Salary;

}

}

class BandSalaryc extends BandSalaryB
{
    public function CalculateSalary($data)
    {

        $data = parent::CalculateSalary($data);

       

        $db = new Dbquery();

        $results = $db->FindQuerry("Tbl_Employee", ['ManagedBy' => $this->id]);
        $dataBandResult = $results->toArray();
        foreach ($dataBandResult as $row) {
            $dataBand[] = (array) $row;

        }

        $r=0;
        $EmpSalary=0;


        for ($i = 0; $i < count($dataBand); $i++) {
            $r += 1000 * $dataBand[$i]['Rating'] / 5;

            $resultsalary = $db->FindQuerry("Tbl_BandSalary", ['_id' => $dataBand[$i]['Band']]);
            $dataBandssalaryResult = $resultsalary->toArray();

            foreach ($dataBandssalaryResult as $row) {
                $dataBandsalaryResult[] = (array) $row;

            }

            $SalaryBand = $dataBandsalaryResult[$i]['Salary'];

            ;

            if ($dataBand[$i]['Rating'] >= 4) {

                $EmpSalary += ($SalaryBand * 20) / 100;

            }

        }

        $Salary = $data + ($r) + $EmpSalary;



        return $Salary;

    }

}
