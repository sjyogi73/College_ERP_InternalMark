<?php
ob_start();
session_start();
define('BASEPATH', '../../');

require_once(BASEPATH ."includes/common/connection.php");
require_once(BASEPATH ."includes/common/dbfunctions.php");
require_once(BASEPATH ."includes/common/functions.php");

ini_set('display_errors', '1'); ini_set('display_startup_errors', '1'); error_reporting(E_ALL);

$con = new connection();
$dbcon = new dbfunctions();
$converter = new Encryption;

isset($_POST["mode"]);

if($_POST["mode"]=="get_tt")
{	
    $html = '<hr style="opacity: .3; margin: 10px 0px;">
    <div class="pull-right">
        <button type="button" class="btn btn-icon btn-primary btn-sm btn_print"><i class="fa fa-print"></i>&nbsp; Print</button>
    </div>
    <br><br>
    <table class="table table-border table-hover" border="1" cellspacing="0" style="border: 1px solid;" width="100%" id="time_table">
        <thead>
            <tr>
                <th width="5%" class="text-center"><b>Day Order</b></th>
                <th width="15%" class="text-center"><b>I <br>(09:30 : 10:30)</b></th>
                <th width="15%" class="text-center"><b>II <br>(10:30 : 11:30)</b></th>
                <th width="15%" class="text-center"><b>III <br>(11:45 : 01:00)</b></th>
                <th width="5%" class="text-center"><b>Break</b></th>
                <th width="15%" class="text-center"><b>IV <br>(02:00 : 03:00)</b></th>
                <th width="15%" class="text-center"><b>V <br>(03:00 : 04:00)</b></th>
                <th width="15%" class="text-center"><b>VII <br>(04:00 : 05:00)</b></th>
            </tr>
        </thead>
        <tbody>
            <!-- ------------------------------------------- Day Order - I ------------------------------------------------- -->
            <tr>
                <td class="text-center"><b>I</b></td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt1-1">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 1 and days_hour = 1 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 1 and days_hour = 1 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t1-1">';
        $html .= iif($course_name != "", '  
                            <a href="javascript:void(0);" class="delete pull-right" rel="1-1~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="1-1~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="1-1~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt1-2">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 1 and days_hour = 2 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 1 and days_hour = 2 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t1-2">';
        $html .= iif($course_name != "", '  
                            <a href="javascript:void(0);" class="delete pull-right" rel="1-2~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="1-2~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="1-2~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt1-3">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 1 and days_hour = 3 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 1 and days_hour = 3 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t1-3">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="1-3~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="1-3~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="1-3~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td rowspan="6" class="text-center"><h2><br><br> L <br><br> U <br><br> N <br><br> C <br><br> H </h2></td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt1-4">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 1 and days_hour = 4 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 1 and days_hour = 4 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t1-4">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="1-4~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="1-4~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="1-4~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt1-5">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 1 and days_hour = 5 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 1 and days_hour = 5 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t1-5">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="1-5~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="1-5~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="1-5~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt1-6">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 1 and days_hour = 6 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 1 and days_hour = 6 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t1-6">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="1-6~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="1-6~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="1-6~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
            </tr>
            <!-- ------------------------------------------- Day Order - II ------------------------------------------------- -->
            <tr>
                <td class="text-center"><b>II</b></td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt2-1">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 2 and days_hour = 1 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 2 and days_hour = 1 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t2-1">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="2-1~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="2-1~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="2-1~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt2-2">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 2 and days_hour = 2 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 2 and days_hour = 2 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t2-2">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="2-2~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="2-2~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="2-2~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt2-3">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 2 and days_hour = 3 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 2 and days_hour = 3 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t2-3">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="2-3~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="2-3~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="2-3~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt2-4">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 2 and days_hour = 4 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 2 and days_hour = 4 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t2-4">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="2-4~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="2-4~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="2-4~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt2-5">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 2 and days_hour = 5 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 2 and days_hour = 5 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t2-5">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="2-5~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="2-5~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="2-5~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt2-6">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 2 and days_hour = 6 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 2 and days_hour = 6 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t2-6">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="2-6~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="2-6~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="2-6~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
            </tr>
            <!-- ------------------------------------------- Day Order - III ------------------------------------------------- -->
            <tr>
                <td class="text-center"><b>III</b></td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt3-1">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 3 and days_hour = 1 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 3 and days_hour = 1 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t3-1">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="3-1~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="3-1~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="3-1~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt3-2">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 3 and days_hour = 2 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 3 and days_hour = 2 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t3-2">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="3-2~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="3-2~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="3-2~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt3-3">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 3 and days_hour = 3 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 3 and days_hour = 3 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t3-3">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="3-3~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="3-3~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="3-3~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt3-4">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 3 and days_hour = 4 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 3 and days_hour = 4 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t3-4">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="3-4~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="3-4~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="3-4~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt3-5">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 3 and days_hour = 5 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 3 and days_hour = 5 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t3-5">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="3-5~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="3-5~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="3-5~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt3-6">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 3 and days_hour = 6 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 3 and days_hour = 6 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t3-6">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="3-6~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="3-6~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="3-6~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
            </tr>
            <!-- ------------------------------------------- Day Order - IV ------------------------------------------------- -->
            <tr>
                <td class="text-center"><b>IV</b></td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt4-1">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 4 and days_hour = 1 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 4 and days_hour = 1 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t4-1">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="4-1~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="4-1~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="4-1~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt4-2">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 4 and days_hour = 2 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 4 and days_hour = 2 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t4-2">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="4-2~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="4-2~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="4-2~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt4-3">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 4 and days_hour = 3 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 4 and days_hour = 3 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t4-3">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="4-3~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="4-3~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="4-3~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt4-4">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 4 and days_hour = 4 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 4 and days_hour = 4 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t4-4">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="4-4~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="4-4~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="4-4~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt4-5">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 4 and days_hour = 5 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 4 and days_hour = 5 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t4-5">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="4-5~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="4-5~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="4-5~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt4-6">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 4 and days_hour = 6 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 4 and days_hour = 6 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t4-6">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="4-6~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="4-6~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="4-6~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
            </tr>
            <!-- ------------------------------------------- Day Order - V ------------------------------------------------- -->
            <tr>
                <td class="text-center"><b>V</b></td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt5-1">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 5 and days_hour = 1 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 5 and days_hour = 1 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t5-1">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="5-1~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="5-1~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="5-1~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt5-2">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 5 and days_hour = 2 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 5 and days_hour = 2 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t5-2">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="5-2~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="5-2~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="5-2~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt5-3">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 5 and days_hour = 3 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 5 and days_hour = 3 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t5-3">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="5-3~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="5-3~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="5-3~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt5-4">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 5 and days_hour = 4 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 5 and days_hour = 4 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t5-4">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="5-4~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="5-4~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="5-4~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt5-5">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 5 and days_hour = 5 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 5 and days_hour = 5 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t5-5">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="5-5~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="5-5~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="5-5~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt5-6">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 5 and days_hour = 6 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 5 and days_hour = 6 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t5-6">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="5-6~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="5-6~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="5-6~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
            </tr>
            <!-- ------------------------------------------- Day Order - VI ------------------------------------------------- -->
            <tr>
                <td class="text-center"><b>VI</b></td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt6-1">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 6 and days_hour = 1 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 6 and days_hour = 1 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t6-1">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="6-1~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="6-1~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="6-1~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt6-2">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 6 and days_hour = 2 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 6 and days_hour = 2 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t6-2">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="6-2~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="6-2~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="6-2~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt6-3">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 6 and days_hour = 3 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 6 and days_hour = 3 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t6-3">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="6-3~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="6-3~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="6-3~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt6-4">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 6 and days_hour = 4 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 6 and days_hour = 4 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t6-4">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="6-4~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="6-4~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="6-4~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt6-5">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 6 and days_hour = 5 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 6 and days_hour = 5 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t6-5">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="6-5~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="6-5~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="6-5~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
                <td style="padding: 0px;">
                    <div style="width: 100%; height: 80px; position: relative;">
                        <div style="padding: 5px;" id="tt6-6">';
                if($_POST["staff_id"] == "All"){
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and day_order = 6 and days_hour = 6 and del_status", 0);
                }else{
                    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $_POST["degree_id"] ." and tt_year = ". $_POST["tt_year"] ." and semester = ". $_POST["semester"] ." and staff_id = ". $_POST["staff_id"] ." and day_order = 6 and days_hour = 6 and del_status", 0);
                }
                $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
        $html .= iif($course_name == "", "-Nil-", $course_name) .'
                        </div>
                        <div style="background-color: #ECF0F5; width: 100%; position: absolute; bottom: 0; padding: 2px 4px;" class="tt" id="t6-6">';
        $html .= iif($course_name != "", '
                            <a href="javascript:void(0);" class="delete pull-right" rel="6-6~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="6-6~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>', '
                            <a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="6-6~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>');
                $html.='</div>
                    </div>
                </td>
            </tr>

        </tbody>
    </table>';
    echo $html;
}
?>