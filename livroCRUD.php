<html>
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
} else {
    if(is_numeric($atualizarID)){
        $consulta = $pdo->query("SELECT * FROM livro WHERE id = $atualizarID;");
        $livro = $consulta->fetchAll(PDO::FETCH_ASSOC);

        if(is_array($livro) && count($livro)>0) {
            $id = $livro[0]['id'];
            $ano = $livro[0]['ano'];
            $nome = $livro[0]['nome'];
            ?>
            <form method="post">
                ID: <?php echo $id; ?><br>
                <input type="hidden" value="<?php echo $id; ?>" name="id">
                Nome do Livro:<input type="text" value="<?php echo $nome; ?>" name="nomeLivro"/><br>
                Ano:<input type="number" value="<?php echo $ano; ?>" name="ano"/><br>
                <input type="submit" name="action" value="Atualizar"/><br>
            </form>
            <?php
        }
    }
}



if($action == 'Atualizar' || $action == 'Cadastrar') {
    ?>

    <form method="post">
        Nome do Livro:<input type="text" name="nomeLivro"/><br>
        Ano:<input type="number" name="ano"/><br>
        <input type="submit" name="action" value="Cadastrar"/>
        <input type="reset" value="Limpar"><br>
    </form>
    <?php
}

if ($action == 'Cadastrar') {

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
    echo '<a href="livroCRUD.php?DeletarID='
        . $livro['id'] . '">Deletar</a> '
        . '<a href="livroCRUD.php?AtualizarID='
        . $livro['id'] . '">Atualizar</a> '
        . $livro['id'] . ': '
        . $livro['ano'] . ' - '
        . $livro['nome'] . '<br>' . PHP_EOL;
}

?>
</body>
</html>
