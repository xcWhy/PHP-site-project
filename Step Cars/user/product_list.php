<?php
require_once('functions.inc.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

require_once('header.inc.php');
?>
<h1 class="title is-4">TO DO</h1>
<div class="columns">
    <div class="column is-one-quarter">        
<aside class="menu">
  <p class="menu-label">
  Categories
  </p>
  <ul class="menu-list">
<?php
$query = "SELECT * FROM category";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($result)) {
    echo "<li><a " . ($row['id'] == $id ? "class=\"has-text-primary\"" : '') . " href=\"product_list.php?id={$row['id']}\">{$row['name']}</a></li>";
}
?>    
  </ul>
</aside>
    </div>
    <div class="column">

<?php
$query = "SELECT * FROM product WHERE category_id = $id";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($result)) {
?>  
<div class="box">
  <div class="columns">
    <div class="column is-one-third"> 
    <?php 
      echo $row['picture'] != '' ? '<a href="product.php?id=' .$row["id"]. '"><img src="/' . $product_pictures_path . '/thumb/' . $row['picture'] . '"></a>': '';
     ?>
    </div> 
    <div class="column"> 
      <h2 class="title is-4"><a href="product.php?id=<?php echo $row['id']; ?>"><?php echo  htmlentities($row['name']) ?></a></h2>
      <div><?php echo nl2br(substr(htmlentities($row['description']), 0, 200)) ?></div>
      <div><?php echo  sprintf('$%01.2f', $row['price']) ?></div>
      <div><?php echo  $row['availability'] ?></div>
      <div><?php echo  $row['is_promo'] ? 'promo' : '' ?></div>
      <div><a href="cart.php?action=add&id=<?php echo $row['id']?>" class="button is-primary"><ion-icon name="cart-outline"></ion-icon> Add to cart</a></div>
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