<?php 
    # Development Database Info
        // $host="localhost";
        // $userName="amar";
        // $password="webadvisor@0401";
        // $dbName="secret_diary";

    # Remote Database Info 1
        // $host="remotemysql.com";
        // $userName="otHXxPN3zw";
        // $password="Zky8vdvuB0";
        // $dbName="otHXxPN3zw";

    # Remote Database Info 1
        $host="db4free.net";
        $userName="attaboy_dev";
        $password="attaboydev";
        $dbName="secret_diary";

        $link=mysqli_connect($host,$userName,$password,$dbName);        
        if(mysqli_connect_error()){
           die("Database Not Connected."); 
        }
?>