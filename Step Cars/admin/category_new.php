<?php
require_once('functions.inc.php');

$error = [];

if ($_POST) {

    // Validate all fields
    $name = $_POST['name'];
    if (strlen($name) < 3) {
        $error['name'][] = 'The product name must be 3+ characters';
    }
    else {
        $name = mysqli_real_escape_string($conn, $name);
    }


    if (count($error) == 0) {

        $query = "
        INSERT INTO category 
        SET
            name = '$name'";

        //echo $query;    
        mysqli_query($conn, $query);    

        header('location:category_list.php');
        exit();
    }
}
require_once('header.inc.php');
?>
<h1 class="title is-4">New Category</h1>
<div class="columns">
    <div class="column is-half">
        
    <form action="category_new.php" method="post" id="form1">

        <div class="field">
        <label class="label">Name</label>
        <div class="control">
            <input class="input<?php echo isset($error['name']) ? ' is-danger' : ''; ?>" type="text" name="name" value="<?php echo isset($name) ? $name : '' ?>">
        </div>
        <?php
        echo showFormErrors($error, 'name');
        ?>
        </div>

        <div class="field is-grouped">
        <div class="control">
            <input type="submit" class="button is-primary" value="Submit">
        </div>        
        <div class="control">
            <a href="category_list.php" class="button is-link is-light">Cancel</a>
        </div>
        </div>

    </form>
    </div>
</div>
<?php
require_once('footer.inc.php');
?>