<?php
require_once('functions.inc.php');
  

    //print_r($_POST);

    //print_r($_FILES);

$error = [];    

if ($_POST) {

    if (strlen($_POST['name']) < 3) {
        $error['name'][] = 'The name must be at least 3 characters';
    }

}

if ($_FILES) {    
    
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
        $target_name = $_SERVER['DOCUMENT_ROOT'] . '/' . $product_pictures_path . '/' . uniqid() .'.' . $info['extension'];
    

        if (move_uploaded_file($_FILES['picture']['tmp_name'], $target_name)) {
        
            generateThumbnail($target_name);
        
        }
        else {
            $error['picture'][] = 'Error while uploading file';
        }
    }   
    
}


require_once('header.inc.php');
?>
<h1 class="title is-4">File Upload</h1>
<div class="columns">
    <div class="column is-half">
        
    <form action="picture_form.php" method="post" enctype="multipart/form-data">

        <div class="field">
        <label class="label">Name</label>
        <div class="control">
            <input class="input<?php echo isset($error['name']) ? ' is-danger' : ''; ?>" type="text" name="name">
        </div>
        <?php
        echo showFormErrors($error, 'name');
        ?>
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