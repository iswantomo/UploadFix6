<?php
//Yii::import('application.vendor.phpexcel.Classes.*');
//require_once('PHPExcel.php');

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

// Create new PHPExcel object
$objPHPExcel = new \PHPExcel();
// Set document properties
$objPHPExcel->getProperties()->setCreator("Basic Science")->setLastModifiedBy("Mathematics");
// Add some data
$objPHPExcel->setActiveSheetIndex(0);
//style
$style_putih = array(
	'font'  => array('color' => array('rgb' => 'FFFFFF'),	
));
$style_merah = array(
	'font'  => array(
		'color' => array('rgb' => 'FF0000'),
		'bold'  => true,
		'size'  => 10,
		'name'  => 'Verdana'
));

$style_tebal = array(
	'font'  => array(
		'color' => array('rgb' => '000000'),
		'bold'  => true,
		'size'  => 10,
		'name'  => 'Verdana'
));

$style_borderhitam = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => '000000'),
		),
	),
);

?>

<?php
$array_cellkolom=array('','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB');
$kolom_judul=array(
	'No.',
	'NIM',
	'Nama Siswa/Peserta',
	'No. Komputer',
	'Tipe Soal',
	'Benar',
	'Salah',
	'Tidak menjawab',
	'Skor',
);

$objPHPExcel->setActiveSheetIndex()->setCellValue("B1", "Kode Ujian");
$objPHPExcel->setActiveSheetIndex()->setCellValue("C1", $searchModel->jadwalKelas->kode_ujian);
$objPHPExcel->setActiveSheetIndex()->setCellValue("B2", "Matakuliah");
$objPHPExcel->setActiveSheetIndex()->setCellValue("C2", $searchModel->jadwalKelas->matakuliah);
$objPHPExcel->setActiveSheetIndex()->setCellValue("B3", "Prodi");
$objPHPExcel->setActiveSheetIndex()->setCellValue("C3", $searchModel->jadwalKelas->prodi);
$objPHPExcel->setActiveSheetIndex()->setCellValue("B4", "Ruang Ujian");
$objPHPExcel->setActiveSheetIndex()->setCellValue("C4", $searchModel->jadwalKelas->ruang_ujian);
$objPHPExcel->setActiveSheetIndex()->setCellValue("B5", "Tanggal");
$objPHPExcel->setActiveSheetIndex()->setCellValue("C5", date('d M Y',strtotime($searchModel->jadwalKelas->tanggal)));
$objPHPExcel->setActiveSheetIndex()->setCellValue("B5", "Tanggal");
$objPHPExcel->setActiveSheetIndex()->setCellValue("C5", date('d M Y',strtotime($searchModel->jadwalKelas->tanggal)));
$objPHPExcel->setActiveSheetIndex()->setCellValue("D1", "Nilai Benar");
$objPHPExcel->setActiveSheetIndex()->setCellValue("E1", $searchModel->jadwalKelas->nilai_benar);
$objPHPExcel->setActiveSheetIndex()->setCellValue("D2", "Nilai Salah");
$objPHPExcel->setActiveSheetIndex()->setCellValue("E2", $searchModel->jadwalKelas->nilai_salah);

$i=0;
foreach($kolom_judul as $data){
	$i++;
	$objPHPExcel->setActiveSheetIndex()->setCellValue($array_cellkolom[$i]."7", $data);
}
$cell_kolomterakhir=$array_cellkolom[$i];

$i=7;
foreach ($dataProvider->models as $data):
	$i++;
	$z=0;
	$z++; $objPHPExcel->setActiveSheetIndex()->setCellValue($array_cellkolom[$z].$i, ($i-7));
	$z++; $objPHPExcel->setActiveSheetIndex()->setCellValue($array_cellkolom[$z].$i, $data->nim);
	$z++; $objPHPExcel->setActiveSheetIndex()->setCellValue($array_cellkolom[$z].$i, $data->nama);
	$z++; $objPHPExcel->setActiveSheetIndex()->setCellValue($array_cellkolom[$z].$i, $data->ip_address);
	$z++; $objPHPExcel->setActiveSheetIndex()->setCellValue($array_cellkolom[$z].$i, $data->tipe_soal);
	$z++; $objPHPExcel->setActiveSheetIndex()->setCellValue($array_cellkolom[$z].$i, $data->benar);
	$z++; $objPHPExcel->setActiveSheetIndex()->setCellValue($array_cellkolom[$z].$i, $data->salah);
	$z++; $objPHPExcel->setActiveSheetIndex()->setCellValue($array_cellkolom[$z].$i, $data->tidak_menjawab);
	$z++; $objPHPExcel->setActiveSheetIndex()->setCellValue($array_cellkolom[$z].$i, $data->skor);
endforeach;

$cell_terakhir=$cell_kolomterakhir.$i;
$objPHPExcel->setActiveSheetIndex()->getStyle('A7:'.$cell_terakhir)->applyFromArray($style_borderhitam);
$objPHPExcel->setActiveSheetIndex()->getStyle('A7:'.$cell_kolomterakhir.'7')->applyFromArray($style_tebal);

$range = 'A1:'.$cell_terakhir;
$objPHPExcel->getActiveSheet()
    ->getStyle($range)
    ->getNumberFormat()
    ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );

foreach(range('A',$cell_kolomterakhir) as $columnID) { 
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);
}

?>

<?php
// Save Excel 95 file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save(str_replace(__FILE__,$link_download,__FILE__));
\Yii::$app->response->sendFile($link_download);
?>