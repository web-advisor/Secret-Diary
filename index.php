<?php
  session_start();

  # For Maintaining Errors
  $error="";

    if(array_key_exists("logout",$_GET)){
      // if($_GET["logout"]==1){
      unset($_SESSION);
      setcookie("id","",time()-(60*60));
      $_COOKIE['id']="";
    }else if((array_key_exists("id",$_SESSION) AND $_SESSION['id'])OR(array_key_exists("id",$_COOKIE) AND $_COOKIE['id'])){
      header("Location:dairyPage.php");
    }

    if(array_key_exists("submit",$_POST)){

      // Connecting Database 
        include("databaseConnecting.php");     
        
      // Error Handling 
        if($_POST['email']==""){
            $error.="<p>Email required.</p>";
        }
        if($_POST['password']==""){
            $error.="<p>Password required.</p>";
        }

        if(!$error==""){
          // Error Reporting
        $error="<div class='alert alert-danger' role='alert'><p style='font-weight:800;'>Your Form has the Following Mistakes :</p>".$error."</div>";
        }else{
          // No Errors. Flow of Control
          if($_POST['signUp']=="1"){
            // Sign Up Process : 

            // Checking if Email already Exists
            $query="SELECT `id` FROM `users` WHERE `email`='$_POST[email]' LIMIT 1";
            $result=mysqli_query($link,$query);
            if(mysqli_num_rows($result)>0){
                // IF Exists 
                $error.="<p class='alert alert-warning' role='alert'>Your Email Id is already present in the Database</p>";
            }else{
                // IF not Exists
                $query="INSERT into `users`(`email`,`password`) VALUES('".mysqli_real_escape_string($link,$_POST['email'])."','".mysqli_real_escape_string($link,$_POST['password'])."')";
                $result=mysqli_query($link,$query);
                if(!$result){
                    // Some error in running INSERT Operation
                    $error.="Could not Sign You Up ! Please Try again later.";
                }else{
                    // Control Flow 

                    // Password Encryption
                    $encrypt=md5(md5(mysqli_insert_id($link)).$_POST['password']);
                    $id=mysqli_insert_id($link);
                    $query="UPDATE `users` SET `password`='$encrypt' WHERE `id`='$id'";
                    mysqli_query($link,$query);
                    $_SESSION['id']=$id;

                    // Once Logged In , Set Cookie --> Here for 1 year 
                    if($_POST['loggedIn']=='1'){
                      setcookie('id','$id',time()+(60*60*24*365));
                    }

                    // head over to Diary Page 
                    header("Location:diaryPage.php");
                    # echo "<div class='alert alert-success' role='alert'>Successfully Signed Up !!</div>";
                }
            }
          }else{
            // Sign in Process : 
            $query="SELECT * FROM `users` WHERE `email`='".mysqli_real_escape_string($link,$_POST['email'])."'";
            $result=mysqli_query($link,$query);
            $row=mysqli_fetch_array($result);
            if(isset($row)){
              $hashedPassword=md5(md5($row['id']).$_POST['password']);
              if($hashedPassword==$row['password']){
                $_SESSION['id']=$row['id'];
                if($_POST['loggedIn']=='1'){
                  setcookie('id',$row['id'],time()+(60*60*24*365));
                }
                header("Location:diaryPage.php");
              }else{
                $error="<div class='alert alert-danger' role='alert'>Your password did not match !!</div>";
              }
            }else{
              $error="<div class='alert alert-danger' role='alert'>Email Couldn't be found !!</div>";
            }
          } 
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

      <p>Already A User ? Log In !</p>

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
    <button title="New User ?" class="btn btn-info" id="signUpChoice" style="margin-top:8px;">Sign Up</button>

  </div>

  <script type="text/javascript">
    $("#signUpChoice").hide();

    $("#logInChoice").click(function(){
      $("#signingUp").toggle(); 
      $("#logInChoice").toggle();
      $("#signUpChoice").toggle();
      $("#loggingIn").toggle();    
    });

    $("#signUpChoice").click(function(){
      $("#signingUp").toggle(); 
      $("#logInChoice").toggle();
      $("#signUpChoice").toggle();
      $("#loggingIn").toggle();    
    });

  </script>

 <?php include("Footer.php"); ?>
