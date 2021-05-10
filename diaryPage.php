<?php
session_start();
$diaryContent = "";
if (array_key_exists("id", $_COOKIE)) {
    $_SESSION['id'] = $_COOKIE['id'];
}

if (array_key_exists("id", $_SESSION)) {
    include("databaseConnecting.php");
    $num=mysqli_insert_id($link)+1;
    $query = "SELECT * FROM `users` WHERE `id`='" . mysqli_real_escape_string($link,$num) . "' LIMIT 1";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_array($result);

    $diaryContent = $row['diary'];
    echo '<div class="container-fluid">
                <nav class="navbar navbar-fixed-top navbar-expand-sm navbar-dark bg-primary">
                <p class="navbar-brand" href="#">A Page By <strong><span style="color:black;">' . mysqli_real_escape_string($link, $row['email']) . '</span></strong></p>
                <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                    aria-expanded="false" aria-label="Toggle navigation"></button>
                <div class="collapse navbar-collapse" id="collapsibleNavId">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    </ul>
                    <div class="inline my-2 my-lg-0">
                    <a href="index.php?logout=1"><button class="btn btn-success my-2 my-sm-0">Logout</button></a>
                    </div>
                </div>
             </nav>
             </div>';
} else {
    header("Location:index.php");
}
?>

<?php include("Header.php"); ?>
<title>Write Your Mind</title>
<style type="text/css">
    #diary {
        width: 100%;
        height: 87%;
        opacity: 0.5;
        resize: none;
    }
</style>
</head>

<body>
    <div class="container-fluid">
        <textarea name="diary" id="diary"><?php echo $diaryContent; ?></textarea>
    </div>


    <script type="text/javascript">
        $('#diary').bind('input propertychange', function() {
            $.ajax({
                method: "POST",
                url: "updateDatabase.php",
                data: {
                    content: $("#diary").val()
                }
            }).fail(function() {
                alert("NO data reached .");
            });
        });
    </script>
    <?php include("Footer.php"); ?>