<?php

function imprimir($numero, $nome, $sobrenome = 'marinho'){
  //  echo $nome . ' ' .$sobrenome .  ' ola mundo ' . $numero . '<br>';
    return 'sucesso ' . $nome . ' ' . $numero;
}

for($i=0; $i<10; $i++) {
    $resultado = imprimir($i, 'pedro');
    echo $resultado . '<br>';
}

for($j=10; $j > 0; $j--){
    echo imprimir($j , 'everton', 'dewes'). '<br>';
}