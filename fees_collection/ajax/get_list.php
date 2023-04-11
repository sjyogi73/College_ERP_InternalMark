<?php
ob_start();
session_start();
define('BASEPATH', '../../');

require_once(BASEPATH ."includes/common/connection.php");
require_once(BASEPATH ."includes/common/dbfunctions.php");
require_once(BASEPATH ."includes/common/functions.php");

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$con = new connection();
$dbcon = new dbfunctions();

isset($_POST["mode"]);

if($_POST["mode"]=="fees_id")
{	
	//echo $_POST["fees_id"];
    $srchQuery = "SELECT amount FROM fc_feesmaster WHERE del_status=0 AND id = ". $_POST["fees_id"];
    //echo $srchQuery;
    $srchRecords = $con->query($srchQuery);
    
    if($row = $srchRecords->fetch())
    {
        $amount = $row->amount;
    }
    
    //echo $_POST["id_no"] .'~'. $price;
    echo $amount;
}

if($_POST["mode"]=="fees_add")
{	
	$srchQuery = "SELECT id, fees_name, amount FROM fc_feesmaster WHERE del_status=0 AND id = ". $_POST["fees_id"];
    //echo $srchQuery;
    $srchRecords = $con->query($srchQuery);
    
    if($row = $srchRecords->fetch())
    {
        $id = $row->id;
		$fees_name = $row->fees_name;
		$amount = $row->amount;
    }
    
    echo $id .'~'. $fees_name .'~'. $amount;
}

if($_POST["mode"]=="modal_fs")
{	
	$sql = "SELECT * FROM fc_feesstructure WHERE del_status=0 AND id = ". $_POST["id"];
    //echo $srchQuery;
    $result = $con->query($sql);
    if ($result->rowCount()>0)
	{
		$obj = $result->fetch(PDO::FETCH_OBJ);	
	}
    
    $html_output ="";
    $html_output ='<div class="row">
        <div class="col-lg-12">
        <div class="row txt-dets">
            <div class="col-md-12" style="line-height:2rem;">
                
                <div class="card-body" style="padding: 0px 15px;">
                    <div class="row">
                        <div class="col-md-1"><label class="col-form-label">Degree</label></div>
                        <div class="col-md-3 text-left">: '. $dbcon->GetOneRecord("tbl_degree", "dname", "id", $obj->degree_id) .'</div>
                        <div class="col-md-1"><label class="col-form-label">Year</label></div>
                        <div class="col-md-3 text-left">: '. $obj->fees_year .'</div>
                        <div class="col-md-1"><label class="col-form-label">Semester</label></div>
                        <div class="col-md-3 text-left">: '. $obj->semester .'</div>
                        <br><br>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="padding: 0px; max-height:500px; overflow-y: scroll;">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="5%">#</th>
                                        <th class="text-center">Fees Name</th>
                                        <th class="text-center" width="10%">Amount</th>
                                    </tr>
                                </thead>';
                        $rs = $con->query("SELECT * FROM fc_feesstructure_details WHERE fs_id = ". $_POST["id"] . " ORDER BY sno");	
                        if ($rs->rowCount()>0)
                        {
                            while ($row = $rs->fetch())
                            {
                $html_output .='<tbody>
                                    <tr>
                                        <td>'. $row->sno .'</td>
                                        <td class="text-left">'. $dbcon->GetOneRecord("fc_feesmaster", "fees_name", "id", $row->fees_id) .'</td>
                                        <td class="text-right">'. $row->amount .'</td>
                                    </tr>
                                </tbody>';
                            }
                        }
                        $total = $obj->total_amount;
            $html_output .='
                            </table>
                        </div>
                    </div>
        
                    <div class="row">
                        <div class="col-md-12" style="text-align: right;">
                        <b>Total : Rs. '. number_format($total, 2, '.', '') .'</b>&nbsp;&nbsp;&nbsp;
                        </div>
                    </div>
                </div>
        
            </div>
        </div>
        </div>
    </div>';
    
    echo $html_output ."~". "<b>Fees Structure</b>";
}
	
?>