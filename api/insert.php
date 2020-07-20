<?php

require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'post'){

    $veiculo = filter_input(INPUT_POST, 'veiculo');
    $marca = filter_input(INPUT_POST, 'marca');
    $ano = filter_input(INPUT_POST, 'ano');
    $descricao = filter_input(INPUT_POST, 'descricao');
    $vendido = filter_input(INPUT_POST, 'vendido'); 
    date_default_timezone_set('America/Sao_Paulo');  
    $date = date('Y/m/d H:i:s');
    $vendido = $vendido ? $vendido = 1 : $vendido = 0;

    if(($veiculo && $marca) && ($ano && $descricao)){
        $sql = $pdo->prepare("insert into veiculo (veiculo, marca, ano, descricao, vendido, created, updated) values (:veiculo, :marca, :ano, :descricao, :vendido, :created, :updated)");
        $sql->bindValue(':veiculo', $veiculo);
        $sql->bindValue(':marca', $marca);
        $sql->bindValue(':ano', $ano);
        $sql->bindValue(':descricao', $descricao);
        $sql->bindValue(':vendido', $vendido);
        $sql->bindValue(':created', $date);
        $sql->bindValue(':updated', $date);     
        $sql->execute();   

        $id = $pdo->lastInsertId();

        $array['result'] = [
            'id' => $id,
            'veiculo' => $veiculo,
            'ano' => $ano
        ];
    }else{
        $array['error'] = "campos não enviados";
    }

}else{
    $array['error'] = 'Metodo não suportado por essa api';
}

require('../return.php');

?>