<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="http://localhost/oncarteste/assets/css/style.css">
    <link rel="stylesheet" href="http://localhost/oncarteste/assets/icofont/icofont.css">

    <title>Oncar</title>
  </head>
  <body>
    <div class="container">
        <div class="row" style="border-bottom: 1px solid #ccd2d8;">
            <div class="col-md-3 col-sm-12" style="border-right: 1px solid #ccd2d8;">
               <h1 class="text-center text-info p-3">TESTE</h1> 
            </div>
        </div> 
        <!--input de busca + botoes cadastrar e buscar-->     
        <div class="row mx-auto">
            <div class="col-md-10 col-8 px-0">
                <form>
                    <div class="form-group pt-4 px-0">              
                        <input type="text" class="form-control" placeholder="Buscar veículo">                                                               
                    </div>                                                    
                </form> 
            </div>
            <div class="col-xs-2 buttons pt-4 px-1">
                <button type="button" id="search" class="btn btn-info"><i class="icofont-search-1"></i></button>
                <button type="button" id="add" class="btn btn-info" data-toggle="modal" data-target="#modalContactForm"><i class="icofont-ui-add"></i></button>
            </div>    
        </div>      

        
        <div class="row p-3" style="background-color: #e9ecef5e;">
            <div class="col-12 col-md-6 pt-4 pb-4 mx-md-3 card list-box">
                <h3 class="card-title text-center pt-2"><i class="icofont-listing-box"></i> Lista de veiculos</h3><hr>
                <?php    
                
                //função de request e retorno em json
                function getJson($url){
                    $json = file_get_contents($url);        
                    return $result = json_decode($json,true);                    
                }

                //função do loop para listar veiculos
                function listAll($result){
                    
                    $loop = (count($result['result']) -1);                  

                    for ($i=0; $i <= $loop ;$i++) {?>
                        <div id="<?php echo $result['result'][$i]['id'];?>" class="card p-3">

                        <?php $url = "http://localhost/oncarteste/veiculos/".$result['result'][$i]['id'];?>

                            <div row>
                                <div class="col-sm-8 d-inline-block">
                                    <h4><strong><?php echo $result['result'][$i]['veiculo']; ?></strong></h4>
                                    <p class="card-subtitle text-primary"><?php echo $result['result'][$i]['marca'];?></p>
                                    <h5><?php echo $result['result'][$i]['ano']; ?></h5>                                                                      
                                </div>  
                                <div class="col-sm-3 d-inline-block">
                                    <a href="<?php echo $url;?>" id="editar" class="btn-lg btn-info float-right"><i class="icofont-edit"></i></a>
                                </div> 
                            </div>
                        </div>
                    <?php }  
                }

                    //Pegando os parametros no get e requisitando na API
                    if (!empty($_REQUEST)){
                        
                        $url = $_REQUEST;
                        $method = $_SERVER['REQUEST_METHOD'];
                        $url = explode('/', $url['url']);

                        //listar todos os veiculos e os detalhes pelo parametro id
                        if(count($url)>1 && strlen($url[1])>0){

                            $details = getJson("http://localhost/oncarteste/api/get.php?id=$url[1]");
                            
                            $result = getJson('http://localhost/oncarteste/api/getall.php');
                            
                            listAll($result);
                           

                        }else if($endpoint = $url[0] == 'veiculos' && $method == 'GET'){

                            //listando todos os veiculos                            
                            $result = getJson('http://localhost/oncarteste/api/getall.php');                            
                                
                            listAll($result);
                        }     
                    }else{
                            echo "<h3 class='text-center'>não há veiculos a serem listados</h3><br>
                            <a class='text-center' href='http://localhost/oncarteste/veiculos'>Exibir lista</a>";
                        
                    }?>
            </div>

            <div class="col-12 col-md-6 pt-4 pb-4 card detail-box">
                <h3 class="card-title text-center pt-2"><i class="icofont-newspaper"></i> Detalhes do veiculo</h3><hr>
                <?php if (!empty($details['result'])) {?>

                    <h2><span class="text-secondary">Veículo:</span> <?php echo $details['result']['veiculo'];?></h2>
                        <div class="row p-2">
                            <div class="card marca col-6 m-1">
                                <span class="text-secondary">Marca:</span> <?php echo $details['result']['marca']; ?>
                            </div>
                            <div class="card ano col-6 m-1">
                                <span class="text-secondary">Ano:</span> <?php echo $details['result']['ano']; ?>
                            </div>
                        </div> 
                        
                    <h3 class="text-secondary">Descrição</h3>    
                        <div class="card p-2">
                            <p>
                                <?php echo $details['result']['descricao']; ?>                        
                            </p> 
                        </div><hr>             
                    <button id="edit" class="btn-lg btn-info" data-toggle="modal" data-target="#modalContactForm">Editar</button>       
            </div>
                <?php
                    }else  {
                        echo "<h2 class='text-center'>ID inexistente ou veículo não selecionado<h2>";
                    } 
                ?> 
                
                
            <!--modal formulario-->
            <div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h4 class="modal-title w-100 font-weight-bold">Tela de Cadastro</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <div class="modal-body mx-3">
                        <input type="hidden" name="idcar" id="idcar" value="<?php if(!empty($details['result'])){ echo $details['result']['id'];}?>">
                        <div class="md-form mb-5">
                            <label data-error="wrong" data-success="right" for="veiculo">Veículo:</label>
                            <input type="text" id="veiculo" class="form-control validate" value="<?php if(!empty($details['result'])){ echo $details['result']['veiculo'];}?>">                        
                        </div>

                        <div class="md-form mb-5">
                            <label data-error="wrong" data-success="right" for="form29">Marca:</label>
                            <input type="email" id="marca" class="form-control validate" value="<?php if(!empty($details['result'])){ echo $details['result']['marca'];}?>">                    
                        </div>

                        <div class="md-form mb-5">
                            <label data-error="wrong" data-success="right" for="form32">Ano:</label>
                            <input type="text" id="ano" class="form-control validate" value="<?php if(!empty($details['result'])){ echo $details['result']['ano'];}?>">                    
                        </div>

                        <div class="md-form">
                            <label data-error="wrong" data-success="right" for="form8">Descrição:</label>
                            <textarea type="text" id="descricao" class="md-textarea form-control" rows="4"><?php if(!empty($details['result'])){ echo $details['result']['descricao'];}?></textarea>                    
                        </div>
                        <div class="md-form mt-3">                            
                            <input type="checkbox" id="vendido"></input>  
                            <label for="vendido">vendido</label>                  
                        </div>
                    </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button id="" class="btn btn-info button-save">Salvar <i class="icofont-save"></i></button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="http://localhost/oncarteste/assets/js/APIrequest.js"></script>
</body>
</html>