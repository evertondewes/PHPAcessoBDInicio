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

    $insertTipo1 = 'INSERT INTO livro(nome, ano)
                    VALUES(\''. $nomeLivro. '\',' .$ano .');';

    echo 'insertTipo1:' . $insertTipo1 .'<br>';

    $insertTipo2 = "INSERT INTO livro(nome, ano)
                    VALUES('". $nomeLivro. "'," .$ano .");";

    echo 'insertTipo2:' . $insertTipo2 .'<br>';


    $insertTipo3 = "INSERT INTO livro(nome, ano)
                    VALUES('$nomeLivro',$ano);";

    echo 'insertTipo3:' . $insertTipo3 .'<br>';

    $pdo->exec($insertTipo3);

}

$consulta = $pdo->query('SELECT * FROM livro');

$livrosArray = $consulta->fetchAll(PDO::FETCH_ASSOC);

echo 'id' . ': ' . 'ano' . ' - ' . 'nome' . '<br>';

foreach ($livrosArray as $livro) {
    echo $livro['id'] . ': ' . $livro['ano'] . ' - ' . $livro['nome'] . '<br>';
}

?>
</body>
</html>
