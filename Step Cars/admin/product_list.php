<?php
require_once('functions.inc.php');
require_once('header.inc.php');
?>
<h1 class="title is-4">Cars</h1>

<a href="product_new.php">Add new car</a>


<table class="table">
  <thead>
    <tr>
      <th></th>
      <th>Id</th>  
      <th>Category car</th>
      <th>Model</th>
      <th>Price</th>
      <th>Production year</th>      
      <th>Used</th>
      <th>Color</th>   
      <th>Engine</th>   
      <th>Picture</th>    
    </tr>
  </thead>
  <tbody>
<?php

$query = "SELECT 
p.*, c.name AS category_name
FROM product p
LEFT OUTER JOIN category c
ON p.category_id = c.id";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_array($result)) {  
  echo "
    <tr>
    <td>
      <a href=\"product_edit.php?id={$row['id']}\"><ion-icon name=\"create-outline\"></ion-icon></a> 
      <a href=\"product_delete.php?id={$row['id']}\" onclick=\"return confirm('Are you sure?');\"><ion-icon name=\"trash-outline\"></ion-icon></a>
    </td>
    <td>". $row['id'] . "</td> 
    <td>". htmlentities($row['category_id']) . "</td>      
    <td>". htmlentities($row['model']) . "</td>      
    <td>". $row['price'] . "</td>
    <td>". $row['production_year'] . "</td>   
    <td>". ($row['is_used'] ? '*' : '') . "</td>
    <td>". htmlentities($row['color']) . "</td>
    <td>". htmlentities($row['engine']) . "</td>
    <td>". ($row['picture'] != '' ? '<a target="_blank" href="/' . $product_pictures_path . '/' . $row['picture'] . '"><img src="/' . $product_pictures_path . '/thumb/' . $row['picture'] . '"></a>': '') . "</td>
  </tr>";
};
?>
    
  </tbody>
</table>




<?php
require_once('footer.inc.php');
?>