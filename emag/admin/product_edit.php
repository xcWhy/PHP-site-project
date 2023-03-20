<?php
require_once('functions.inc.php');

$error = [];

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($_POST) {

    // Validate all fields
    $name = $_POST['name'];
    if (strlen($name) < 3) {
        $error['name'][] = 'The product name must be 3+ characters';
    }
    else {
        $name = mysqli_real_escape_string($conn, $name);
    }

    $price = (double)$_POST['price'];
    if ($price < 0) {
        $error['price'][] = 'The price must be a positive number';
    }

    $category_id = (int)$_POST['category_id'];
    $is_promo = (isset($_POST['is_promo']) ? 1 : 0);
    $availability = mysqli_real_escape_string($conn, $_POST['availability']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $file_name = '';

    if ($_FILES) {    

        if ($_FILES['picture']['error'] == 0) {
    
            // Check type
            if (!in_array($_FILES['picture']['type'], $allowed_picture_types)) {
                $error['picture'][] = 'File type not allowed';
            }
            
            // Check Size
            if ($_FILES['picture']['size'] > $max_image_size) {
                $error['picture'][] = 'The file size must be under 50 MB';
            }
        
            if (!isset($error['picture'])) {
        
                $info = pathinfo($_FILES['picture']['name']);
                $file_name = uniqid() .'.' . $info['extension'];
                $target_name = $_SERVER['DOCUMENT_ROOT'] . '/' . $product_pictures_path . '/' . $file_name;
            
        
                if (move_uploaded_file($_FILES['picture']['tmp_name'], $target_name)) {
                    generateThumbnail($target_name);
                }
                else {
                    $error['picture'][] = 'Error while uploading file';
                }
            }   
        }
        
    }



    if (count($error) == 0) {

        $query = "
        UPDATE product 
        SET
            name = '$name',
            price = $price,
            category_id = $category_id,
            is_promo = $is_promo,
            availability = '$availability'
            ". ( $file_name != '' ? " , picture = '$file_name'" : '' ) . "
        WHERE
            id = $id";

        //echo $query;    
        mysqli_query($conn, $query);    


        header('location:product_list.php');
        exit();
    }
}


$query = "SELECT * FROM product WHERE id = $id";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_array($result)) {
    require_once('header.inc.php');

?>
<h1 class="title is-4">Edit Product</h1>
<div class="columns">
    <div class="column is-half">
        
    <form action="product_edit.php?id=<?php echo $id; ?>" method="post" id="form1"  enctype="multipart/form-data">

        <div class="field">
        <label class="label">Name</label>
        <div class="control">
            <input class="input<?php echo isset($error['name']) ? ' is-danger' : ''; ?>" type="text" name="name" value="<?php echo isset($name) ? $name : $row['name'] ?>">
        </div>
        <?php
        echo showFormErrors($error, 'name');
        ?>
        </div>

        <div class="field">
        <label class="label">Price</label>
        <div class="control">
            <input class="input<?php echo isset($error['price']) ? ' is-danger' : ''; ?>" type="text" name="price" value="<?php echo isset($price) ? $price : $row['price'] ?>">
        </div>
        <?php
        echo showFormErrors($error, 'price');
        ?>
        </div>

        <div class="field">
        <label class="label">Category</label>
        <div class="control">
            <div class="select">
            <select name="category_id">
                <?php
                    $query = "SELECT * FROM category";
                    $result = mysqli_query($conn, $query);
                    while ($category = mysqli_fetch_array($result))  {                  
                        echo "<option " . 
                            ((isset($category_id) && ($category_id == $category['id'])) || 
                             ($category['id'] == $row['category_id']) 
                             ? 
                             'selected' 
                             : 
                             '') . 
                             " value=\"{$category['id']}\">{$category['name']}</option>";
                    }
                ?>
            </select>
            </div>
        </div>
        </div>

        <div class="field">
        <label class="label">Description</label>
        <div class="control">
            <textarea name="description" class="textarea"><?php echo isset($description) ? $description : $row['description'] ?></textarea>
        </div>
        </div>

        <div class="field">
        <label class="label">Promotional</label>
        <div class="control">
            <label class="checkbox">
            <input name="is_promo" type="checkbox" <?php echo (isset($is_promo) && $is_promo) || $row['is_promo'] ? 'checked' : '' ?>>
            Promotional
            </label>
        </div>
        </div>

        <div class="field">
        <label class="label">Availability</label>
        <div class="control">
            <label class="radio">
            <input type="radio" name="availability" value="out_of_stock" <?php echo (isset($availability) && ($availability == 'out_of_stock')) || ($row['availability'] == 'out_of_stock') ? 'checked' : '' ?>>
            Out of stock
            </label>
            <label class="radio">
            <input type="radio" name="availability" value="available" <?php echo ($row['availability'] == 'available') || (isset($availability) && ($availability == 'available')) ? 'checked' : '' ?>>
            Available
            </label>
            <label class="radio">
            <input type="radio" name="availability" value="expected" <?php echo (isset($availability) && ($availability == 'expected')) || ($row['availability'] == 'expected') ? 'checked' : '' ?>>
            Expected
            </label>
        </div>
        </div>

        <div class="field">
        <label class="label">Picture</label>
        <div class="control">
            <input class="input<?php echo isset($error['picture']) ? ' is-danger' : ''; ?>" type="file" name="picture">
        </div>
        <div>
<?php            
        if ($row['picture'] != '') {
            echo '<img src="/' . $product_pictures_path . '/thumb/' . $row['picture'] . '">';
        }         
?>        
        </div>
        <?php
        echo showFormErrors($error, 'picture');
        ?>
        </div>


        <div class="field is-grouped">
        <div class="control">
            <input type="submit" class="button is-primary" value="Submit">
        </div>        
        <div class="control">
            <a href="product_list.php" class="button is-link is-light">Cancel</a>
        </div>
        </div>

    </form>
    </div>
</div>
<?php
    require_once('footer.inc.php');
}
else {
  echo "No product with that id";
}
?>