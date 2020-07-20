$(document).ready(function(){    
    //listar todos    
    $("#search").click(function(){
        window.location.href = 'http://localhost/oncarteste/veiculos';
    });

    $("#add").click(function(){

        //limpar os campos
        $(".button-save").attr("id", "add");
        $("#veiculo").val('');
        $("#marca").val('');
        $("#ano").val('');
        $("#descricao").val('');

    });

    $("#edit").click(function(){

        $(".button-save").attr("id", "edit");

    });

    $(".button-save").click(function(){
        if($(".button-save").attr('id') == 'edit'){
            url = "http://localhost/oncarteste/api/update.php";
            method = "PUT";            
        }else{
            url = "http://localhost/oncarteste/api/insert.php";
            method = "POST";
        }
            sendAPi(url,method);
    });

});

//função que manda para api post ou put
function sendAPi(url,method,){
    if($('#veiculo').val() != '' &&
        $('#marca').val() != '' &&
        $('#ano').val() != '' &&
        $('#descricao').val() != ''){
            var id = $('#idcar').val();
            var veiculo = $('#veiculo').val();
            var marca = $('#marca').val();
            var ano = $('#ano').val();
            var descricao = $('#descricao').val();
            var vendido = $("#vendido").is(":checked");
            
        $.ajax({
            url: url,
            type: method,
            data:{"id": id ,"veiculo": veiculo,"marca": marca ,"ano": ano,"descricao": descricao,"vendido": vendido},
            success: function(data) {
                console.log(data);
                location.reload();
            }
        });
    }else{
        alert("Preencha todos os dados");
    }
}