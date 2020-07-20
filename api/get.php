<?php

require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'get'){
   
    $id = filter_input(INPUT_GET,'id');

    if($id){
        
        $sql = $pdo->prepare("select * from veiculo where id = :id");
        $sql->bindValue(':id',$id);
        $sql->execute();
            
        if($sql->rowCount()>0){

            $data = $sql->fetch(PDO::FETCH_ASSOC);

            $array['result']=[
                'id' => $data['id'],
                'marca' => $data['marca'],
                'veiculo' => $data['veiculo'],
                'ano' => $data['ano'],
                'descricao' => $data['descricao']
            ];

        }else{
            $array['error'] = 'ID não existente';
        }

    }else{
        $array['error'] = 'ID não enviado';
    }


}else{
    $array['error'] = 'Metodo não suportado por essa api';
}

require('../return.php');

?>