<?php




?>

<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
      <title>nothing yet!!</title>
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> -->
      <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
      <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
      <link rel="stylesheet" type="text/css" href="css/bootstrap-grid.css">
      <link rel="stylesheet" type="text/css" href="css/syntax.css">
      <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body class="">
  <nav class="navbar navbar-expand-lg navbar-toggleable-sm bg-danger navbar-dark">

      <div class="container">
           
            <div class="navbar-brand">
                  <img class="img-fluid rounded float-left" style="width: 95px;" src="img/phonebooklogo.png" alt="no thumbnails">
                  <div class="float-left text-white font-weight-bold">
                      <h2>PcBOOK</h2>
                  </div>  
            </div>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#mainNav">
                  <span class="navbar-toggle-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="mainNav">
               <div class="navbar-nav small font-weight-bold">

                  <?php if ($userInSession == NULL) { ?>
                    <li class="nav-item ">
                       <a href="index.php" class="nav-link active">Home<i class="fas fa-home"></i></a>
                    </li>
                  <?php } else {?>
                    <li class="nav-item ">
                       <a href="dashboard.php" class="nav-link active">Dashboard<i class="fas fa-envelope"></i></a>
                    </li>
                  <?php } ?>
                        
                    <li class="nav-item">
                      <a href="#" class="nav-link active">Services<i class="fas fa-bars"></i></a>
                    </li>
                          
                    <li class="nav-item ">
                      <a href="#about" class="nav-link active">About<i class="fas fa-question"></i></a>
                    </li>

                    <li class="nav-item ">
                      <a href="#" class="nav-link active ">Terms<i class="fas fa-book"></i></a>
                    </li>
                  <?php if ($userInSession == NULL) { ?>
                    <li class="nav-item">
                      <a href="index.php" class="nav-link active">Sign in<i class=""></i></a>
                    </li>

                    <li class="nav-item">
                      <a href="signup.php" class="nav-link active only-mobile">Sign up<i class="fas fa-pen"></i></a>
                    </li>
                  <?php } else {?>
                    <li class="nav-item">
                      <a href="signout.php" class="nav-link active"><?php echo ucwords($fullname)?><i class="fas fa-user"></i> | Sign Out<i class="fas fa-trash"></i></a>
                    </li>
                  <?php } ?>

               </div>
            </div>
      </div>
            
  </nav>
   

    
