<?php
$pdo = new PDO("mysql:host=localhost:3306;
                    dbname=biblioteca;charset=latin1",
    'root', '');


$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
$atualizarID = filter_input(INPUT_GET, 'AtualizarID', FILTER_VALIDATE_INT);
$deletarID = filter_input(INPUT_GET, 'DeletarID', FILTER_VALIDATE_INT);


echo '$atualizarID: '.$atualizarID.'<br>';
echo '$deletarID: '.$deletarID.'<br>';
echo '$action: '.$action.'<br>';

// apresentação do form de cadastro e listagem
if(empty($atualizarID) && empty($deletarID) && empty($action)){
    ?>

    <form method="post" action="finalCRUD.php">
        Nome do Livro:<input type="text" name="nomeLivro"/><br>
        Ano:<input type="number" name="ano"/><br>
        <input type="submit" name="action" value="Cadastrar"/>
        <input type="reset" value="Limpar"><br>
    </form>

    <?php

    $consulta = $pdo->query('SELECT * FROM livro');

    $livrosArray = $consulta->fetchAll(PDO::FETCH_ASSOC);

    echo 'id' . ': ' . 'ano' . ' - ' . 'nome' . '<br>';

    foreach ($livrosArray as $livro) {
        echo '<a href="finalCRUD.php?DeletarID='
            . $livro['id'] . '">Deletar</a> '
            . '<a href="finalCRUD.php?AtualizarID='
            . $livro['id'] . '">Atualizar</a> '
            . $livro['id'] . ': '
            . $livro['ano'] . ' - '
            . $livro['nome'] . '<br>' . PHP_EOL;
    }
}

// ação de cadastrar
if(empty($atualizarID) && empty($deletarID) && $action== 'Cadastrar') {
    $nomeLivro = filter_input(INPUT_POST, 'nomeLivro', FILTER_SANITIZE_STRING);
    $ano = filter_input(INPUT_POST, 'ano', FILTER_VALIDATE_INT);

    $insert = "INSERT INTO livro(nome, ano)
                    VALUES('$nomeLivro',$ano);";

    $pdo->exec($insert);
    ?>

    <form method="post" action="finalCRUD.php">
        Nome do Livro:<input type="text" name="nomeLivro"/><br>
        Ano:<input type="number" name="ano"/><br>
        <input type="submit" name="action" value="Cadastrar"/>
        <input type="reset" value="Limpar"><br>
    </form>

    <?php

    $consulta = $pdo->query('SELECT * FROM livro');

    $livrosArray = $consulta->fetchAll(PDO::FETCH_ASSOC);

    echo 'id' . ': ' . 'ano' . ' - ' . 'nome' . '<br>';

    foreach ($livrosArray as $livro) {
        echo '<a href="finalCRUD.php?DeletarID='
            . $livro['id'] . '">Deletar</a> '
            . '<a href="finalCRUD.php?AtualizarID='
            . $livro['id'] . '">Atualizar</a> '
            . $livro['id'] . ': '
            . $livro['ano'] . ' - '
            . $livro['nome'] . '<br>' . PHP_EOL;
    }
}

// ação de apagar
if(empty($atualizarID) && !empty($deletarID) && empty($action)) {
    $comandoSQL = "delete from livro where id = $deletarID;";

    $totalPagados = $pdo->exec($comandoSQL);

    echo 'totalPagados:' . $totalPagados . '<br>';

    ?>

    <form method="post" action="finalCRUD.php">
        Nome do Livro:<input type="text" name="nomeLivro"/><br>
        Ano:<input type="number" name="ano"/><br>
        <input type="submit" name="action" value="Cadastrar"/>
        <input type="reset" value="Limpar"><br>
    </form>

    <?php

    $consulta = $pdo->query('SELECT * FROM livro');

    $livrosArray = $consulta->fetchAll(PDO::FETCH_ASSOC);

    echo 'id' . ': ' . 'ano' . ' - ' . 'nome' . '<br>';

    foreach ($livrosArray as $livro) {
        echo '<a href="finalCRUD.php?DeletarID='
            . $livro['id'] . '">Deletar</a> '
            . '<a href="finalCRUD.php?AtualizarID='
            . $livro['id'] . '">Atualizar</a> '
            . $livro['id'] . ': '
            . $livro['ano'] . ' - '
            . $livro['nome'] . '<br>' . PHP_EOL;
    }
}

// ação para abrir o formulário de edição
if(!empty($atualizarID) && empty($deletarID) && empty($action)) {
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
            <input type="submit" name="action" value="Atualizar"/>
            <a href="finalCRUD.php">Cancelar</a>
            <br>
        </form>
        <?php
    }

    $consulta = $pdo->query('SELECT * FROM livro');

    $livrosArray = $consulta->fetchAll(PDO::FETCH_ASSOC);

    echo 'id' . ': ' . 'ano' . ' - ' . 'nome' . '<br>';

    foreach ($livrosArray as $livro) {
        echo '<a href="finalCRUD.php?DeletarID='
            . $livro['id'] . '">Deletar</a> '
            . '<a href="finalCRUD.php?AtualizarID='
            . $livro['id'] . '">Atualizar</a> '
            . $livro['id'] . ': '
            . $livro['ano'] . ' - '
            . $livro['nome'] . '<br>' . PHP_EOL;
    }
}

// ação de atualização dos dados no banco (update)
if(!empty($atualizarID) && empty($deletarID) && $action=='Atualizar') {
    $nomeLivro = filter_input(INPUT_POST, 'nomeLivro', FILTER_SANITIZE_STRING);
    $ano = filter_input(INPUT_POST, 'ano', FILTER_VALIDATE_INT);

    $comandoAtualizar = "UPDATE livro SET nome = '$nomeLivro', ano = $ano
                         WHERE id = $atualizarID;";
    $pdo->exec($comandoAtualizar);

    ?>

    <form method="post" action="finalCRUD.php">
        Nome do Livro:<input type="text" name="nomeLivro"/><br>
        Ano:<input type="number" name="ano"/><br>
        <input type="submit" name="action" value="Cadastrar"/>
        <input type="reset" value="Limpar"><br>
    </form>

    <?php

    $consulta = $pdo->query('SELECT * FROM livro');

    $livrosArray = $consulta->fetchAll(PDO::FETCH_ASSOC);

    echo 'id' . ': ' . 'ano' . ' - ' . 'nome' . '<br>';

    foreach ($livrosArray as $livro) {
        echo '<a href="finalCRUD.php?DeletarID='
            . $livro['id'] . '">Deletar</a> '
            . '<a href="finalCRUD.php?AtualizarID='
            . $livro['id'] . '">Atualizar</a> '
            . $livro['id'] . ': '
            . $livro['ano'] . ' - '
            . $livro['nome'] . '<br>' . PHP_EOL;
    }

}