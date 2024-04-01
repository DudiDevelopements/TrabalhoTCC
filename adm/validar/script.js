function validar(botao, id){
    //console.log(botao);
   // $(botao).submit(function(e) {
       // e.preventDefault();

       // console.log(e);
    var cghoraria = $('#cargahoraria'+ id).val();
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
var ordenouNome = 0;
function ordenarPorNome() {
    if(ordenouNome == 0) {
        $('.table tbody tr').sort(function(a, b) {
            var nomeA = $(a).find('td:first').text().toUpperCase();
            var nomeB = $(b).find('td:first').text().toUpperCase();
            return (nomeA < nomeB) ? -1 : (nomeA > nomeB) ? 1 : 0;
        }).appendTo('.table tbody');
        ordenouNome = 1;
    }
    else {
        $('.table tbody tr').sort(function(a, b) {
            var nomeA = $(a).find('td:first').text().toUpperCase();
            var nomeB = $(b).find('td:first').text().toUpperCase();
            return (nomeA > nomeB) ? -1 : (nomeA < nomeB) ? 1 : 0;
        }).appendTo('.table tbody');
        ordenouNome = 0;
    }
}
var ordenouEmail = 0;
function ordenarPorEmail() {
    if(ordenouEmail == 0) {
        $('.table tbody tr').sort(function(a, b) {
            var emailA = $(a).find('td:eq(1)').text().toUpperCase();
            var emailB = $(b).find('td:eq(1)').text().toUpperCase();
            return (emailA < emailB) ? -1 : (emailA > emailB) ? 1 : 0;
        }).appendTo('.table tbody');
        ordenouEmail = 1;
    }
    else {
        $('.table tbody tr').sort(function(a, b) {
            var emailA = $(a).find('td:eq(1)').text().toUpperCase();
            var emailB = $(b).find('td:eq(1)').text().toUpperCase();
            return (emailA > emailB) ? -1 : (emailA < emailB) ? 1 : 0;
        }).appendTo('.table tbody');
        ordenouEmail = 0;
    }
}

var ordenouData = 0;

function ordenarPorData() {
    if (ordenouData == 0) {
        $('.table tbody tr').sort(function(a, b) {
            var dataA = new Date($(a).find('td:eq(6)').text()); // Seleciona a sétima coluna (índice 6) que contém a data
            var dataB = new Date($(b).find('td:eq(6)').text());
            return dataA - dataB;
        }).appendTo('.table tbody');
        ordenouData = 1;
    } else {
        $('.table tbody tr').sort(function(a, b) {
            var dataA = new Date($(a).find('td:eq(6)').text());
            var dataB = new Date($(b).find('td:eq(6)').text());
            return dataB - dataA;
        }).appendTo('.table tbody');
        ordenouData = 0;
    }
}
