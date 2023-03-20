<?php
require_once('functions.inc.php');

if (isset($_SESSION['user']['id'])) {
  header('location:index.php');
  exit(); 
}

$error = [];

if ($_POST) {

  // Validate all fields
  $email = $_POST['email'];
  if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,10})$^", $email)){
    $error['email'][] = 'Invalid email format';
  }
  
  $password = $_POST['password'];
  $password2 = $_POST['password2'];
  if (strlen($password) < 5) {
      $error['password'][] = 'The password must be 5+ characters';
  }
  if ($password != $password2) {
      $error['password'][] = 'The passwords do not match';
  }
  $password = mysqli_real_escape_string($conn, $password);
  
  
  $first_name = $_POST['first_name'];
  if (strlen($first_name) < 3) {
      $error['first_name'][] = 'The first name must be 3+ characters';
  }
  else {
      $first_name = mysqli_real_escape_string($conn, $first_name);
  }

  $last_name = $_POST['last_name'];
  if (strlen($first_name) < 3) {
      $error['last_name'][] = 'The last name must be 3+ characters';
  }
  else {
      $last_name = mysqli_real_escape_string($conn, $last_name);
  }


  if (count($error) == 0) {

      $query = "
      INSERT INTO user 
      SET
          email = '$email',
          `password` = SHA2('$password', 256),
          first_name = '$first_name',
          last_name = '$last_name'";
         
      try  {    
          mysqli_query($conn, $query);
          // TO DO: Send email
          header('location:login.php');
          exit();
      }
      catch (Exception $e)  {
        //echo $query;
        //echo $e->getMessage();
        $error['email'][] = 'There is a user registered with this email'; 
      }

  }
}

require_once('header.inc.php');
?>
<h1 class="title is-4">Register</h1>
<div class="columns">    
    <div class="column is-half">

<form action="register.php" method="post" id="form1">

<div class="field">
<label class="label">Email</label>
<div class="control">
    <input class="input<?php echo isset($error['email']) ? ' is-danger' : ''; ?>" type="email" name="email" value="<?php echo isset($email) ? $email : '' ?>">
</div>
<?php
echo showFormErrors($error, 'email');
?>
</div>


<div class="field">
<label class="label">Password</label>
<div class="control">
    <input class="input<?php echo isset($error['password']) ? ' is-danger' : ''; ?>" type="password" name="password">
</div>
<?php
echo showFormErrors($error, 'password');
?>
</div>

<div class="field">
<label class="label">Re-enter Password</label>
<div class="control">
    <input class="input" type="password" name="password2">
</div>
</div>


<div class="field">
<label class="label">First Name</label>
<div class="control">
    <input class="input<?php echo isset($error['first_name']) ? ' is-danger' : ''; ?>" type="text" name="first_name" value="<?php echo isset($first_name) ? $first_name : '' ?>">
</div>
<?php
echo showFormErrors($error, 'first_name');
?>
</div>

<div class="field">
<label class="label">Last Name</label>
<div class="control">
    <input class="input<?php echo isset($error['last_name']) ? ' is-danger' : ''; ?>" type="text" name="last_name" value="<?php echo isset($last_name) ? $last_name : '' ?>">
</div>
<?php
echo showFormErrors($error, 'last_name');
?>
</div>

<div class="field is-grouped">
<div class="control">
    <input type="submit" class="button is-primary" value="Submit">
</div>        
</div>

</form>

    </div>    
</div>    
<?php
require_once('footer.inc.php');
?>