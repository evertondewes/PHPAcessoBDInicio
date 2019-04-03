<?php

function criarConexcao() {
     $pdo= new PDO("mysql:host=localhost:3306;
                    dbname=biblioteca;charset=latin1",
        'root', '');

     return $pdo;
}

function consultarLivrosBanco($pdo, $atualizarID = null){
    if(is_null($atualizarID)) {
        $consulta = $pdo->query('SELECT * FROM livro');
    } else {
        $consulta = $pdo->query(
            "SELECT * FROM livro WHERE id = $atualizarID;");
    }

    $livrosArray = $consulta->fetchAll(PDO::FETCH_ASSOC);

    return $livrosArray;
}

function listarLivros($pdoConexcao) {

    $livrosArray = consultarLivrosBanco($pdoConexcao);

    echo 'id' . ': ' . 'ano' . ' - ' . 'nome' . '<br>';

    foreach ($livrosArray as $livro) {
        echo '<a href="finalCRUD.php?DeletarID='
            . $livro['id'] . '">Apagar</a> '
            . '<a href="finalCRUD.php?AtualizarID='
            . $livro['id'] . '">Atualizar</a> '
            . $livro['id'] . ': '
            . $livro['ano'] . ' - '
            . $livro['nome'] . '<br>' . PHP_EOL;
    }
}

function criarFormAtualizar($livro){
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
}

function criarFormCadastro(){

    ?>

    <form method="post" action="finalCRUD.php">
        Nome do Livro:<input type="text" name="nomeLivro"/><br>
        Ano:<input type="number" name="ano"/><br>
        <input type="submit" name="action" value="Cadastrar"/>
        <input type="reset" value="Limpar"><br>
    </form>

    <?php
}

function criarOuAtualizar($pdo, $nomeLivro, $ano, $atualizarID = null){
    if(is_null($atualizarID)){
        $comandoSQL = "INSERT INTO livro(nome, ano)
                       VALUES('$nomeLivro',$ano);";
    } else {
        $comandoSQL = "UPDATE livro 
                       SET nome = '$nomeLivro', ano = $ano
                       WHERE id = $atualizarID;";
    }
    $pdo->exec($comandoSQL);

}
