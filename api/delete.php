<?php

require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'delete'){
 
   parse_str(file_get_contents('php://input'), $input);

   $id = filter_var((!empty($input['id'])) ? $input['id'] : null);

   if($id){

        $sql = $pdo->prepare("DELETE FROM veiculo WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();       

   }else{
       $array ['error'] = "ID não enviado";
   }

}else{
    $array['error'] = 'Metodo não suportado por essa api';
}

require('../return.php');

?>