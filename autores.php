<html>
<body>
<?php

require_once 'menu.php';
require_once 'funcoesCRUD.php';

$pdo = criarConexcao();

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
$atualizarID = filter_input(INPUT_GET, 'AtualizarID', FILTER_VALIDATE_INT);
$deletarID = filter_input(INPUT_GET, 'DeletarID', FILTER_VALIDATE_INT);


// apresentação do form de cadastro e listagem
if(empty($atualizarID) && empty($deletarID) && empty($action)){
    criarFormAutor();
    listarAutores($pdo);

}

// ação de cadastrar
if(empty($atualizarID) && empty($deletarID) && $action== 'Cadastrar') {
    $nomeAutor = filter_input(INPUT_POST, 'nomeAutor', FILTER_SANITIZE_STRING);

    criarOuAtualizarAutor($pdo, $nomeAutor);

    criarFormAutor();

    listarAutores($pdo);
}

// ação de apagar
if(empty($atualizarID) && !empty($deletarID) && empty($action)) {
    $comandoSQL = "delete from autor where id = $deletarID;";

    $totalPagados = $pdo->exec($comandoSQL);

    echo 'totalPagados:' . $totalPagados . '<br>';

    criarFormAutor();

    listarAutores($pdo);
}

// ação para abrir o formulário de edição
if(!empty($atualizarID) && empty($deletarID) && empty($action)) {

    $autor = consultarAutoresBanco($pdo, $atualizarID );

    criarFormAtualizarAutor($autor);

    listarAutores($pdo);
}

// ação de atualização dos dados no banco (update)
if(!empty($atualizarID) && empty($deletarID) && $action=='Atualizar') {
    $nomeAutor = filter_input(INPUT_POST, 'nomeAutor', FILTER_SANITIZE_STRING);

    criarOuAtualizarAutor($pdo, $nomeAutor, $atualizarID);

    criarFormAutor();

    listarAutores($pdo);

}

?>
</body>
</html>
