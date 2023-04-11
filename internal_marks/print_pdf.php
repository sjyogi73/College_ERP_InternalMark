<?php
ob_start();
session_start();
define('BASEPATH', '../');

require_once(BASEPATH ."includes/common/connection.php");
require_once(BASEPATH ."includes/common/dbfunctions.php");
require_once(BASEPATH ."includes/common/functions.php");

$con = new connection();
$dbcon = new dbfunctions();

//ini_set('display_errors', '1'); ini_set('display_startup_errors', '1'); error_reporting(E_ALL);

isAdmin();

// Include the main TCPDF library (search for installation path).
require_once(BASEPATH .'includes/common/tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//$pdf->setMargins(PDF_MARGIN_LEFT-15, PDF_MARGIN_TOP-29, PDF_MARGIN_RIGHT-16);
$pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP-19, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// add a page
$pdf->AddPage();

// set font
$pdf->SetFont('helvetica', 'B', 13);
$pdf->Write(0, 'Sri Ramakrishna Mission Vidyalaya College of Arts and Science', '', 0, 'C', true, 0, false, false, 0);     //---Add Heading---
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Write(0, '(Autonomous) Coimbatore - 641 020', '', 0, 'C', true, 0, false, false, 0);     //---Add Heading---

$pdf->writeHTML('<br>', true, false, true, false, '');

// $pdf->SetFont('helvetica', 'B', 14);
// $pdf->Write(0, 'TIME TABLE', '', 0, 'C', true, 0, false, false, 0);     //---Add Heading---
$pdf->writeHTMLCell(0, 0, '', '', '<h4><u>CIA Test - I / CIA Test - II / Model Examination</u></h4>', 0, 1, 0, true, 'C', true);  // Ref. www.rubydoc.info/gems/rfpdf/1.17.1/TCPDF:writeHTMLCell
$pdf->writeHTML('<br>', true, false, true, false, '');
$pdf->writeHTMLCell(0, 0, '', '',
//  '<table cellpadding="0" width="100%"><tr><th align="right">MONTH & YEAR OF EXAMINATION :</th> <th width="20%"> <div style="border: 0.2mm solid black;"></div></th> </tr></table>'
 
 '<table border="0" cellpadding="0" width="100%">
    <tr>
        <th width="50%" align="right"  style="padding-right: 20px;">MONTH & YEAR OF EXAMINATION : </th>
        <th width="1%">    </th>
        <th width="25%" style="border: 0.2mm solid black; height: 20px;"><div ></div></th>              
    </tr>
</table>',
 
 0, 1, 0, true, 'C', true);  // Ref. www.rubydoc.info/gems/rfpdf/1.17.1/TCPDF:writeHTMLCell
 $pdf->writeHTML('<br>', true, false, true, false, '');
 $pdf->writeHTML('
 <table border="0" cellpadding="0" width="100%">
 <tr>
     <th width="22%" style="">PROGRAMME & DEPARTMENT :</th>     
     <th width="25%" style="border-bottom: 0.2mm solid black;"><div ></div></th>              
 </tr>
 <br>
 <tr>
    <th width="22%" style="">COURSE TITLE WITH CODE :</th>     
    <th width="25%" style="border-bottom: 0.2mm solid black;"><div ></div></th>              
</tr>
</table>', true, false, true, false, 'L');




$pdf->SetFont('helvetica', '', 10);

$degree_id = base64_decode($_REQUEST["d"]);
$degree_name = $dbcon->GetOneRecord("tbl_degree", "dname", "id = ". $degree_id ." AND del_status", 0);
$tt_year = base64_decode($_REQUEST["y"]);
$semester = base64_decode($_REQUEST["s"]);
$staff_id = $_REQUEST["st"];
//iif is not working here
if($staff_id == "All"){ $staff_name = "All"; }else{ $staff_name = $dbcon->GetOneRecord("tbl_staffs", "staff_name", "id=". $staff_id ." AND del_status", 0); }    
//echo $staff_name; die;



//$pdf->lastPage();
ob_end_clean();

//Close and output PDF document
$pdf->Output('internal marks.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>