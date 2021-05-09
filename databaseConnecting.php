<?php 
    # Development Database Info
        // $host="localhost";
        // $userName="amar";
        // $password="webadvisor@0401";
        // $dbName="secret_diary";

    # Production Database Info 
        $host="remotemysql.com";
        $userName="otHXxPN3zw";
        $password="Zky8vdvuB0";
        $dbName="otHXxPN3zw";

        $link=mysqli_connect($host,$userName,$password,$dbName);        
        if(mysqli_connect_error()){
           die("Database Not Connected."); 
        }
?>