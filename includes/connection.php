<?php

try {
    $pdo = new PDO('mysql:host=aa7v6mo2fs8t19.cv7unwp2ljkv.us-east-1.rds.amazonaws.com;dbname=project3', 'updownlife', 'CIS525termproject***');
} catch(PDOException $err) {
    var_dump($err->getMessage());
    var_dump($dbh->errorInfo());
    die('....');
}

?>
