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

?>
<?php include("includes/header.php"); ?>
<?php include("includes/aside.php"); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Course Mapping
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-edit"></i> Masters</a></li>
            <li class="active">Course Mapping</li>
        </ol>
    </section>
    
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">List</h3>
                <?php 
                //if(in_array('createStudents',$menu_permission)){
                ?>
                <div class="box-tools pull-right">
                    <a href="course_mapping.php" class="btn btn-block btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                </div>
                <?php
                //}
                ?>
            </div>
            <div class="box-body">

                <div class="box box-solid search" style="background-color: #E2F1FF; height: 88px;">
                    <div class="box-body">
                        <div class="row">
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Search For</label>
                                    <input type="text" class="form-control" name="searchByValue" id="searchByValue" autofocus placeholder="Search by Value">
                                </div>  
                            </div>
                            <div class="col-md-3">
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
                            <div class="col-md-3">
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
                    </div>
                </div>
                
                <form id="thisForm" name="thisForm" class="form-horizontal" action="course.php" method="post">
                <div class="table-responsive">
                    <div class="dt-responsive table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="8">#</th>
                                   <!-- <th width="80">Course Code</th> -->
                                    <th>Course Name</th>
                                    <th width="250">Staff Name</th>
                                    <th width="200">Degree</th>
                                    <th width="50" class="text-center">Year</th>
                                    <th width="50" class="text-center">Semester</th>
                                    <th width="60">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                </form>

            </div>
        </div>
    </section>
</div>
<?php include("includes/footer.php"); ?>
<script>
$(function () {
    var dataTable = $('#example1').DataTable({
    //$('#example1').DataTable({
        'autoWidth'     : false,
        'responsive'    : true,
        'processing'    : true,
        'serverSide'    : true,
        'pageLength'    : 12,
        'searching'     : false,
        //'scrollY'       : '570px',
        //'scrollCollapse': true,
        'dom'           : 'Bfrtip',
        // 'dom'           : "<'row'<'col-sm-12 d-flex col-md-6'lf><'col-sm-12 col-md-6 text-right'B>>" +
        //                     "<'row'<'col-sm-12'tr>>" +
        //                     "<'row m-2'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        
        'ajax'          : {
            'url':'datatable/CourseMappingList.php',
            'type':'POST',
            'data': function(data){
                //alert(data);
                var searchByValue = $('#searchByValue').val();
                var searchByDegree = $('#searchByDegree').val();
                var searchByStaff = $('#searchByStaff').val();

                data.searchByValue = searchByValue;
                data.searchByDegree = searchByDegree;
                data.searchByStaff = searchByStaff;
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
            buttons         : []
        //buttons         : ['copyHtml5','excelHtml5','csvHtml5','pdfHtml5','print']
    });

    $('#searchByValue').keyup(function(){  
        dataTable.draw();
    });

    $('#searchByStaff').change(function(){  
        dataTable.draw();
    }); 

    $('#searchByDegree').change(function(){  
        dataTable.draw();
    });    
});
</script>

<script type="text/javascript">
$(document).ready(function() {
    $('#masterMainNav').addClass('active');
    $('#masteCourseSubNav').addClass('active');
});
</script>