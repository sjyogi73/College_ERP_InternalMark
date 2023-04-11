<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu" data-widget="tree">

      <?php $menu_permission = explode('||', $_SESSION["menu_permission"]); ?>
      <li class="header">MAIN NAVIGATION</li>

      <li id="dashboardMainNav">
        <a href="index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
      </li>
      
      <li><a href="students/dashboard.php"><i class="fa fa-users"></i> <span>Students</span></a></li>

      <li><a href="attendance/dashboard.php"><i class="fa fa-table"></i> <span>Attendance</span></a></li>

      <li><a href="internal_marks/dashboard.php"><i class="fa fa-language"></i> <span>Internal Marks</span></a></li>

      <li><a href="library/dashboard.php"><i class="fa fa-book"></i> <span>Library</span></a></li>
	  
      <li><a href="fees_collection/dashboard.php"><i class="fa fa-inr"></i> <span>Fees Collection</span></a></li>

      <li><a href="examination/dashboard.php"><i class="fa fa-university"></i> <span>Examination</span></a></li>

      <li><a href="hostel/dashboard.php"><i class="fa fa-building"></i> <span>Hostel</span></a></li>

      <li><a href="transport/dashboard.php"><i class="fa fa-bus"></i> <span>Transport</span></a></li>      

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
          if(in_array('createDepartment',$menu_permission) || in_array('viewDepartment',$menu_permission) || in_array('updateDepartment',$menu_permission) || in_array('deleteDepartment',$menu_permission)){ 
          ?>
          <li id="masterDepartmentSubNav"><a href="department.php">Department</a></li>
          <?php 
          }
          if(in_array('createDegree',$menu_permission) || in_array('viewDegree',$menu_permission) || in_array('updateDegree',$menu_permission) || in_array('deleteDegree',$menu_permission)){ 
          ?>
          <li id="masterDegreeSubNav"><a href="degree.php">Degree</a></li>
          <?php
          }
          if(in_array('createStudents',$menu_permission) || in_array('viewStudents',$menu_permission) || in_array('updateStudents',$menu_permission) || in_array('deleteStudents',$menu_permission)){ 
          ?>
          <li id="masterStudentSubNav"><a href="students_lst.php">Students</a></li>
          <?php
          }
          if(in_array('createStaffs',$menu_permission) || in_array('viewStaffs',$menu_permission) || in_array('updateStaffs',$menu_permission) || in_array('deleteStaffs',$menu_permission)){ 
          ?>
		      <li id="masterStaffSubNav"><a href="staffs_lst.php">Staffs</a></li>
          <?php
          }
          if(in_array('createDesignation',$menu_permission) || in_array('viewDesignation',$menu_permission) || in_array('updateDesignation',$menu_permission) || in_array('deleteDesignation',$menu_permission)){ 
          ?>
          <li id="masterDesignationSubNav"><a href="designation.php">Designation</a></li>
          <?php 
          }
          //if(in_array('createDesignation',$menu_permission) || in_array('viewDesignation',$menu_permission) || in_array('updateDesignation',$menu_permission) || in_array('deleteDesignation',$menu_permission)){ 
          ?>
          <li id="masterCommunitySubNav"><a href="community.php">Community</a></li>
          <?php 
          //}
          ?>
        </ul>
      </li>

      <li class="treeview" id="settingsMainNav">
        <a href="#">
          <i class="fa fa-cog"></i>
          <span>Settings</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <?php 
          if(in_array('createRoles',$menu_permission) || in_array('viewRoles',$menu_permission) || in_array('updateRoles',$menu_permission) || in_array('deleteRoles',$menu_permission)){ 
          ?>
          <li id="settingsRolesSubNav"><a href="roles_lst.php">Roles and Permissions</a></li>
          <?php 
          }
          if(in_array('createUsers',$menu_permission) || in_array('viewUsers',$menu_permission) || in_array('updateUsers',$menu_permission) || in_array('deleteUsers',$menu_permission)){ 
          ?>
          <li id="settingsUsersSubNav"><a href="users_lst.php">Users</a></li>
          <?php
          }
          ?>
        </ul>
      </li>

    </ul>
  </section>
</aside>