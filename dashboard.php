<?php 
  //initialize the session
  if(session_status() != PHP_SESSION_ACTIVE);
  session_start();

    //conditional
    $userInSession = $_SESSION['userInSession'];
    $fullname = $_SESSION['fullname'];

    if ($userInSession == NULL) {
        header('location:index.php');
    }

  include 'config/db_connect.php';  

  //write query for all tb_contacts
  $sql = $conn->query("SELECT * FROM tb_contacts WHERE account_id = $userInSession");
        
  //fetch the resulting rows as an array.
  $tb_contacts = $sql->fetch_all();

  $firstname = $lastname = $telephone = $email ='';

  $errors = array('firstname' => '', 'lastname' => '' ,'telephone'=> '', 'email' => '','status' =>'');
     
  if(isset($_POST['save_contact'])){
     
    //checking firstname..
    if(empty($_POST['firstname'])){
        $errors['firstname'] = "firstname is required <br/>";
    } else {
        $firstname= $_POST['firstname'];
        if(!preg_match('/^[a-zA-Z\s]+$/' , $firstname)) {
            $errors['firstname'] = " firstname must be letters and spaces only <br/> ";
        }
      }

    //checking lastname.
    if(empty($_POST['lastname'])){
        $errors['lastname'] = "lastname is required <br/>";
    } else {
        $lastname= $_POST['lastname'];
        if(!preg_match('/^[a-zA-Z\s]+$/' , $lastname)) {
            $errors['lastname'] = " lastname must be letters and spaces only <br/> ";
        }
      }

    // checking for telephone...
    if(empty($_POST['telephone'])){
        $errors['telephone'] = "input your telephone no <br/>";
    } else {
            $telephone = $_POST['telephone'];
        }

    // checking for emails...
    if(empty($_POST['email'])){
        $errors['email'] = "email is required <br/>";
    } else {
          $email = $_POST['email'];
          if(!filter_var($email , FILTER_VALIDATE_EMAIL)) {
          $errors['email'] = "invalid email <br/>";
          }
      }
    // // getting the email from the database
    // $checkAccount = $conn->query("SELECT * FROM tb_contacts WHERE telephone='$telephone' ");
      
    // //fetch the resulting rows as an array.
    // $row_account = $checkAccount->fetch_assoc();
    
    if(array_filter($errors)) {
      $errors['status'] =  "ERROR 505!! <br/>"; 
    } else {
        
        $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
        $lastname=  mysqli_real_escape_string($conn, $_POST['lastname']);
        $telephone = mysqli_real_escape_string($conn, $_POST['telephone']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
                    
        // create sql:
        $insert_account = "INSERT INTO tb_contacts (firstname, lastname, telephone, email,account_id) VALUES ('$firstname', '$lastname', '$telephone', '$email','$userInSession')";

        if($conn->query($insert_account) === TRUE) {   
          header('location:dashboard.php');       
        } else { 
          //  error 
          echo 'query error'.mysqli_error($conn);                           
          }

      }

  }
        
             
        
?>


<!DOCTYPE html>
<html lang="en">
  <?php include "header.php"; ?> 
    
    <div class="bg-faded">
        <!-- sidebar whether fixed,auto or responsive buh i will prefer a toggleable one -->
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="#">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">contacts</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">my profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">logout</a>
          </li>
        </ul>
        <div class="container">
            <div class="row">                          
              <div class="col-md-6 mt-5 ">
                <div class="card  round m-5 w-50">
                  <img class=" img-fluid rounded d-block mx-auto mt-0" style="width: 55px;" src="img/phonebooklogo.png" alt="no thumbnails">
                    <div class="card-body  ">
                       <div class = "card-title  text-center text-primary font-weight-bold text-capitalize">no of contacts saved..</div>     
                       <h3 class = " card-text text-center text-muted font-weight-bold"> <?php echo sizeof($tb_contacts);?></h3> 
                    </div>
                        
                    <div class="text-center m-4 p-2">                                    
                        <a class = "text-warning btn btn-primary" href="view_contact.php">view contact</a>
                    </div>
                </div>
              </div>
    
              <div class="col-md-6 ">
                <form class = "small text-muted round m-5 p-3 font-weight-bold" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                    
                    <img class=" img-fluid rounded d-block mx-auto mt-0" style="width: 55px;" src="img/phonebooklogo.png" alt="no thumbnails">
                    <h4 class = " display-5 text-center lead text-danger font-weight-bold text-capitalize">add new contact..</h4>  
                    <small class ="text-danger font-weight-bold"><?php echo $errors['status']; ?></small>
                    <div class="form-row form-group form-text mt-5">

                        <div class="col-md-6">

                            <label class="">Firstname:</label>
                            <input type="text" class="form-control" id ="firstname" name ="firstname" placeholder="First name" value="<?php echo htmlspecialchars($_POST['firstname']); ?>">
                            <div class="text-danger"><small><?php echo $errors['firstname']; ?></small></div>

                        </div>

                        <div class="col-md-6">

                            <label class="">lastname:</label>
                            <input type="text" class="form-control" id = "lastname" name = "lastname" placeholder ="Last name" value="<?php echo htmlspecialchars($_POST['lastname']); ?>">
                            <div class="text-danger"><small><?php echo $errors['lastname']; ?></small></div>

                        </div>

                    </div>
                                                
                    <div class="form-row form-group form-text">

                        <div class="col-md-6">
                            <label class="">Telephone no:</label>
                            <input type="text" class="form-control" id ="telephone" name ="telephone" placeholder ="Telephone" value="<?php echo htmlspecialchars($_POST['telephone']); ?>">
                            <div class="text-danger"><small><?php echo $errors['telephone']; ?></small></div>
                        </div>

                        <div class="col-md-6">
                            <label class="">Email:</label>
                            <input type="text" class="form-control" id ="email" name ="email" placeholder ="Email"value="<?php echo htmlspecialchars($_POST['email']); ?>">
                            <div class="text-danger"><small><?php echo $errors['email']; ?></small></div>
                            <small id="emailHelp" class="form-text font-weight-bold text-muted">We'll never share your email with anyone else.</small>
                        </div>
                    </div>
                            
                    <!-- for the save contact button -->
                    <div class="text-center m-4 p-2">
                        <input class="btn btn-primary text-warning" type="submit" name="save_contact" value="save contact">
                    </div>

                </form>     
              </div>
            </div>
        </div>            
    </div>
  <?php include "footer.php"; ?> 
</html>