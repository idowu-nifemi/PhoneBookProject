<?php 
  require_once('config/db_connect.php');  

  //initialize the session
  if(session_status() != PHP_SESSION_ACTIVE);
  session_start();

    //conditional
    $userInSession = $_SESSION['userInSession'];
    $fullname = $_SESSION['fullname'];

    if ($userInSession == NULL) {
        header('location:index.php');
    }

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
      
    if(array_filter($errors)) {
      $errors['status'] =  "ERROR 509!"; 
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
          echo 'query error'.mysqli_error($conn);                           
          }

      }

  }
              
?>

<!DOCTYPE html>
<html lang="en">

    <?php include('header.php');?>
    <?php include('sidebar.php');?>

    <div class="back-overlay">

        <section class="container">
            <div class="row">      

              <div class="col-md-6 mt-5 ">
                <div class="card rounded round2 m-5 w-50">
                  <img class=" img-fluid rounded d-block mx-auto mt-0" style="width: 55px;" src="img/phonebooklogo.png" alt="no thumbnails">
                    <div class="card-body  ">
                       <div class = "card-title text-center text-primary font-weight-bold text-capitalize">no of contacts saved..</div>     
                       <h3 class = "card-text text-center text-muted font-weight-bold"> <?php echo sizeof($tb_contacts);?></h3> 
                    </div>
                        
                    <div class="text-center m-4 p-2">                                    
                        <a class = "btn btn-primary text-warning" href="view_contact.php">view contacts</a>
                    </div>
                </div>
              </div>
    
              <div class="col-md-6 ">
                <form class = "round rounded small text-muted font-weight-bold m-5 p-3" method="POST">
                    
                    <img class= "img-fluid rounded d-block mx-auto mt-0" style="width: 55px;" src="img/phonebooklogo.png" alt="no thumbnails">
                    <h4 class = "text-center lead text-danger font-weight-bold text-capitalize">add new contact..</h4>  

                    <div class= "form-row form-group form-text mt-5">
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
                            <input type="text" class="form-control" id ="email" name ="email" placeholder ="email"value="<?php echo htmlspecialchars($_POST['email']); ?>">
                            <div class="text-danger"><small><?php echo $errors['email']; ?></small></div>
                            <small id="emailHelp" class="form-text font-weight-bold font-italic text-muted">We'll never share your email with anyone else.</small>
                        </div>
                    </div>
                            
                    <!-- for the save contact button -->
                    <div class="text-center m-4 p-2">
                        <input class="btn btn-danger text-white" type="submit" name="save_contact" value="save contact">
                    </div>

                </form>     
              </div>
            </div>
        </section>            
    </div>

    <?php include('footer.php'); ?>
    <script>
     alert("<?php echo $errors['status']; ?>");
    </script>
</html>