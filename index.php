<?php
  $error="";

  // If submit  ( Either Loggin or Sign Up is pressed )
  if(array_key_exists("submit",$_POST)){

    // Error Handling 
    if($_POST['email']==""){
      $error.="<p>Email required.</p>";
    }
    if($_POST['password']==""){
      $error.="<p>Password required.</p>";
    }

    // Connecting Database 
    include("databaseConnecting.php");     
        
    if(!$error==""){
      // Error Reporting
      $error="<div class='alert alert-danger' role='alert'><p style='font-weight:800;'>Your Form has the Following Mistakes :</p>".$error."</div>";
    }else{
      // No Errors. Flow of Control
      if($_POST['signUp']=="1"){
        // Sign Up Process : 

        // Checking if Email already Exists
        $query="SELECT `id` FROM `users` WHERE `email`='".mysqli_real_escape_string($link,$_POST['email'])."' LIMIT 1";
        if($result=mysqli_query($link,$query))
        if(mysqli_num_rows($result)>0){
            // IF Exists 
            $error.="<p class='alert alert-warning' role='alert'>Your Email Id is already present in the Database</p>";
        }else{

            print_r($_POST);
            // IF not Exists, Control Flow.. Add email password to the Database
            $signInQuery="INSERT INTO `users` (`email`,`password`) VALUES ('".mysqli_real_escape_string($link,$_POST['email'])."','".mysqli_real_escape_string($link,$_POST['password'])."')";
            // $query="INSERT into `users`(`email`,`password`) VALUES ('".$_POST['email']."','".$_POST['password']."')";
            $signInResult=mysqli_query($link,$signInQuery);
            if(!$signInResult){
                // Some error in running INSERT Operation
                $error.="<div class='alert alert-danger' role='alert'>Could not Sign You Up ! Please Try again later. It's not you, it's us ..</div>";
            }else{
                // Control Flow 

                // Password Encryption
                $encrypt=md5(md5(mysqli_insert_id($link)).$_POST['password']);
                $id=mysqli_insert_id($link);
                $encryptQuery="UPDATE `users` SET `password`='".$encrypt."' WHERE `id`='".$id."'";
                if($encryptResult=mysqli_query($link,$encryptQuery)){
                $_SESSION['id']=$id;

                // Once Logged In , Set Cookie --> Here for 1 year 
        //         if($_POST['loggedIn']=='1'){
        //           setcookie('id','$id',time()+(60*60*24*365));
        //         }

        //         // head over to Diary Page 
        //         header("Location:diaryPage.php");
                   echo "<div class='alert alert-success' role='alert'>Successfully Signed Up !!</div>";
                }
            }
          }
        
      }
      // else{
      //   // Sign in Process : 
      //   $query="SELECT * FROM `users` WHERE `email`='".mysqli_real_escape_string($link,$_POST['email'])."'";
      //   $result=mysqli_query($link,$query);
      //   $row=mysqli_fetch_array($result);
      //   if(isset($row)){
      //     $hashedPassword=md5(md5($row['id']).$_POST['password']);
      //     if($hashedPassword==$row['password']){
      //       $_SESSION['id']=$row['id'];
      //       if($_POST['loggedIn']=='1'){
      //         setcookie('id',$row['id'],time()+(60*60*24*365));
      //       }
      //       header("Location:diaryPage.php");
      //     }else{
      //       $error="<div class='alert alert-danger' role='alert'>Your password did not match !!</div>";
      //     }
      //   }else{
      //     $error="<div class='alert alert-danger' role='alert'>Email Couldn't be found !!</div>";
      //   }
      // } 
    }
  }
?>

<?php include("Header.php"); ?>

  <style type="text/css">
    .form-text{
      color:white;
      font-size:105%;
    }
    .container{
      text-align:center;
      width:450px;
      margin-top:120px;
    }
    #loggingIn{
      display:none;
    }
  </style>
   <title>Secret Diary</title>
</head>

<body>
<!-- Main DIV Code  -->
  <div class="container">

    <h1>Secret Diary</h1>
    <p><strong>Share Your Deep Thoughts Securely ...</strong></p>
    
    <!-- Div to Report Errors From Form Submission -->
    <div id="error"><?php echo $error; ?></div>

    <!-- Sign Up Form Starts Here -->
    <form method="post" id="signingUp">
        
        <p>Interested ? Sign Up Now !!</p>
        
        <div class="form-group">
          <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelpId" placeholder="Enter Your Email">
          <small id="emailHelpId" class="form-text">We will not share your email with any third Party.</small>
        </div>
        
        <div class="form-group">
          <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password">
        </div>
        
        <div class="form-check">
          <label class="form-check-label">
            <input type="checkbox" class="form-check-input" name="loggedIn" id="loggedIn" value="1" checked>
            Keep Me Logged In
          </label>
        </div>
        
        <div class="form-group"> 
          <input type="hidden" name="signUp" value="1">
          <button type="submit" name="submit" class="btn btn-primary" style="margin-top:8px; margin-right:8px;">Sign Up</button>
        </div>

      </form>

      <p id="alreadyLogged">Already A User ? Log In !</p>

      <button title="Already A User ?" class="btn btn-info" id="logInChoice">Log In</button>

    <!-- Sign In Form Starts Here -->

      <form method="post" id="loggingIn">
      
        <p>Log In Using Your User Email and Password </p>

        <div class="form-group">
          <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelpId" placeholder="Enter Your Email">
          <small id="emailHelpId" class="form-text">We do not share your email with any third Party.</small>
        </div>
      
        <div class="form-group">
          <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password">
        </div>
        
        <div class="form-check">
          <label class="form-check-label">
            <input type="checkbox" class="form-check-input" name="loggedIn" id="loggedIn" value="1" checked>
            Keep Me Logged In
          </label>
        </div>
        
        <input type="hidden" name="signUp" value="0">
        <button type="submit" name="submit" class="btn btn-success" style="margin-top:8px;">Log In</button>
    
    </form>
    <p id="newUser">New User ? Sign Up Now ..</p>
    <button title="New User ?" class="btn btn-info" id="signUpChoice" style="margin-top:8px;">Sign Up</button>
  </div>

  <script type="text/javascript">
    
    $("#signUpChoice").hide();
    $("#newUser").hide();  

    $("#logInChoice").click(function(){
      $("#signingUp").toggle(); 
      $("#logInChoice").toggle();
      $("#signUpChoice").toggle();
      $("#loggingIn").toggle();  
      $("#alreadyLogged").toggle();
      $("#newUser").toggle();  
    });

    $("#signUpChoice").click(function(){
      $("#signingUp").toggle(); 
      $("#logInChoice").toggle();
      $("#signUpChoice").toggle();
      $("#alreadyLogged").toggle();  
      $("#newUser").toggle();  
      $("#loggingIn").toggle();    
    });

  </script>

 <?php include("Footer.php"); ?>
