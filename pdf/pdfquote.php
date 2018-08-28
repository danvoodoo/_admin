<?php
require_once('../includes/conexion.php');
require_once('fpdf.php');
require_once('fpdi.php');

$data = new Database();
$where = 'id = '.$_GET['id'];
$count  =  $data->select(" * ", " quotes ", $where);
$r = $data->getObjectResults();


$where = 'name = "'.$r->vehicle.'"';
$count  =  $data->select(" * ", " vehicles ", $where);
$v = $data->getObjectResults();


$where = 'vehicle = "'.$r->vehicle.'"';
$count  =  $data->select(" * ", " pricing ", $where);
$p = $data->getObjectResults();


$where = 'manufacturers.id = models.manufacturer AND models.id = "'.$v->model.'"';
$count  =  $data->select(" manufacturers.name, manufacturers.id, models.name as modelname ", " models, manufacturers ", $where);
$m = $data->getObjectResults();

// initiate FPDI
$pdf = new FPDI();
// add a page
$pdf->AddPage();
// set the source file
$pdf->setSourceFile("quote.pdf");
// import page 1
$tplIdx = $pdf->importPage(1);
// use the imported page and place it at point 10,10 with a width of 100 mm
$pdf->useTemplate($tplIdx, 0, 0, 210);

// now write some text above the imported page
$pdf->SetFont('Helvetica');
$pdf->SetTextColor(0, 0, 0);

$pdf->SetXY(155, 44);
$pdf->Write(0, date('d F Y', strtotime($r->created_at)));

$pdf->SetXY(155, 49.3);
$pdf->Write(0, $_GET['id']);

$pdf->SetXY(50, 78.3);
$pdf->Write(0, $r->name);

$pdf->SetXY(133, 87);
//$pdf->Write(0, $r->comments);
$pdf->MultiCell(0,5, $r->comments);


$pdf->SetXY(50, 87.2);
$pdf->Write(0, $r->company);

$pdf->SetXY(50, 96.2);
$pdf->Write(0, $r->telephone);

$pdf->SetXY(50, 105);
$pdf->Write(0, $r->email);



$pdf->SetXY(50, 136);
$pdf->Write(0, $m->name);

$pdf->SetXY(50, 144);
$pdf->Write(0, $v->name);

$pdf->SetXY(50, 152);
$pdf->Write(0, $r->accessories);

$pdf->SetXY(50, 161);
$pdf->Write(0, $r->mileage);

$pdf->SetXY(50, 169);
$pdf->Write(0, $r->contract_term);

$pdf->SetXY(50, 177);
if ($r->maintainance == 0)
	$pdf->Write(0, 'Non');
else
	$pdf->Write(0, 'Yes');


$pdf->SetXY(50, 209);
$pdf->Write(0, $r->prepared_by);

$pdf->SetXY(50, 217);
$pdf->Write(0, $r->contract_type);

$pdf->SetXY(50, 225);
if ($r->vat == 0)
	$pdf->Write(0, 'Non inclusive');
else
	$pdf->Write(0, 'Inclusive');

$pdf->SetXY(50, 233);
$pdf->Write(0, $r->amount);

$pdf->SetXY(133, 225);
$pdf->Write(0, $r->comment);


$pdf->Image('../..'.imageurl($p->modelname, $p->manname, $m->id, 1, 1),135,150,0);

$pdf->Output('quotes/'.$_GET['id'].'-'.slugify($r->name).' .pdf','D');
exit;
?>