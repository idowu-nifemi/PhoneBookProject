<?php 
   include 'config/db_connect.php';  
   //initialize the session
   if(session_status() != PHP_SESSION_ACTIVE);
   session_start();

   //conditional session destroy
   $userInSession = $_SESSION['userInSession'];
   $fullname = $_SESSION['fullname'];

   if ($userInSession == NULL) {
      header('location:index.php');  
   }

   if($_REQUEST['del'] != ""){

      $id_to_delete = mysqli_real_escape_string($conn,$_REQUEST['del']);
     
        // make sql
        $deleteId = "DELETE FROM tb_contacts WHERE id=$id_to_delete";
     
        if($conn->query($deleteId) === TRUE) { 

          header('location:view_contact.php?success=1');  
       }else {
          header('location:view_contact.php?success=0');  

          echo 'query error'.mysqli_error($conn);
        } 
   }



   //write query for all tb_contacts..
   $tb_contacts = $conn->query("SELECT * FROM tb_contacts WHERE account_id = $userInSession");
?>
<!-- i will be adding the search form for the contacts -->
<!DOCTYPE html>
   <html lang="en">
      <?php include "header.php"; ?> 

    <div class="container">
      <div class="text-center border square rounded w-75 p-5 m-5">
      <div style="overflow-x:auto;">
         <div class="table">
            <table class ="table table-striped table-bordered table-hover  m-5 p-5" id="lol" >
                  <thead class="thead-dark">
                     <tr class ="text-muted font-weight-bold p-5 m-5">
                        <h3 class=" text-primary text-center text-capitalize">My contacts.</h3>
                        <img class=" img-fluid rounded d-block mx-auto mt-0" style="width: 55px;" src="img/phonebooklogo.png" alt="no thumbnails">
                        <th>Firstname</th>
                        <th>lastname</th>
                        <th>Telephone</th>
                        <th>Email</th>
                        <th colspan="2">Action</th>
                     </tr>
                  </thead>
                  
                  <?php foreach($tb_contacts as $tb_contact) {?>
                  <tr class ="">
                     <td><?php echo $tb_contact['firstname']; ?></td>
                     <td><?php echo $tb_contact['lastname']; ?></td>
                     <td><?php echo $tb_contact['telephone']; ?></td>
                     <td><?php echo $tb_contact['email']; ?></td>
                     <td>
                        <a href="editContact.php?edit=<?php echo $tb_contact['id']; ?>" class="btn btn-sm btn-primary text-warning">Edit</a>
                     </td>
                     <td>
                        <a href="view_contact.php?del=<?php echo $tb_contact['id']; ?>" class="btn btn-sm btn-danger text-white">Delete</a>
                     </td>
                  </tr>
                  <?php } ?>
               </table>
         </div>
            
         <!-- <form class="form-inline justify-content-center" action="view_contact.php">
               <input class="form-control mr-sm-2" type="text" placeholder="Search">
               <button class="btn btn-success" type="submit">Search</button>
         </form> -->
      </div>   
      </div>
    </div>      
      <?php include "footer.php"; ?> 
     
   </html>  