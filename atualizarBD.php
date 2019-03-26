<?php

$pdo = new PDO("mysql:host=localhost:3306;
                    dbname=biblioteca;charset=latin1",
    'root', '');

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
$atualizarID = filter_input(INPUT_GET, 'AtualizarID', FILTER_VALIDATE_INT);

if ($action == 'Atualizar') {

    $nomeLivro = filter_input(INPUT_POST, 'nomeLivro', FILTER_SANITIZE_STRING);
    $ano = filter_input(INPUT_POST, 'ano', FILTER_VALIDATE_INT);

    $comandoAtualizar = "UPDATE livro SET nome = '$nomeLivro', ano = $ano
                         WHERE id = $atualizarID;";

    $pdo->exec($comandoAtualizar);

}



$consulta = $pdo->query("SELECT * FROM livro WHERE id = $atualizarID;");


$livro = $consulta->fetchAll(PDO::FETCH_ASSOC);

echo '<pre>' . print_r($livro, true) . '</pre><br>';

$id = $livro[0]['id'];
$ano = $livro[0]['ano'];
$nome = $livro[0]['nome'];

?>

<html>
<body>
<form method="post">
    ID: <?php echo $id; ?><br>
    <input type="hidden" value="<?php echo $id; ?>" name="id">
    Nome do Livro:<input type="text" value="<?php echo $nome; ?>" name="nomeLivro"/><br>
    Ano:<input type="number" value="<?php echo $ano; ?>" name="ano"/><br>
    <input type="submit" name="action" value="Atualizar"/><br>
</form>
</body>
</html>

