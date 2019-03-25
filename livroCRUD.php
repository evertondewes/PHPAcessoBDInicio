<html>
<form method="post">
    Nome do Livro:<input type="text" name="nomeLivro"/><br>
    Ano:<input type="number" name="ano"/><br>
    <input type="submit" name="action" value="Cadastrar"/><br>
</form>
<?php

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

$pdo = new PDO("mysql:host=localhost:3306;
                    dbname=biblioteca;charset=latin1",
    'root', '');


if($action == 'Cadastrar') {

    $nomeLivro = filter_input(INPUT_POST, 'nomeLivro', FILTER_SANITIZE_STRING);
    $ano = filter_input(INPUT_POST, 'ano', FILTER_VALIDATE_INT);

    $insertTipo3 = "INSERT INTO livro(nome, ano)
                    VALUES('$nomeLivro',$ano);";

    $pdo->exec($insertTipo3);

}

$deletarID = filter_input(INPUT_GET, 'DeletarID', FILTER_VALIDATE_INT);

if (is_numeric($deletarID)) {

    $comandoSQL = "delete from livro where id = $deletarID;";

    $totalPagados = $pdo->exec($comandoSQL);

    echo 'totalPagados:' . $totalPagados . '<br>';
}

$consulta = $pdo->query('SELECT * FROM livro');

$livrosArray = $consulta->fetchAll(PDO::FETCH_ASSOC);

echo 'id' . ': ' . 'ano' . ' - ' . 'nome' . '<br>';

foreach ($livrosArray as $livro) {
    echo '<a href="livroCRUD.php?DeletarID='.$livro['id'].'">Deletar</a> '
        . $livro['id'] . ': ' . $livro['ano'] . ' - '
        . $livro['nome'] . '<br>' . PHP_EOL;
}

?>
</body>
</html>
