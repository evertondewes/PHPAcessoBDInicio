<?php

function criarConexcao() {
     $pdo= new PDO("mysql:host=localhost:3306;
                    dbname=biblioteca;charset=latin1",
        'root', '');

     return $pdo;
}

function consultarLivrosBanco($pdo, $atualizarID = null){
    if(is_null($atualizarID)) {
        $consulta = $pdo->query('SELECT livro.id as "idLivro",
                                 livro.nome as "nomeLivro", livro.ano, autor.nome  as "nomeAutor"
                                 FROM livro, autor 
                                 where livro.id_autor = autor.id');
    } else {
        $sql = "SELECT livro.id as 'idLivro',
                       livro.nome as 'nomeLivro', 
                       livro.ano, 
                       autor.id  as 'idAutor'
                       FROM livro, autor WHERE 
              livro.id_autor = autor.id and livro.id = $atualizarID;";


        $consulta = $pdo->query($sql);
    }

    $livrosArray = $consulta->fetchAll(PDO::FETCH_ASSOC);

    return $livrosArray;
}

function listarLivros($pdoConexcao) {

    $livrosArray = consultarLivrosBanco($pdoConexcao);

    echo 'id' . ': ' . 'ano' . ' - ' . 'nome' . '<br>';

    foreach ($livrosArray as $livro) {
        echo '<a href="finalCRUD.php?DeletarID='
            . $livro['idLivro'] . '">Apagar</a> '
            . '<a href="finalCRUD.php?AtualizarID='
            . $livro['idLivro'] . '">Atualizar</a> '
            . $livro['idLivro'] . ': '
            . $livro['ano'] . ' - '
            . $livro['nomeLivro'] . ' - '
            . $livro['nomeAutor'] .'<br>' . PHP_EOL;
    }
}

function criarFormAtualizar($livro, $autores){
    if(is_array($livro) && count($livro)>0) {
        $id = $livro[0]['idLivro'];
        $ano = $livro[0]['ano'];
        $nome = $livro[0]['nomeLivro'];
        $idAutor = $livro[0]['idAutor'];
        ?>
        <form method="post">
            ID: <?php echo $id; ?><br>
            <input type="hidden" value="<?php echo $id; ?>" name="id">
            Nome do Livro:<input type="text" value="<?php echo $nome; ?>" name="nomeLivro"/><br>
            Ano:<input type="number" value="<?php echo $ano; ?>" name="ano"/><br>
            Selecionar Autor:
            <select name="id_autor">
                <?php
                foreach ($autores as $autor){

                    $selected = ($autor['id']==$idAutor)?'selected':'';

                    echo '<option '.$selected.'  value="' . $autor['id'] .'">' .
                        $autor['nome'] . '</option>' . PHP_EOL;
                }
                ?>
            </select>
            <br>
            <input type="submit" name="action" value="Atualizar"/>
            <a href="finalCRUD.php">Cancelar</a>
            <br>
        </form>
        <?php
    }
}

function criarFormCadastro($autores){
    ?>

    <form method="post" action="finalCRUD.php">
        Nome do Livro:<input type="text" name="nomeLivro"/><br>
        Ano:<input type="number" name="ano"/><br>
        Selecionar Autor:
        <select name="id_autor">
            <?php
            foreach ($autores as $autor){
                echo '<option value="' . $autor['id'] .'">' .
                    $autor['nome'] . '</option>' . PHP_EOL;
            }
            ?>
        </select>
        <br>
        <input type="submit" name="action" value="Cadastrar"/>
        <input type="reset" value="Limpar"><br>
    </form>

    <?php
}

function criarOuAtualizar($pdo, $nomeLivro, $ano, $idAutor, $atualizarID = null){
    if(is_null($atualizarID)){
        $comandoSQL = "INSERT INTO livro(nome, ano, id_autor)
                       VALUES('$nomeLivro',$ano, $idAutor);";
    } else {
        $comandoSQL = "UPDATE livro 
                       SET nome = '$nomeLivro', ano = $ano, id_autor = $idAutor
                       WHERE id = $atualizarID;";
    }
    $pdo->exec($comandoSQL);

}


function criarFormAutor(){

    ?>

    <form method="post" action="autores.php">
        Nome do Autor:<input type="text" name="nomeAutor"/><br>
        <input type="submit" name="action" value="Cadastrar"/>
        <input type="reset" value="Limpar"><br>
    </form>

    <?php
}

function consultarAutoresBanco($pdo, $atualizarID = null){
    if(is_null($atualizarID)) {
        $consulta = $pdo->query('SELECT * FROM autor');
    } else {
        $consulta = $pdo->query(
            "SELECT * FROM autor WHERE id = $atualizarID;");
    }

    $autoresArray = $consulta->fetchAll(PDO::FETCH_ASSOC);

    return $autoresArray;
}


function listarAutores($pdoConexcao) {

    $autoresArray = consultarAutoresBanco($pdoConexcao);

    echo 'id' . ': '. 'nome' . '<br>';

    foreach ($autoresArray as $autores) {
        echo '<a href="autores.php?DeletarID='
            . $autores['id'] . '">Apagar</a> '
            . '<a href="autores.php?AtualizarID='
            . $autores['id'] . '">Atualizar</a> '
            . $autores['id'] . ': '
            . $autores['nome'] . '<br>' . PHP_EOL;
    }
}

function criarFormAtualizarAutor($autor){
    if(is_array($autor) && count($autor)>0) {
        $id = $autor[0]['id'];
        $nome = $autor[0]['nome'];
        ?>
        <form method="post">
            ID: <?php echo $id; ?><br>
            <input type="hidden" value="<?php echo $id; ?>" name="id">
            Nome do Autor:<input type="text" value="<?php echo $nome; ?>" name="nomeAutor"/><br>
            <input type="submit" name="action" value="Atualizar"/>
            <a href="autores.php">Cancelar</a>
            <br>
        </form>
        <?php
    }
}


function criarOuAtualizarAutor($pdo, $nomeAutor,  $atualizarID = null){
    if(is_null($atualizarID)){
        $comandoSQL = "INSERT INTO autor(nome)
                       VALUES('$nomeAutor');";
    } else {
        $comandoSQL = "UPDATE autor 
                       SET nome = '$nomeAutor'
                       WHERE id = $atualizarID;";
    }
    $pdo->exec($comandoSQL);

}
