<?php
 $host = 'ceteia.guanambi.ifbaiano.edu.br:3306';
 $user = 'primephone';
 $password = 'primephone';
 $dbname = 'primephone';

 try{
    $pdo = new PDO("mysql:host=$host;dbname=$dbname",$user,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    echo $e->getMessage();
}
