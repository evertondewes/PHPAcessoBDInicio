<?php

$pdo = new PDO("mysql:host=localhost:3306;
                    dbname=biblioteca;charset=latin1",
    'root', '');


$comandoSQL = "delete from livro where ano = 2019;";

echo 'comandoSQL:' . $comandoSQL . '<br>';

$totalPagados = $pdo->exec($comandoSQL);

echo 'totalPagados:' . $totalPagados . '<br>';
?>
