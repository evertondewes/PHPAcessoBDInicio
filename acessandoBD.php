<?php


$pdo = new PDO("mysql:host=localhost:3306;dbname=biblioteca;charset=latin1",
                'root', '');


$consulta = $pdo->query('SELECT * FROM livro');

$livrosArray = $consulta->fetchAll(PDO::FETCH_ASSOC);

echo 'id' . ': ' . 'ano' . ' - ' . 'nome' . '<br>';

foreach ($livrosArray as $livro) {
    echo $livro['id'] . ': ' . $livro['ano'] . ' - ' . $livro['nome'] . '<br>';
}

