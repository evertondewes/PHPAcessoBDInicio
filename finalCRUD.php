<?php

require_once 'funcoesCRUD.php';

$pdo = criarConexcao();

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
$atualizarID = filter_input(INPUT_GET, 'AtualizarID', FILTER_VALIDATE_INT);
$deletarID = filter_input(INPUT_GET, 'DeletarID', FILTER_VALIDATE_INT);


echo '$atualizarID: '.$atualizarID.'<br>';
echo '$deletarID: '.$deletarID.'<br>';
echo '$action: '.$action.'<br>';

// apresentação do form de cadastro e listagem
if(empty($atualizarID) && empty($deletarID) && empty($action)){
    criarFormCadastro();
    listarLivros($pdo);

}

// ação de cadastrar
if(empty($atualizarID) && empty($deletarID) && $action== 'Cadastrar') {
    $nomeLivro = filter_input(INPUT_POST, 'nomeLivro', FILTER_SANITIZE_STRING);
    $ano = filter_input(INPUT_POST, 'ano', FILTER_VALIDATE_INT);

    criarOuAtualizar($pdo, $nomeLivro, $ano);

    criarFormCadastro();

    listarLivros($pdo);
}

// ação de apagar
if(empty($atualizarID) && !empty($deletarID) && empty($action)) {
    $comandoSQL = "delete from livro where id = $deletarID;";

    $totalPagados = $pdo->exec($comandoSQL);

    echo 'totalPagados:' . $totalPagados . '<br>';

    criarFormCadastro();

    listarLivros($pdo);
}

// ação para abrir o formulário de edição
if(!empty($atualizarID) && empty($deletarID) && empty($action)) {

    $livro = consultarLivrosBanco($pdo, $atualizarID );

    criarFormAtualizar($livro);

    listarLivros($pdo);
}

// ação de atualização dos dados no banco (update)
if(!empty($atualizarID) && empty($deletarID) && $action=='Atualizar') {
    $nomeLivro = filter_input(INPUT_POST, 'nomeLivro', FILTER_SANITIZE_STRING);
    $ano = filter_input(INPUT_POST, 'ano', FILTER_VALIDATE_INT);

    criarOuAtualizar($pdo, $nomeLivro, $ano, $atualizarID);

    criarFormCadastro();

    listarLivros($pdo);

}