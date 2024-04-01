function validar(botao, id){
    //console.log(botao);
   // $(botao).submit(function(e) {
       // e.preventDefault();

       // console.log(e);
    var cghoraria = $('#cargahoraria'+ id).val();
    console.log(id + "  " + cghoraria);
    if(cghoraria !== "") {
        $.ajax({
            url: 'http://localhost/m/TrabalhoTCC/adm/validar/script.php',
            method: 'POST',
            data: {cargahoraria: cghoraria, comprovanteid: id},
            dataType: 'json',
            success: function(data) {
                $('#form'+id).html("<span style='color: green'><strong>Validado com sucesso! <br> Carga Horária: "+data+"m</strong></span>");
            },
            error: function() {
                $('#form'+id).html("<span style='color: red'><strong>Erro ao validar! Tente novamente mais tarde</strong></span>");
            }
        }).done(function(result) {
            //console.log(result + " done");
            //$('#form'+id).html("<span style='color: green'><strong>Validado com sucesso! <br> Carga Horária: "+result+"m</strong></span>");
        }).fail(function(result) {
            //console.log(result + " fail");
            //$('#form'+id).html("<span style='color: green'><strong>Validado com sucesso! <br> Carga Horária: "+result+"m</strong></span>");
        });
    } else {
        alert("Por favor insira uma carga horária");
    }
    //}); 
}
