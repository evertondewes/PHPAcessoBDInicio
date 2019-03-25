<?php

$pdo = new PDO("mysql:host=localhost:3306;
                    dbname=biblioteca;charset=latin1",
    'root', '');

$deletarID = filter_input(INPUT_GET, 'DeletarID', FILTER_VALIDATE_INT);

if (is_numeric($deletarID)) {


    $comandoSQL = "delete from livro where id = $deletarID;";

    echo 'comandoSQL:' . $comandoSQL . '<br>';

    $totalPagados = $pdo->exec($comandoSQL);

    echo 'totalPagados:' . $totalPagados . '<br>';
}

?>
