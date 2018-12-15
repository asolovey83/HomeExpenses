<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Helper\Sample;

require_once $_SERVER['DOCUMENT_ROOT'] . '/expenses/PhpSpreadsheet/src/Bootstrap.php';
require $_SERVER['DOCUMENT_ROOT'] . '/expenses/pdo.php';

$helper = new Sample();
$inputFileType = 'Xls';
$inputFileName = __DIR__ . '/sampleData/importdata.xls';

$helper->log('Loading file ' . pathinfo($inputFileName, PATHINFO_BASENAME) . ' using IOFactory with a defined reader type of ' . $inputFileType);
$reader = IOFactory::createReader($inputFileType);
$helper->log('Turning Formatting off for Load');
$reader->setReadDataOnly(true);
$spreadsheet = $reader->load($inputFileName);

$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
var_dump($sheetData);

for ($row=2; $row<=count($sheetData); $row++)
{
    //$xx = "'" . implode("','", $sheetData[$row]) . "'";
    $UNIX_DATE = ($sheetData[$row]['A'] - 25569) * 86400;
    
    
    $date = gmdate("Y-m-d H:i:s", $UNIX_DATE);
    $cat = $sheetData[$row]['B'];
    $desc = $sheetData[$row]['C'];
    $sum = $sheetData[$row]['D'];
    
    $sql = "INSERT INTO main (date, category, description, sum) VALUES ('$date', '$cat', '$desc', '$sum');";
    $stmt = $pdo->prepare($sql);
    $stmt -> execute();
}

echo ($sheetData[1]['A']);

?>

