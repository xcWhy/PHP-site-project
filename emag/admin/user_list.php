<?php
require_once('functions.inc.php');

if ($_GET) {

  $id = (int)$_GET['id'];
  $action = $_GET['action']; 

  if ($action == 'setactive') {
    $query = "UPDATE user SET is_active = 1 - is_active WHERE id = $id";
    mysqli_query($conn, $query);
  }

  if ($action == 'setadmin') {
    $query = "UPDATE user SET is_admin = 1 - is_admin WHERE id = $id";
    mysqli_query($conn, $query);    
  }

}


require_once('header.inc.php');
?>
<h1 class="title is-4">Users</h1>

<table class="table">
  <thead>
    <tr>
      <th></th>
      <th>Id</th>  
      <th>Email</th>  
      <th>First Name</th> 
      <th>Last Name</th> 
      <th>Active</th>
      <th>Admin</th>      
    </tr>
  </thead>
  <tbody>
<?php

$query = "SELECT * FROM user";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_array($result)) {  
  echo "
    <tr>
    <td>             
    </td>
    <td>". $row['id'] . "</td> 
    <td>". $row['email'] . "</td>      
    <td>". htmlentities($row['first_name']) . "</td>
    <td>". htmlentities($row['last_name']) . "</td>     
    <td>". ($row['is_active'] ? '*' : '') . " <a href=\"user_list.php?action=setactive&id={$row['id']}\"><ion-icon name=\"create-outline\"></ion-icon></a></td>  
    <td>". ($row['is_admin'] ? '*' : '') . " <a href=\"user_list.php?action=setadmin&id={$row['id']}\"><ion-icon name=\"create-outline\"></ion-icon></a></td> 
    </tr>";
};
?>
    
  </tbody>
</table>


<?php
require_once('footer.inc.php');
?>