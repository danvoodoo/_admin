<?php
require_once('fpdf.php');
require_once('fpdi.php');
require_once('table.php');

// footer its in fpdf.php. function Footer()

$pdf = new PDF_MC_Table();








$pdf->AddPage();
$pdf->setSourceFile("../pdf/invoice.pdf");
$tplIdx = $pdf->importPage(1);
$pdf->useTemplate($tplIdx, 0, 0, 210);

$pdf->SetFont('Helvetica');
$pdf->SetFontSize(8);
$pdf->SetTextColor(0, 0, 0);





$pdf->SetX( 30 );
$pdf->SetY( 18 );
$pdf->Write(5, 'VAT number '.get_option('vatnumber') );


$pdf->SetX( 10 );
$pdf->SetY( 30 );

$pdf->SetFont('Helvetica','B',16);
$pdf->MultiCell(0, 9, 'Web Invoice Number #'.$order->or_id );


$pdf->SetFont('Helvetica','B',10);
$pdf->MultiCell(0, 9, 'Invoice Address' );
$pdf->SetFont('Helvetica','',9);
$pdf->MultiCell(0, 4, 'Name: '.$order->or_bill_name.' '.$order->or_bill_lastname );
$pdf->MultiCell(0, 4, 'Address: '.$order->or_bill_address);
$pdf->MultiCell(0, 4, 'City: '.$order->or_bill_city);
$pdf->MultiCell(0, 4, 'County: '.$order->or_bill_county);
$pdf->MultiCell(0, 4, 'Postcode: '.$order->or_bill_cp);
$pdf->MultiCell(0, 4, 'Email: '.$order->or_email);
$pdf->MultiCell(0, 4, 'Telephone: '.$order->or_phone);
$pdf->MultiCell(0, 4, 'Notes: '.$order->or_notes);

$pdf->SetY( 40 );
$pdf->SetX( 10 );
$pdf->Cell(110);
$pdf->SetFont('Helvetica','B',10);
$pdf->MultiCell(0, 9, 'Delivery Address' );
$pdf->SetFont('Helvetica','',9);
$pdf->Cell(110);
$pdf->MultiCell(0, 4, 'Name: '.$order->or_name.' '.$order->or_lastname );
$pdf->Cell(110);
$pdf->MultiCell(0, 4, 'Address: '.$order->or_address);
$pdf->Cell(110);
$pdf->MultiCell(0, 4, 'City: '.$order->or_city);
$pdf->Cell(110);
$pdf->MultiCell(0, 4, 'County: '.$order->or_county);
$pdf->Cell(110);
$pdf->MultiCell(0, 4, 'Postcode: '.$order->or_cp);

$pdf->Ln(4);
$pdf->Ln(4);
$pdf->Ln(4);


$pdf->Ln(2);
$pdf->SetDrawColor(200,200,200);
$pdf->Line( 5, $pdf->GetY(), 200, $pdf->GetY() );
$pdf->Ln(2);

$pdf->SetFont('Helvetica','B',13);
$pdf->MultiCell(0, 9, 'Cart content' );

$pdf->SetFont('Helvetica','',9);
$cart = json_decode($order->or_cart);
$total = 0;
$subtotal = 0;
//print_r($cart);
foreach ($cart as $k => $c) {

    if ( strpos($k, 'price') === false ) {

        $data = new Database();
        $where = 'prod_id = '.$c->id;
        $count  =  $data->select(" * ", " products ", $where);
        $product = $data->getObjectResults();


        /*
        if ( isset( $cart[$k.'-price'] ) ){
            $variable->prod_price = $cart[$k.'-price'];
        }
        */
        $subtotal = $product->prod_price*$c->q;
        $total += $subtotal;

        if ( file_exists('../photos/200_200_'.$product->prod_photo) )
        $pdf->Image('../photos/200_200_'.$product->prod_photo,10,$pdf->GetY(),20);

        $pdf->SetX(33);
        $pdf->MultiCell( 200 , 5 , utf8_decode($product->prod_title.' 
£'.number_format($product->prod_price,2).' 
x '.$c->q .' - £'.number_format($subtotal ,2) ) );

        $pdf->Ln();
        $pdf->Ln();


    }
}


$pdf->SetFont('Helvetica','B',12);
$pdf->SetDrawColor(200,200,200);
$pdf->Line( 5, $pdf->GetY(), 200, $pdf->GetY() );
$pdf->Ln(1);

$pdf->MultiCell( 0 , 8 , utf8_decode( 'Delivery (inc. VAT)' ) );
$pdf->SetY( $pdf->GetY()-8 );
$pdf->Cell(130);
$pdf->MultiCell( 0 , 8 , utf8_decode( '£'.number_format($order->or_shippingtotal,2) ) );

$pdf->MultiCell( 0 , 8 , utf8_decode( 'Subtotal (exc.VAT):' ) );
$pdf->SetY( $pdf->GetY()-8 );
$pdf->Cell(130);
$pdf->MultiCell( 0 , 8 , utf8_decode( '£'.number_format($total,2) ) );

$pdf->MultiCell( 0 , 8 , utf8_decode( 'Actual VAT Charged: ') );
$pdf->SetY( $pdf->GetY()-8 );
$pdf->Cell(130);
$pdf->MultiCell( 0 , 8 , utf8_decode( '£'.number_format($total*VAT,2) ) );

$pdf->Ln(1);
$pdf->SetDrawColor(200,200,200);
$pdf->Line( 5, $pdf->GetY(), 200, $pdf->GetY() );
$pdf->Ln(1);

$pdf->SetFont('Helvetica','B',14);
$pdf->MultiCell( 0 , 8 , utf8_decode( 'Grand Total (Inc. VAT):' ) );
$pdf->SetY( $pdf->GetY()-8 );
$pdf->Cell(130);
$pdf->MultiCell( 0 , 8 , utf8_decode( '£'.number_format($order->or_total+$order->or_shippingtotal,2) ) );



//$pdf->Output();


$filename = $order->or_id.'-'.time().'.pdf';
//$filename = 'test.pdf';
$pdf->Output('../invoices/cms-'.$filename);
$data = new Database();
$arr = array(
           'or_invoicefile' => 'cms-'.$filename
           );
$count  =  $data->update(" orders ", $arr, "or_id = ".$order->or_id);

//exit; 