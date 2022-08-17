<?php 
  require_once('config/db_connect.php');  

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
     
        //make sql
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

 <?php include('header.php');?>
 <?php include('sidebar.php');?>

   <div class="back-overlay">
    <div class="container">
     <div class="row">
       <div class="col-12 mt-5">
         <div class="card">
           <div class="card-body">
            
               <div class="text-center rounded w-75 mt-5 p-5">
                <div style="overflow-x:auto;">
                  <div class=" datatable-primary">
                   <table class ="table table-striped table-bordered table-hover datatable m-5"  id="dataTable2">
                      <thead class="thead-dark text-capitalize">
                        <tr class ="text-muted text-center font-weight-bold p-5 m-5">
                           <h3 class=" text-muted lead font-weight-bold text-center">My contacts</h3>
                           <img class=" img-fluid rounded d-block mx-auto mt-0" style="width: 55px;" src="img/phonebooklogo.png" alt="no thumbnails">
                        
                           <th>Firstname</th>
                           <th>lastname</th>
                           <th>Telephone</th>
                           <th>Email</th>
                           <th colspan="2">Action</th>
                        </tr>
                      </thead>
                     
                     <?php foreach($tb_contacts as $tb_contact) {?>
                      <tbody>
                        <tr class ="font-weight-bold">
                           <td><?php echo $tb_contact['firstname'];?></td>
                           <td><?php echo $tb_contact['lastname'];?></td>
                           <td><?php echo $tb_contact['telephone'];?></td>
                           <td><?php echo $tb_contact['email'];?></td>
                           <td>
                              <a href="editContact.php?edit=<?php echo $tb_contact['id']; ?>" class="btn btn-sm btn-primary text-warning">Edit</a>
                           </td>
                           <td>
                              <a href="view_contact.php?del=<?php echo $tb_contact['id']; ?>" class="btn btn-sm btn-danger text-white">Delete</a>
                           </td>
                        </tr>
                      </tbody>
                        
                     <?php } ?>
                   </table>
                  </div>
               </div>   
               </div>

           </div>
         </div>
       </div>
     </div>

    </div> 
   </div>
                                                                                                
 <?php include('footer.php'); ?>
</html>  