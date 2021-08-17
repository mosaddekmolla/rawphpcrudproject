<?php
    // $servername = "localhost";
    //     $username = "root";
    //     $password = "";

    //     $pdo = new PDO("mysql:host=$servername;port=3306;dbname=products_crud", $username,$password );
    //     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            $pdo = new PDO('mysql:host=127.0.0.1;dbname=products_crud', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // return $pdo;
?>