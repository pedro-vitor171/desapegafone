<?php
 $host = 'localhost';
 $user = 'root';
 $password = '';
 $dbname = 'primer';

 try{
    $pdo = new PDO("mysql:host=$host;dbname=$dbname",$user,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    echo $e->getMessage();
}
