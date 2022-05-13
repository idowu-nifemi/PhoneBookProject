<?php
  
  include 'config/db_connect.php'; 

  $fullname = $email =$telephone=$password ='';

  $errors = array('fullname' => '', 'email' => '' ,'telephone'=> '', 'password' => '' ,'status' => '', 'message' => '');

  if(isset($_POST['sign_up'])){

    //checking fullname..
    if(empty($_POST['fullname'])){
      $errors['fullname'] = "fullname is required <br/>";
    }else {
      $fullname = $_POST['fullname'];
      if(!preg_match('/^[a-zA-Z\s]+$/' , $fullname)) {
        $errors['fullname'] = " fullname must be letters and spaces only <br/> ";
      }
    }

    // checking for emails..
    if(empty($_POST['email'])){
      $errors['email'] = "email is required <br/>";
    } else {
      $email = $_POST['email'];
      if(!filter_var($email , FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "invalid email <br/>";
      }
    }

    // checking for telephone..
    if(empty($_POST['telephone'])){
      $errors['telephone'] = "input your telephone no <br/>";
    } else {
      $telephone = $_POST['telephone'];
    }

    // checking for passwords...
    if(empty($_POST['password'])){
      $errors['password'] = "input your password <br/>";
    } else {
      $password = $_POST['password'];
    }

    // getting the email from the database
    $checkAccount = $conn->query("SELECT * FROM tb_accounts WHERE email='$email' ");
    
    //fetch the resulting rows as an array.
    $row_account = $checkAccount->fetch_assoc();

     //checking if the email has been used before   
    if ($row_account['email'] == $email) {
      $errors['message'] = "Email exist, try using another Email <br/>";
    }

    if(array_filter($errors)) {
      $errors['status'] =  "ERROR 505!! <br/>";
      
    }else {

      $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
      $email =  mysqli_real_escape_string($conn, $_POST['email']);
      $telephone = mysqli_real_escape_string($conn, $_POST['telephone']);
      $password = mysqli_real_escape_string($conn, $_POST['password']);
      $encPassword = md5($password); //encrypted the password

      // create sql:              
      $sql = "INSERT INTO tb_accounts (fullname,email,telephone,password)VALUES('$fullname','$email','$telephone','$encPassword')";

      if($conn->query($sql) === TRUE) { 
        //  sucess
        header('location:index.php');  
      }else {
         echo 'query error'.mysqli_error($conn);
      } 
    
    }  
        
  }
?>

<!DOCTYPE html>
  <html lang="en">
    <?php include "header.php"; ?>
     <div class="bg-faded">
       <div class="container">
          <div class="row">
            <div class="col-md-4"></div>

            <div class="col-md-4 p-4 m-5 bg-danger rounded">
                <img class="img-fluid rounded d-block mx-auto" style="width: 55px;" src="img/phonebooklogo.png" alt="no thumbnails">
                <form class="small text-white" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

                      <small class ="font-weight-bold"><?php echo $errors['status']; ?></small>
                      <!-- for fullname -->
                      <div class="form-group">
                        <label class = "font-weight-bold">fullname:</label>
                          <input class="form-control" type="text" name="fullname" placeholder="Full name" value="<?php echo htmlspecialchars($fullname); ?>">
                          <div class="text-white font-weight-bold"><small><?php echo $errors['fullname']; ?></small></div>
                      </div>

                      <!-- for email -->
                      <div class="form-group">
                          <label class = "font-weight-bold">Email:</label>
                          <input class="form-control" type="text" name="email" placeholder="Email address"  value="<?php echo htmlspecialchars($email); ?>">
                          <div class="text-white font-weight-bold"><small><?php echo $errors['email']; ?></small></div>
                          <div class="text-white font-weight-bold"><small><?php echo $errors['message']; ?></small></div>
                          <small id="emailHelp" class="form-text font-weight-bold text-white">We'll never share your email with anyone else.</small>
                      </div>

                      <!-- for telephone -->
                      <div class="form-group">
                          <label class = "font-weight-bold">Telephone:</label>
                          <input class="form-control" type="text" name="telephone" placeholder="Telephone no" value="<?php echo htmlspecialchars($telephone); ?>">
                          <div class="text-white font-weight-bold"><small><?php echo $errors['telephone']; ?></small></div>
                      </div>

                      <!-- for password -->
                      <div class="form-group">
                          <label class = "font-weight-bold">Password:</label>
                          <input class="form-control" type="password" name="password" placeholder="password" value="<?php echo htmlspecialchars($password); ?>">
                          <div class="text-white font-weight-bold"><small><?php echo $errors['password']; ?></small></div>
                      </div>

                      <!-- for the sign up button -->
                      <div class="text-center">
                        <input class="btn-sm  btn-primary rounded" type="submit" name="sign_up" value="sign up">
                      </div>

                      <div class="center small text-center">
                        <p class="">Already have an account ? <a href="index.php" class="text-white">sign in</a></p>
                      </div>
                </form>
            </div>

            <div class="col-md-4"></div>
          </div>
       </div>
     </div>    
  <?php include "footer.php"; ?>
</html>