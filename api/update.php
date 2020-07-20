<?php

require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'put'){
 
   parse_str(file_get_contents('php://input'), $input);

   $id = filter_var((!empty($input['id'])) ? $input['id'] : null);
   $veiculo = filter_var((!empty($input['veiculo'])) ? $input['veiculo'] : null);
   $marca = filter_var((!empty($input['marca'])) ? $input['marca'] : null);
   $ano = filter_var((!empty($input['ano'])) ? $input['ano'] : null);
   $descricao = filter_var((!empty($input['descricao'])) ? $input['descricao'] : null);
   $vendido = filter_var((!empty($input['vendido'])) ? $input['vendido'] : null);
   date_default_timezone_set('America/Sao_Paulo');  
   $date = date('Y/m/d H:i:s');
    $vendido = $vendido ? $vendido = 1 : $vendido = 0;

   if($id && $veiculo && $marca && $ano && $descricao && $vendido){

        $sql = $pdo->prepare("select * from veiculo where id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount()>0){

            $sql = $pdo->prepare("UPDATE veiculo SET veiculo = :veiculo, marca = :marca, ano = :ano, descricao = :descricao, vendido = :vendido, updated = :updated WHERE id = :id ");
            $sql->bindValue(':id', $id);
            $sql->bindValue(':veiculo', $veiculo);
            $sql->bindValue(':marca', $marca);
            $sql->bindValue(':ano', $ano);
            $sql->bindValue(':descricao', $descricao);
            $sql->bindValue(':vendido', $vendido);
            $sql->bindValue(':updated', $date);  
            $sql->execute();

            $array['result']=[
                'id' => $id,
                'veiculo' => $veiculo,
                'ano' => $ano
            ];

        }else{
            $array['error'] = "id inexistente";
        }

   }else{
       $array ['error'] = "dados nao enviado";
   }

}else{
    $array['error'] = 'Metodo não suportado por essa api';
}

require('../return.php');

?>