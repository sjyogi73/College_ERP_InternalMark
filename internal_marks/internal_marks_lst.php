<?php
ob_start();
session_start();
define('BASEPATH', '../');

require_once(BASEPATH ."includes/common/connection.php");
require_once(BASEPATH ."includes/common/dbfunctions.php");
require_once(BASEPATH ."includes/common/functions.php");

$con = new connection();
$dbcon = new dbfunctions();

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

isAdmin();
//$menu_permission = explode('||', $_SESSION["menu_permission"]);
if (isset($_REQUEST["course_id"])) {
    echo '<script type="text/JavaScript">    
      window.open("print_pdf.php?d='.($_REQUEST["degree_id"]).'&y='.($_REQUEST["study_year"]).'&s='.($_REQUEST["semester"]).'&st=1");
      window.location.href = "internal_marks_lst.php";
     </script>';
}


?>
<?php include("includes/header.php"); ?>
<?php include("includes/aside.php"); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Internal Marks
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-desktop"></i> Transactions</a></li>
            <li class="active">Internal Marks</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">List</h3>
                <?php 
                //if(in_array('createStudents',$menu_permission)){
                ?>
                <!-- <div class="box-tools pull-right">
                    <a href="internal_marks.php" class="btn btn-block btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                </div> -->
                <?php
                //}
                ?>
            </div>
            <div class="box-body">
                <div class="box box-solid search" style="background-color: #E2F1FF;">
                    <div class="box-body">
                        <div class="row">                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Search For</label>
                                    <input type="text" class="form-control" name="searchByValue" id="searchByValue" autofocus placeholder="Search by Value">
                                </div>  
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Select Staff</label>
                                    <select class="form-control select2" name="searchByStaff" id="searchByStaff" title="Select the Staff">
                                        <option value=""></option>
                                        <?php
                                            echo $dbcon->fnFillComboFromTable_Where("id", "staff_name", "tbl_staffs", "staff_name", " WHERE del_status = 0");
                                            ?>
                                    </select>
                                </div>  
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Search Degree</label>
                                    <select class="form-control select2" name="searchByDegree" id="searchByDegree" title="Select the Degree">
                                        <option value=""></option>
                                        <?php
                                            echo $dbcon->fnFillComboFromTable_Where("id", "dname", "tbl_degree", "dname", " WHERE del_status = 0");
                                        ?>
                                    </select>
                                </div>  
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Search Year</label>
                                    <select class="form-control select2" name="searchByYear" id="searchByYear" title="Select the Year">
                                        <option value=""></option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>  
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Search Semester</label>
                                    <select class="form-control select2" name="searchBySemester" id="searchBySemester" title="Select the Semester">
                                        <option value=""></option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                    </select>
                                </div>  
                            </div>
                        </div>       
                    </div>
                </div>
                
                <div class="table-responsive">
                    <div class="dt-responsive table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <th width="8">#</th>
                                   <!-- <th width="80">Course Code</th> -->
                                    <th>Course Name</th>
                                    <th width="150">Staff Name</th>
                                    <th width="200">Degree</th>
                                    <th width="50" class="text-center">Year</th>
                                    <th width="50" class="text-center">Semester</th>
                                    <th width="110">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
<?php include("includes/footer.php"); ?>
<script>
$(function () {
    var dataTable = $('#example1').DataTable({
        'autoWidth'     : false,
        'responsive'    : true,
        'processing'    : true,
        'serverSide'    : true,
        'pageLength'    : 12,
        'searching'     : false,
        //'scrollY'       : '570px',
        //'scrollCollapse': true,
        //'dom'           : 'Bfrtip',
        'dom'           : "<'row'<'col-sm-12 d-flex col-md-6'lf><'col-sm-12 col-md-6 text-right'B>>" +
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row m-2'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        
        'ajax'          : {
            'url':'datatable/InternalMarksList.php',
            'type':'POST',
            'data': function(data){          
                var searchByValue = $('#searchByValue').val();
                var searchByDegree = $('#searchByDegree').val();
                var searchByStaff = $('#searchByStaff').val();
                var searchByYear = $('#searchByYear').val();
                var searchBySemester = $('#searchBySemester').val();
           
                data.searchByValue = searchByValue;
                data.searchByDegree = searchByDegree;
                data.searchByStaff = searchByStaff;
                data.searchByYear = searchByYear;
                data.searchBySemester = searchBySemester;
                // alert(data.searchByValue);
            }
        },
        
        'columns'       : [
            { data: 'id' },     
            { data: 'course_name' },
            { data: 'staff_name' },
            { data: 'degree_id' },
            { data: 'study_year' },
            { data: 'semester' },
            { data: 'actions' },
        ],

        rowReorder      : true,
        columnDefs      : [
            {
                targets: [0,4,5],
                className: 'text-center'
            },

            { 
                orderable: true, 
                className: 'reorder', 
                targets: [0,1,2,3,4,5] 
            },
            { 
                orderable: false, 
                targets: '_all' 
            }],
        //buttons         : ['copyHtml5','excelHtml5','csvHtml5','pdfHtml5','print']
        buttons         : []
    });

    $('#searchByValue').keyup(function(){  
        dataTable.draw();
    });
    $('#searchByDegree').change(function(){  
        dataTable.draw();
    }); 
    $('#searchByStaff').change(function(){  
        dataTable.draw();
    });
    $('#searchByYear').change(function(){  
        dataTable.draw();
    });
    $('#searchBySemester').change(function(){  
        dataTable.draw();
    });         
});
</script>

<script type="text/javascript">
function check(url)
{
    // return  window.open("print_pdf.php?d="+ 12 +"&y="+ 1 +"&s="+ 1 +"&st="+1, "_blank");
    return   window.open(url);

}

$(document).on("click", "#report", function(){
    //alert("Hello Print");
    // var degree_id = $('#degree_id').val();
    // var tt_year = $("#tt_year").val();
    // var semester = $("#semester").val();
    // var staff_id = $("#staff_id").val();

    window.open("print_pdf.php?d='1'&y='1'&s='1'&st='1',_blank");

    //var divToPrint=document.getElementById("time_table");
    //newWin= window.open("");
    //newWin.document.write(divToPrint.outerHTML);
    //newWin.print();
    //newWin.close();
});    
$(document).ready(function() {
    $('#TransactionMainNav').addClass('active');
    $('#internalMarks').addClass('active');
});
</script>