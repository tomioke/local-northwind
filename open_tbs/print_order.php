<?php
// untuk koneksi, silahkan lakukan perubahan
// biasanya: user= root, password dikosongkan
// $conn = new mysqli('localhost', 'root', '', 'northwind');
$conn = new mysqli('localhost', 'root', '', 'northwind');

// Ketika koneksi gagal akan muncul pesan error 
if ($conn->connect_errno) {
  die('eror' . $conn->error);
}

// Memulai proses opentbs
ob_start();

// Include classes
include_once('opentbs/tbs_class.php'); // Load the TinyButStrong template engine
include_once('opentbs/tbs_plugin_opentbs.php'); // Load the OpenTBS plugin

$TBS = new clsTinyButStrong; // new instance of TBS
$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load the OpenTBS plugin

// ------------------------------
// Persiapkan data terlebih dahulu
// ------------------------------
 $parameter1 = $_GET['param1'];
//$parameter1 = base64_decode($_GET['param1']);

$query1 = $conn->query("SET @row_number=0");
$query1 = $conn->query("SELECT (@row_number := @row_number +1) as nomor, a.*, b.ProductName FROM order_details a JOIN products b ON a.ProductID = b.ProductID WHERE a.OrderID = $parameter1");

$data = array();
while ($getdata = $query1->fetch_assoc()) {
    //@$i++;
	//$data['no'] = $i;
	$data[]=$getdata;
}

$datawaktu = array('tanggal' => '16 Maret 2021');

$template = 'template_order.xlsx';
$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of
// Merge data in the body of the document

$TBS->MergeBlock('data', $data);
$TBS->MergeField('waktu', $datawaktu);

// -----------------
// Output the result
// -----------------

$TBS->Show(OPENTBS_DOWNLOAD, 'hasil3.xlsx');
exit();
