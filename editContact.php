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

  $contactId = $_REQUEST['edit'];

  //write query for all tb_contacts to get the values of the id im editing
  $sql = $conn->query("SELECT * FROM tb_contacts WHERE id = $contactId");
      
  //fetch the resulting rows as an array.
  $tb_contacts = $sql->fetch_assoc();

 
 
if(isset($_POST['update'])){

  $firstname = $lastname = $telephone = $email ='';
  
  $errors = array('firstname' => '', 'lastname' => '' ,'telephone'=> '', 'email' => '','status' =>'');
  
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
       $errors['status'] =  "ERROR 505!! <br/>"; 
    
     } else {
         
       $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
       $lastname=  mysqli_real_escape_string($conn, $_POST['lastname']);
       $telephone = mysqli_real_escape_string($conn, $_POST['telephone']);
       $email = mysqli_real_escape_string($conn, $_POST['email']);
  
       //create sql:
       $editContact = ("UPDATE tb_contacts SET firstname = '$firstname', lastname='$lastname', email='$email',  telephone ='$telephone' WHERE id='$contactId'");
  
       if($conn->query($editContact) === TRUE){
         //sucess
         header('location:editContact.php?edit='.$contactId. '&success=1');  
       }else {
        header('location:editContact.php?edit='.$contactId. '&success=0');  

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
        <!-- sidebar whether fixed,auto or responsive buh i will prefer a toggleable one -->
        <div class="container">
            <div class="row">  
              <div class="col-md-3"></div>                        
                  
              <div class="col-md-6 ">
                <form class = "small text-muted round m-5 p-3 font-weight-bold" method="POST">
                    
                    <img class=" img-fluid rounded d-block mx-auto mt-0" style="width: 55px;" src="img/phonebooklogo.png" alt="no thumbnails">
                    <h4 class = " display-5 text-center lead text-danger font-weight-bold text-capitalize">Edit contact..</h4>  
                    <small class ="text-danger font-weight-bold"><?php echo $errors['status']; ?></small>

                    <div class="form-row form-group form-text mt-5">
                        <div class="col-md-6">
                            <label class="">Firstname:</label>
                            <input type="text" class="form-control" id ="firstname" name ="firstname" placeholder="First name" value="<?php echo htmlspecialchars($tb_contacts['firstname']); ?>">
                            <div class="text-danger"><small><?php echo $errors['firstname']; ?></small></div>
                        </div>

                        <div class="col-md-6">
                            <label class="">lastname:</label>
                            <input type="text" class="form-control" id = "lastname" name = "lastname" placeholder ="Last name" value="<?php echo htmlspecialchars($tb_contacts['lastname']); ?>">
                            <div class="text-danger"><small><?php echo $errors['lastname']; ?></small></div>
                        </div>
                    </div>
                                                
                    <div class="form-row form-group form-text">
                        <div class="col-md-6">
                            <label class="">Telephone no:</label>
                            <input type="text" class="form-control" id ="telephone" name ="telephone" placeholder ="Telephone" value="<?php echo htmlspecialchars($tb_contacts['telephone']); ?>">
                            <div class="text-danger"><small><?php echo $errors['telephone']; ?></small></div>
                        </div>

                        <div class="col-md-6">
                            <label class="">Email:</label>
                            <input type="text" class="form-control" id ="email" name ="email" placeholder ="Email"value="<?php echo htmlspecialchars($tb_contacts['email']); ?>">
                            <div class="text-danger"><small><?php echo $errors['email']; ?></small></div>
                            <small id="emailHelp" class="form-text font-weight-bold text-muted">We'll never share your email with anyone else.</small>
                        </div>
                    </div>
                            
                    <!-- for the save contact button -->
                    <input type="hidden" name="contactId" value="<?php echo htmlspecialchars($tb_contacts['id']); ?>">
                    <div class="text-center m-4 p-2">
                        <input class="btn btn-primary text-warning" type="submit" name="update" value="update">
                    </div>

                </form>     
              </div>
              <div class="col-md-3"></div> 
            </div>
        </div>            
    </div>
    
    <?php include('footer.php'); ?>
</html>