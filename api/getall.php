<?php

require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'get'){
    $sql = $pdo->query("select * from veiculo order by id desc");

    if($sql->rowCount()>0){
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $item){
            $array['result'][] =[
                'id' => $item['id'],
                'veiculo' => $item['veiculo'],
                'marca' => $item['marca'],
                'ano' => $item['ano']
            ];
        }
    }
}else{
    $array['error'] = 'Metodo não suportado por essa api';
}

require('../return.php');

?>