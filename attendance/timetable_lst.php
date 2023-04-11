<?php
ob_start();
session_start();
define('BASEPATH', '../');

require_once(BASEPATH ."includes/common/connection.php");
require_once(BASEPATH ."includes/common/dbfunctions.php");
require_once(BASEPATH ."includes/common/functions.php");

$con = new connection();
$dbcon = new dbfunctions();
$converter = new Encryption;

// ini_set('display_errors', '1'); ini_set('display_startup_errors', '1'); error_reporting(E_ALL);

isAdmin();

?>

<?php include("includes/header.php"); ?>
<?php include("includes/aside.php"); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Timetable
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-edit"></i> Attendance</a></li>
            <li class="active"> Timetable</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">List</h3>
                <div class="box-tools pull-right">
                    <a href="timetable.php" class="btn btn-block btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="box-body">

                <div class="box box-solid search" style="background-color: #ECF0F5; height: 88px;">
                    <div class="box-body">
                        <div class="row">
                            <!-- <div class="col-md-3">
                                <div class="form-group">
                                    <label>Search For</label>
                                    <input type="text" class="form-control" name="searchByValue" id="searchByValue" autofocus placeholder="Search by Value">
                                </div>
                            </div> -->

                            <div class="col-md-4">
                                <label class="col-form-label">Search Degree</label>
                                <select class="form-control select2" name="searchByDegree" id="searchByDegree" title="Select the Degree">
                                    <option value=""></option>
                                    <?php
                                    echo $dbcon->fnFillComboFromTable_Where("id", "dname", "tbl_degree", "dname", " WHERE del_status = 0");
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label">Search Year</label>
                                <select class="form-control select2" name="searchByYear" id="searchByYear" title="Select the Year">
                                    <option value=""></option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label">Search Semester</label>
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
                            <div class="col-md-3">
                                <label class="col-form-label">Search Staff</label>
                                <select class="form-control select2" name="searchByStaff" id="searchByStaff" title="Select the Staff">
                                    <option value=""></option>
                                    <?php
                                    echo $dbcon->fnFillComboFromTable_Where("id", "staff_name", "tbl_staffs", "staff_name", " WHERE del_status = 0");
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <form id="thisForm" name="thisForm" action="timetable_lst.php" method="post">
                    <div class="table-responsive">
                        <div class="dt-responsive table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="8">#</th>
                                        <th width="70" class="text-center">Day Order</th>
                                        <th width="60" class="text-center">Day Hour</th>
                                        <th width="300" class="text-center">Degree</th>
                                        <th class="text-center">Course Name</th>
                                        <th width="60" class="text-center">Action</th>
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

<script type="text/javascript">
$(function() {
    var dataTable = $('#example1').DataTable({
        //$('#example1').DataTable({
        'autoWidth': false,
        'responsive': true,
        'processing': true,
        'serverSide': true,
        'pageLength': 12,
        'searching': false,
        //'scrollY'       : '570px',
        //'scrollCollapse': true,
        //'dom'           : 'Bfrtip',
        'dom': "<'row'<'col-sm-12 d-flex col-md-6'lf><'col-sm-12 col-md-6 text-right'B>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row m-2'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

        'ajax': {
            'url': 'datatable/TimetableList.php',
            'type': 'POST',
            'data': function(data) {
                //alert(data);
                //var searchByValue = $('#searchByValue').val();
                var searchByDegree = $('#searchByDegree').val();
                var searchByYear = $('#searchByYear').val();
                var searchBySemester = $('#searchBySemester').val();
                var searchByStaff = $('#searchByStaff').val();

                //data.searchByValue = searchByValue;
                data.searchByDegree = searchByDegree;
                data.searchByYear = searchByYear;
                data.searchBySemester = searchBySemester;
                data.searchByStaff = searchByStaff;
            }
        },

        'columns': [{
                data: 'id'
            },
            {
                data: 'day_order'
            },
            {
                data: 'days_hour'
            },
            {
                data: 'degree_id'
            },
            {
                data: 'course_id'
            },
            {
                data: 'action'
            },
        ],

        rowReorder: true,
        columnDefs: [{
                targets: [0, 1, 2, 5],
                className: 'text-center'
            },

            {
                orderable: true,
                className: 'reorder',
                targets: [0, 1, 2, 3, 4]
            },
            {
                orderable: false,
                targets: '_all'
            }
        ],

        buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5', 'print']
    });

    // $('#searchByValue').keyup(function() {
    //     dataTable.draw();
    // });

    $('#searchByDegree').change(function() {
        dataTable.draw();
    });
    $('#searchByYear').change(function() {
        dataTable.draw();
    });
    $('#searchBySemester').change(function() {
        dataTable.draw();
    });
    $('#searchByStaff').change(function() {
        dataTable.draw();
    });
});
</script>

<script type="text/javascript">
$(document).ready(function() {
    $('#masterMainNav').addClass('active');
    $('#masterTimetableSubNav').addClass('active');
});
</script>