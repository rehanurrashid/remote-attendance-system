<?php
    // include Zk library
    include "zklibrary.php";

    // include database and object files
    include_once 'config/database.php';
    include_once 'objects/hr_employee.php';
    include_once 'objects/att_punches.php';


  // $host="39.32.230.228";

  // exec("ping -c 1 " . $host, $output, $result);

  //   echo '<pre>',print_r($output);

  //   if ($result == 0)

  //   echo "Ping successful!";

  //   else

  //   echo "Ping unsuccessful!";
    
  //   exit;

    
    $zk = new ZKLibrary('39.32.230.228', 4370, 'TCP');
    $zk->connect();
    // $check = $zk->connect();
    // $test =1;
    // if($test){
    //   var_dump($zk); exit;
    // }
    
    // $zk->disableDevice();

    // instantiate database and object
    $database = new Database();
    $db = $database->getConnection();

    // initialize object
    $users_obj = new hr_employee($db);
    $attendace_obj = new att_punches($db);

    // Getting Users and attendace 
    $users = $zk->getUser();
    $attendace = $zk->getAttendance();

    foreach($users as $user){
      $users_obj->emp_pin       = $user[0];
      $users_obj->emp_firstname = $user[1];
      $users_obj->emp_role      = $user[2];
      $users_obj->emp_pwd       = $user[3];
      
      // create
            $check = $users_obj->create();
            // if($check){
            //      echo "success";   
            // }
             
            // // if unable to create
            // else{
            //      echo "Faild";  
            // }
    }
    $no=1;
    foreach($attendace as $at){
      $attendace_obj->employee_id   = $at[0];
      // $attendace_obj->emp_firstname = $at[1];
      $attendace_obj->status      = $at[2];
      $attendace_obj->punch_time    = $at[3];
      $attendace_obj->id = $no++;
      // create
            $check = $attendace_obj->create();
            // if($check){
            //      echo "Success";   
            // }
             
            // // if unable to create
            // else{
            //      echo "Faild";  
            // }
    }
    ?>

<table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
<thead>
  <tr>
    <td width="25">No</td>
    <td>UID</td>
    <td>ID</td>
    <td>Name</td>
    <td>Role</td>
    <td>Password</td>
  </tr>
</thead>

<tbody>
<?php
$no = 0;
foreach($users as $key=>$user)
{
  $no++;
?>

  <tr>
    <td align="right"><?php echo $no;?></td>
    <td><?php echo $key;?></td>
    <td><?php echo $user[0];?></td>
    <td><?php echo $user[1];?></td>
    <td><?php echo $user[2];?></td>
    <td><?php echo $user[3];?></td>
  </tr>

<?php
}
?>

</tbody>
</table>
<br /><br />
<table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
<thead>
  <tr>
    <td width="25">No</td>
    <td>UID</td>
    <td>ID</td>
    <td>State</td>
    <td>Date/Time</td>
  </tr>
</thead>

<tbody>
<?php
$no = 0;
foreach($attendace as $key=>$at)
{
  $no++;
?>

  <tr>
    <td align="right"><?php echo $no;?></td>
    <td><?php echo $at[0];?></td>
    <td><?php echo $at[1];?></td>
    <td><?php echo $at[2];?></td>
    <td><?php echo $at[3];?></td>
  </tr>

<?php
}
?>

</tbody>
</table>
<?php

// $zk->enableDevice();
// $zk->disconnect();

?>
