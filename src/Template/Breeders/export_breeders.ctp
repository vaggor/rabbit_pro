<?php
//print_r($paid_data);exit;
if(!empty($data)){

	//print_r($listitems);exit;
 ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large
 
//create a file
$filename = "RabbitPro-Breeders.csv";
$csv_file = fopen('php://output', 'w');
 
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename="'.$filename.'"');

 
// The column headings of your .csv file
$header_row = array("Name","ID","Cage","Color","Breed","Sex","Date Born","Date Acquired","Status");
fputcsv($csv_file,$header_row,',','"');
 
// Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column

foreach($data as $listitems)
{
// Array indexes correspond to the field names in your db table(s)
$row = array(
@$listitems->name,
@$listitems->breeder_id,
@$listitems->cage,
@$listitems->color,
@$breeds[$listitems->breed_id],
@$sexes[$listitems->sex_id],
@$listitems->date_born,
@$listitems->date_acquired,
@$statuses[$listitems->status_id]
);
 
fputcsv($csv_file,$row,',','"');
}
 //exit;
fclose($csv_file);

}

?>