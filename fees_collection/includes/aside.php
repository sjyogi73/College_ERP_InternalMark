<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu" data-widget="tree">

      <?php //$menu_permission = explode('||', $_SESSION["menu_permission"]); ?>
      <li class="header">MAIN NAVIGATION</li>

      <li><a href="../dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard - Main</span></a></li>

      <li id="dashboardMainNav">
        <a href="dashboard.php"><i class="fa fa-inr"></i> <span>Dashboard - Fees Collection</span></a>
      </li>
      
      <li class="treeview" id="transactionMainNav">
        <a href="#">
          <i class="fa fa-edit"></i>
          <span>Transaction</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <?php 
          //if(in_array('createDepartment',$menu_permission) || in_array('viewDepartment',$menu_permission) || in_array('updateDepartment',$menu_permission) || in_array('deleteDepartment',$menu_permission)){ 
          ?>
          <li id="masterFeesmasterSubNav"><a href="feesmaster.php">Fees Master</a></li>
          <?php 
          //}
          ?>
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
          <li id="masterFeesmasterSubNav"><a href="feesmaster.php">Fees Master</a></li>
          <?php 
          //}
          //if(in_array('createDegree',$menu_permission) || in_array('viewDegree',$menu_permission) || in_array('updateDegree',$menu_permission) || in_array('deleteDegree',$menu_permission)){ 
          ?>
          <li id="masterFeesStructureSubNav"><a href="fees_structure_lst.php">Fees Structure</a></li>
          <?php 
          //}
          ?>
        </ul>
      </li>

      <!-- <li class="treeview" id="settingsMainNav">
        <a href="#">
          <i class="fa fa-cog"></i>
          <span>Settings</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <?php 
          //if(in_array('createRoles',$menu_permission) || in_array('viewRoles',$menu_permission) || in_array('updateRoles',$menu_permission) || in_array('deleteRoles',$menu_permission)){ 
          ?>
          <li id="settingsRolesSubNav"><a href="roles_lst.php">Roles and Permissions</a></li>
          <?php 
          //}
          //if(in_array('createUsers',$menu_permission) || in_array('viewUsers',$menu_permission) || in_array('updateUsers',$menu_permission) || in_array('deleteUsers',$menu_permission)){ 
          ?>
          <li id="settingsUsersSubNav"><a href="users_lst.php">Users</a></li>
          <?php
          //}
          ?>
        </ul>
      </li> -->

    </ul>
  </section>
</aside>