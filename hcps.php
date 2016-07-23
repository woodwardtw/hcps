<?php 

$file = 'https://docs.google.com/spreadsheets/d/1mUJE1_e-vaQmqvlOiRd91bJ6NgwGyDSyzxgfB-OJRK4/pub?output=csv';
$csv= file_get_contents($file);
$array = array_map("str_getcsv", explode("\n", $csv));
$json = json_encode($array);
print_r($json);

?>