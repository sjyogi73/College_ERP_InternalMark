<?php
ob_start();
session_start();

require_once("includes/common/connection.php");
require_once("includes/common/dbfunctions.php");
require_once("includes/common/functions.php");

$con = new connection();
$dbcon = new dbfunctions();

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

isAdmin();
$menu_permission = explode('||', $_SESSION["menu_permission"]);

?>
<?php include("includes/header.php"); ?>
<?php include("includes/aside.php"); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Staffs
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-edit"></i> Masters</a></li>
            <li class="active">Staffs</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">List</h3>
                <?php 
                if(in_array('createStudents',$menu_permission)){
                ?>
                <div class="box-tools pull-right">
                    <a href="staffs.php" class="btn btn-block btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                </div>
                <?php
                }
                ?>
            </div>
            <div class="box-body">

                <div class="box box-solid search" style="background-color: #ECF0F5; height: 88px;">
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
                                    <label>Search Staff Type</label>
                                    <select class="form-control select2" name="searchByType" id="searchByType" title="Select the Staff Type">
                                        <option value=""></option>
                                        <option value="1">Teaching Staff</option>
                                        <option value="2">Non-Teaching Staff</option>
                                    </select>
                                </div>  
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Search Staff Designation</label>
                                    <select class="form-control select2" name="searchByDesignation" id="searchByDesignation" title="Select the Staff Designation">
                                        <option value=""></option>
                                        <?php
                                            echo $dbcon->fnFillComboFromTable_Where("id", "dname", "tbl_designation", "dname", " WHERE del_status = 0");
                                        ?>
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
                                    <th width="60">Staff Id</th>
                                    <th class="text-center">Staff Name</th>
                                    <th width="200" class="text-center">Qualification</th>
                                    <th width="100" class="text-center">Staff Type</th>
                                    <th width="100" class="text-center">Designation</th>
                                    <th width="70" class="text-center">Mobile No</th>
                                    <th width="60" class="text-center">Action</th>
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
    //$('#example1').DataTable({
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
            'url':'datatable/StaffList.php',
            'type':'POST',
            'data': function(data){
                //alert(data);
                var searchByValue = $('#searchByValue').val();
                var searchByType = $('#searchByType').val();
                var searchByDesignation = $('#searchByDesignation').val();

                data.searchByValue = searchByValue;
                data.searchByType = searchByType;
                data.searchByDesignation = searchByDesignation;
            }
        },
        
        'columns'       : [
            { data: 'id' },
            { data: 'staff_id' },
            { data: 'staff_name' },
            { data: 'qualification' },
            { data: 'staff_type' },
            { data: 'designation' },
            { data: 'mobile_no' },
            { data: 'action' },
        ],

        rowReorder      : true,
        columnDefs      : [
            {
                targets: [0,1,4,5,6,7],
                className: 'text-center'
            },

            { 
                orderable: true, 
                className: 'reorder', 
                targets: [0,1,2,3,4,5,6] 
            },
            { 
                orderable: false, 
                targets: '_all' 
            }],

        buttons         : ['copyHtml5','excelHtml5','csvHtml5','pdfHtml5','print']
    });

    $('#searchByValue').keyup(function(){  
        dataTable.draw();
    });

    $('#searchByType').change(function(){  
        dataTable.draw();
    });
    
    $('#searchByDesignation').change(function(){  
        dataTable.draw();
    });
});
</script>

<script type="text/javascript">
$(document).ready(function() {
    $('#masterMainNav').addClass('active');
    $('#masterStaffsSubNav').addClass('active');
});
</script>