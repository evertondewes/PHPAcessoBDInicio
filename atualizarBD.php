<?php

$pdo = new PDO("mysql:host=localhost:3306;
                    dbname=biblioteca;charset=latin1",
    'root', '');


$comandoSQL = "update livro set ano = 2019 where ano <> 2019;";

echo 'comandoSQL:' . $comandoSQL . '<br>';

$total = $pdo->exec($comandoSQL);

echo 'total:' . $total . '<br>';
?>
