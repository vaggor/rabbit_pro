<?php
//print_r($paid_data);exit;
if(!empty($resp['data'])){

	//print_r($listitems);exit;
 ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large
 
//create a file
$filename = "RabbitPro-income_espense.csv";
$csv_file = fopen('php://output', 'w');
 
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename="'.$filename.'"');

 
// The column headings of your .csv file
$header_row = array("Name","Date","Amount","Breeder","Category","Type");
fputcsv($csv_file,$header_row,',','"');
 
// Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column

foreach($resp['data'] as $listitems)
{
// Array indexes correspond to the field names in your db table(s)
$row = array(
@$listitems['name'],
@$listitems['date'],
@$listitems['amount'],
@$listitems['breeder'],
@$listitems['cat_name'],
@$listitems['ledger_type_name']
);
 
fputcsv($csv_file,$row,',','"');
}
 //exit;
fclose($csv_file);

}

?>