
<?php require_once('config/db_connect.php');?>

<?php

  //initialize the session
  if(session_status() != PHP_SESSION_ACTIVE);
  session_start();
  
  $email = $password = '';

  $errors = array('email' => '' ,'password' => '' , 'message1' => '' , 'message2' => '' , 'status' => '');

  if(isset($_POST['login'])){

    // checking for emails...
    if(empty($_POST['email'])){
      $errors['email'] = "email is required <br/>";
    } else {
        $email = $_POST['email'];
        if(!filter_var($email , FILTER_VALIDATE_EMAIL)){
          $errors['email'] = "invalid email <br/>";
        }
      }

    // checking for passwords...
    if(empty($_POST['password'])){
      $errors['password'] = "input your password <br/>";
    } else {
      $password = md5($_POST['password']);
    }

    $checkAccount = $conn->query("SELECT * FROM tb_accounts WHERE email='$email' ");

    //fetch the resulting rows as an array.
    $row_account = $checkAccount->fetch_assoc();

    if ($row_account['email'] == $email) {
      if ($row_account['password'] != $password) {
        $errors['message2'] = "Wrong password, try again <br/>";
      }
    } else {
      $errors['message1'] = "This email does not exist,check well.<br/>";
    }
      //echo var_dump($row_account);
      if(array_filter($errors)) {
        $errors['status']  = "Error 509!";
      } else {
        $_SESSION['userInSession'] = $row_account['id'];
        $_SESSION['fullname'] = $row_account['fullname'];

        header('location:dashboard.php');
      }
  }

?>

<?php include('header.php');?>
            
  <div class="back-overlay">
    <section class="container ">
        <div class="row ">
            <div class="col-md-4"><img class=" img-fluid rounded m-4" style="width: 405px;" src="img/pic7.png" alt="no thumbnails"></div>

            <div class="col-md-4">
                <img class=" img-fluid rounded m-3" style="width: 206px;" src="img/pic8.png" alt="no thumbnails">
                <img class=" img-fluid rounded m-2" style="width: 205px; height: 140px;" src="img/pic2.png" alt="no thumbnails">
            </div>

            <div class="col-md-4 p-4 bg-secondary my-3 rounded ">
              <img class=" img-fluid rounded d-block mx-auto mt-0" style="width: 55px;" src="img/phonebooklogo.png" alt="no thumbnails">

              <form class ="small text-white" method="POST">
                <!-- for Email -->
                <div class="form-group form-text">
                  <label class="font-weight-bold">Email:</label>
                  <input class="form-control" type="text" id="email" name="email" placeholder="email address" value="<?php echo htmlspecialchars($_POST['email']); ?>">
                  <div class="text-danger"><small><?php echo $errors['email']; ?></small></div>
                  <small class = "text-danger font-weight-bold"><?php echo $errors['message1']; ?></small>
                  <small id="emailHelp" class="form-text font-weight-bold font-italic text-white">We'll never share your email with anyone else.</small>
                </div>

                <!-- for password -->
                <div class="form-group form-text">
                  <label class = "font-weight-bold">Password:</label>
                  <input class="form-control" type="password" id="password" name="password" placeholder="password" value="<?php echo htmlspecialchars($_POST['password']); ?>">
                  <div class="text-danger"><small><?php echo $errors['password']; ?></small></div>
                  <small class = "text-danger font-weight-bold"><?php echo $errors['message2']; ?></small>
                </div>

                <!-- to remember the password-->
                <div class="form-group">
                  <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="gridCheck">
                      <label class="form-check-label" for="gridCheck">
                        <p class="small ">remember me</p> 
                      </label>
                  </div>
                </div>

                <div class="small font-italic text-center">
                  <a class="text-white" href="#">forgot password?</a>
                </div>

                <!-- a div class for login button -->
                <div class="text-center">
                  <input class="rounded btn-sm  btn-danger" type="submit" name="login" value="sign in">
                </div>

                <div class="center small font-italic text-center">
                  <p class="">You don't have an account ? <a href="signup.php" class="text-danger">sign up</a></p>
                </div>
            </form>
        </div>  
    </section>
  </div>
<?php include('footer.php'); ?>
<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
<script>
  alert("<?php echo $errors['status']; ?>");
</script>
