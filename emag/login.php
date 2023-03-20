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
  if (strlen($password) < 5) {
      $error['password'][] = 'The password must be 5+ characters';
  }  
  $password = mysqli_real_escape_string($conn, $password);
  
  if (count($error) == 0) {

      $query = "
      SELECT 
        id, email, first_name, is_admin 
      FROM 
        user
      WHERE
        email = '$email' AND
        password = SHA2('$password', 256) AND 
        is_active = 1";
         
      if ($result = mysqli_query($conn, $query)) {    
          if ($row = mysqli_fetch_array($result)) {
            
            $_SESSION['user']['id'] = $row['id'];
            $_SESSION['user']['email'] = $row['email'];
            $_SESSION['user']['first_name'] = $row['first_name'];
            $_SESSION['user']['is_admin'] = $row['is_admin'];
            
            header('location:index.php');
            exit();    
          }           
      }
      $error['email'][] = 'Invalid login'; 
      

  }
}

require_once('header.inc.php');
?>
<h1 class="title is-4">Login</h1>
<div class="columns">    
    <div class="column is-half">

<form action="login.php" method="post" id="form1">

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
    <input class="input" type="password" name="password">
</div>
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