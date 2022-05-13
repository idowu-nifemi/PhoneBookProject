    <?php

    // connect to database
    $conn = new mysqli('localhost','root','','contact_list');

    //checking the conection..
    if(!$conn){
       echo 'connection error '.mysqli_connect_error();
    }
   
    ?>