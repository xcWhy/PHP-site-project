<?php
require_once('functions.inc.php');

$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : 0;


if ($action == 'add' ) {  
  $_SESSION['cart'][$id] = isset($_SESSION['cart'][$id]) ? $_SESSION['cart'][$id] + 1 : 1; 
  Header('Location: cart.php');
  exit();
}

if ($action == 'increase') {
  if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]++;
  } 
}

if ($action == 'decrease') {
  
}

if ($action == 'remove') {
  unset($_SESSION['cart'][$id]);
}

if ($action == 'empty') {
  unset($_SESSION['cart']);  
}



require_once('header.inc.php');
?>
<h1 class="title is-4">Shopping Cart</h1>
<div class="columns">    
    <div class="column">

<?php
if (isset($_SESSION['cart']) && count($_SESSION['cart'])) {
?>



<table class="table">
  <thead>
    <tr>        
      <th>Name</th>
      <th>Qtty</th> 
      <th></th>     
      <th>Price</th>
      <th>Amount</th>
      <th></th>          
    </tr>
  </thead>
  <tbody>
<?php

$cart_product_ids = array_keys($_SESSION['cart']);

$query = "SELECT * FROM product WHERE id IN (" . join(', ', $cart_product_ids). ")";
$result = mysqli_query($conn, $query);

$total = 0;
while ($row = mysqli_fetch_array($result)) {  
  $qtty = $_SESSION['cart'][$row['id']];
  $amount = $qtty * $row['price'];
  $total += $amount;
  echo "
    <tr>    
    <td>". htmlentities($row['name']) . "</td>  
    <td>$qtty</td> 
    <td>
    <a href=\"cart.php?action=increase&id={$row['id']}\"><ion-icon name=\"caret-up-outline\"></ion-icon></a>
      <ion-icon name=\"caret-down-outline\"></ion-icon>
    </td>   
    <td>". $row['price'] . "</td>
    <td>$amount</td> 
    <td>
      <a href=\"cart.php?action=remove&id={$row['id']}\"><ion-icon name=\"trash-outline\"></ion-icon></a>      
    </td>   
    </tr>";
};
?>    
  </tbody>
</table>
Total: <?php echo $total; ?>

<div class="mt-4">
<a href="cart.php?action=empty" class="button is-primary">Empty my cart</a>
</div>

<?php
}
else {
  echo "Your cart is empty.";
}
?>

    </div>    
</div>    
<?php
require_once('footer.inc.php');
?>