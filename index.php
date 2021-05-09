<?php
  
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
