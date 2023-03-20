<?php
require_once('functions.inc.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

require_once('header.inc.php');
?>
<h1 class="title is-4">TO DO</h1>
<div class="columns">    
    <div class="column">

<?php
$query = "SELECT * FROM product WHERE id = $id";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($result)) {
?>  
<div class="box">
  <div class="columns">
    <div class="column is-one-third"> 
    <?php 
      echo $row['picture'] != '' ? '<a href=""><img src="/' . $product_pictures_path . '/' . $row['picture'] . '"></a>': '';
     ?>
    </div> 
    <div class="column"> 
      <h2 class="title is-4"><?php echo  htmlentities($row['name']) ?></h2>
      <div><?php echo nl2br(htmlentities($row['description'])) ?></div>
      <div><?php echo  sprintf('$%01.2f', $row['price']) ?></div>
      <div><?php echo  $row['availability'] ?></div>
      <div><?php echo  $row['is_promo'] ? 'promo' : '' ?></div>
    </div> 
  </div>
</div>        
<?php    
}
?>
    </div>    
</div>    
<?php
require_once('footer.inc.php');
?>