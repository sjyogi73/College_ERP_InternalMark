<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu" data-widget="tree">

      <?php $menu_permission = explode('||', $_SESSION["menu_permission"]); ?>
      <li class="header">MAIN NAVIGATION</li>

      <li><a href="../dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard - Main</span></a></li>

      <li id="dashboardMainNav">
        <a href="dashboard.php"><i class="fa fa-table"></i> <span>Dashboard - Attendance</span></a>
      </li>
      
      <li class="treeview" id="transMainNav">
        <a href="#">
          <i class="fa fa-desktop"></i>
          <span>Transaction</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li id="transTimetableSubNav"><a href="daily_att.php">Daily Attendance</a></li>
        </ul>
      </li>
      
      <li class="treeview" id="masterMainNav">
        <a href="#">
          <i class="fa fa-edit"></i>
          <span>Masters</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <?php 
          //if(in_array('createDepartment',$menu_permission) || in_array('viewDepartment',$menu_permission) || in_array('updateDepartment',$menu_permission) || in_array('deleteDepartment',$menu_permission)){ 
          ?>
          <li id="masterTimetableSubNav"><a href="timetable.php">Timetable</a></li>
          <?php 
          // }
          ?>
          <?php 
          //if(in_array('createDepartment',$menu_permission) || in_array('viewDepartment',$menu_permission) || in_array('updateDepartment',$menu_permission) || in_array('deleteDepartment',$menu_permission)){ 
          ?>
          <li id="masterDayorderSubNav"><a href="dayorder.php">Day Order</a></li>
          <?php 
          // }
          ?>
        </ul>
      </li>

    </ul>
  </section>
</aside>