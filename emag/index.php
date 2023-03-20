<?php
require_once('functions.inc.php');
require_once('header.inc.php');
?>
<h1 class="title is-4">Welome to Emag</h1>
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
    echo "<li><a href=\"product_list.php?id={$row['id']}\">{$row['name']}</a></li>";
}
?>    
  </ul>
</aside>
    </div>
    <div class="column">
        Promo products:
        <?php
        
        print_r($_SESSION);
        
        ?>
    </div>    
</div>    
<?php
require_once('footer.inc.php');
?>