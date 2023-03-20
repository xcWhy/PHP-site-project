<?php
require_once('functions.inc.php');

$error = [];

if ($_POST) {


    // Validate all fields
    $category = (int)$_POST['category'];
    if (strlen($category) < 3) {
        $error['category'][] = 'The car category must be 3+ characters';
    }
    else {
        $category = mysqli_real_escape_string($conn, $category);
    }

    $model = $_POST['model'];
    if (strlen($model) < 3) {
        $error['model'][] = 'The model name must be 3+ characters';
    }

    $price = (double)$_POST['price'];
    if ($price < 0) {
        $error['price'][] = 'The price must be a positive number';
    }

    $production_year = $_POST['production_year'];
    if ($production_year < 0) {
        $error['production_year'][] = 'The production_year must be a positive number';
    }
    if ($production_year < 1900 || $production_year > 2030) {
        $error['production_year'][] = 'The production year must be between 1900 - 2030';
    }

    $is_used = (isset($_POST['is_used']) ? 1 : 0);
    $color = mysqli_real_escape_string($conn, $_POST['color']);
    $engine = mysqli_real_escape_string($conn, $_POST['engine']);


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
        // echo "ehoooo?";

        $query = "
        INSERT INTO product 
        SET
            category_id = $category,
            model = '$model',
            price = $price,
            production_year = $production_year,
            is_used = $is_used,
            color = '$color',
            engine = '$engine';
            picture = '$file_name'";

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
}

?>

<h1 class="title is-4">New Car</h1>
<div class="columns">
    <div class="column is-half">
        
    <form action="product_new.php" method="post" id="form1"  enctype="multipart/form-data">

        <div class="field">
        <label class="label">Category car</label>
        <div class="control">
            <div class="select">
            <select name="category">
                <?php
                    $query = "SELECT * FROM category";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_array($result))  {                  
                        echo "<option " . (isset($category) && $category == $row['id'] ? 'selected' : '') . " value=\"{$row['id']}\">{$row['name']}</option>";
                    }
                ?>
            </select>
            </div>
        </div>
        </div>

        <div class="field">
        <label class="label">Model</label>
        <div class="control">
            <input class="input<?php echo isset($error['model']) ? ' is-danger' : ''; ?>" type="text" name="model" value="<?php echo isset($model) ? $model : '' ?>">
        </div>
        <?php
        echo showFormErrors($error, 'model');
        ?>
        </div>

        <div class="field">
        <label class="label">Price</label>
        <div class="control">
            <input class="input<?php echo isset($error['price']) ? ' is-danger' : ''; ?>" type="text" name="price" value="<?php echo isset($price) ? $price : '' ?>">
        </div>
        <?php
        echo showFormErrors($error, 'price');
        ?>
        </div>

        <div class="field">
        <label class="label">Production Year</label>
        <div class="control">
            <input class="input<?php echo isset($error['production_year']) ? ' is-danger' : ''; ?>" type="text" name="production_year" value="<?php echo isset($production_year) ? $production_year : '' ?>">
        </div>
        <?php
        echo showFormErrors($error, 'production_year');
        ?>
        </div>

        <div class="field">
        <label class="label">Used</label>
        <div class="control">
            <label class="checkbox">
            <input name="is_used" type="checkbox" <?php echo isset($is_used) && $is_used ? 'checked' : '' ?>>
            Is it used
            </label>
        </div>
        </div>

        <div class="field">
        <label class="label">Color</label>
        <div class="control">
            <label class="radio">
            <input type="radio" name="color" value="grey" <?php echo isset($color) && ($color == 'grey') ? 'checked' : '' ?>>
            Grey
            </label>
            <label class="radio">
            <input type="radio" name="color" value="red" <?php echo !isset($color) || (isset($color) && ($color == 'red')) ? 'checked' : '' ?>>
            Red
            </label>
            <label class="radio">
            <input type="radio" name="color" value="white" <?php echo isset($color) && ($color == 'white') ? 'checked' : '' ?>>
            White
            </label>
        </div>
        </div>

        <div class="field">
        <label class="label">Engine</label>
        <div class="control">
            <label class="radio">
            <input type="radio" name="engine" value="gasoline" <?php echo isset($engine) && ($engine == 'gasoline') ? 'checked' : '' ?>>
            Gasoline
            </label>
            <label class="radio">
            <input type="radio" name="engine" value="electric" <?php echo !isset($engine) || (isset($engine) && ($engine == 'electric')) ? 'checked' : '' ?>>
            Electric
            </label>
            <label class="radio">
            <input type="radio" name="engine" value="hybrid" <?php echo isset($engine) && ($engine == 'hybrid') ? 'checked' : '' ?>>
            Hybrid
            </label>
        </div>
        </div>

        <div class="field">
        <label class="label">Picture</label>
        <div class="control">
            <input class="input<?php echo isset($error['picture']) ? ' is-danger' : ''; ?>" type="file" name="picture">
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
?>