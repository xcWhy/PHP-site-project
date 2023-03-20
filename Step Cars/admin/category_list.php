<?php
require_once('functions.inc.php');
require_once('header.inc.php');
?>
<h1 class="title is-4">Categories</h1>

<a href="category_new.php">Add new category</a>


<table class="table">
  <thead>
    <tr>
      <th></th>
      <th>Id</th>  
      <th>Name</th>        
    </tr>
  </thead>
  <tbody>
<?php

$query = "SELECT * FROM category";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_array($result)) {  
  echo "
    <tr>
    <td>
      <a href=\"category_edit.php?id={$row['id']}\"><ion-icon name=\"create-outline\"></ion-icon></a> 
      <a href=\"category_delete.php?id={$row['id']}\" onclick=\"return confirm('Are you sure?');\"><ion-icon name=\"trash-outline\"></ion-icon></a>
    </td>
    <td>". $row['id'] . "</td> 
    <td>". htmlentities($row['name']) . "</td>      
    </tr>";
};
?>
    
  </tbody>
</table>


<?php
require_once('footer.inc.php');
?>