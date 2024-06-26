// ... Função ajax de validar ... //
function validar(id){
    var cghoraria = $('#cargahoraria'+ id).val();
    if(cghoraria != "") {
        $.ajax({
            url: './validar.php',
            method: 'POST',
            data: {cargahoraria: cghoraria, comprovanteid: id},
            dataType: 'json',
            success: function(data) {
                $('#form'+id).html("<span style='color: green'><strong>Validado com sucesso! <br> Carga Horária: "+data+"m</strong></span>");
            },
            error: function(data) {
                //alert(data);
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
}

// ... Função ajax de revogar ... //
function revogar(id) {
    console.log('chamou', id);
    console.log('form'+id);
    $.ajax({
        url: './revogar.php',
        method: 'POST',
        data: {comprovanteid: id},
        dataType: 'json',
        success: function() {
            $('#form'+id).html("<span style='color: green'><strong>Revogado com sucesso! Por favor atualize a página.</strong></span>");
        },
        error: function() {
            $('#form'+id).html("<span style='color: #DC143C'><strong>Falha ao revogar. Tente novamente mais tarde</strong></span>");
        }
    });
}



/* ... Organização e pesquisa ... */
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
            var dataA = new Date($(a).find('td:eq(6)').text().split(' ')[0].split('/').reverse().join('-')).getTime();
            var dataB = new Date($(b).find('td:eq(6)').text().split(' ')[0].split('/').reverse().join('-')).getTime();
            return dataA - dataB;
        }).appendTo('.table tbody');
        ordenouData = 1;
    } else {
        $('.table tbody tr').sort(function(a, b) {
            var dataA = new Date($(a).find('td:eq(6)').text().split(' ')[0].split('/').reverse().join('-')).getTime();
            var dataB = new Date($(b).find('td:eq(6)').text().split(' ')[0].split('/').reverse().join('-')).getTime();
            return dataB - dataA;
        }).appendTo('.table tbody');
        ordenouData = 0;
    }
}

$(document).ready(function() {
    ordenarPorValidacao(); // Chama a função de ordenação por validação ao carregar a página
    
    // Esconder todas as linhas da tabela
    $('#tbody tr').hide();

    // Mostrar apenas os itens não validados ao carregar a página
    $('#tbody tr:has(td:has(form))').show();

    $('#btnMostrarValidados').on('click', function() {
        $('#tbody tr').hide();
        $('#tbody tr:has(td:contains("Já validado"))').show();
    });

    $('#btnMostrarNaoValidados').on('click', function() {
        $('#tbody tr').hide();
        $('#tbody tr:has(td:has(form))').show();
    });
    
    $('#btnMostrarTodos').on('click', function() {
        $('#tbody tr').show();
    });
});

var ordenouValidacao = 1;
function ordenarPorValidacao() {
    if (ordenouValidacao == 0) {
        $('.table tbody tr').sort(function(a, b) {
            var validadoA = $(a).find('td:eq(8)').find('form').length; // Verifica se há um formulário na coluna de validação
            var validadoB = $(b).find('td:eq(8)').find('form').length;
            return validadoA - validadoB;
        }).appendTo('.table tbody');
        ordenouValidacao = 1;
    } else {
        $('.table tbody tr').sort(function(a, b) {
            var validadoA = $(a).find('td:eq(8)').find('form').length;
            var validadoB = $(b).find('td:eq(8)').find('form').length;
            return validadoB - validadoA;
        }).appendTo('.table tbody');
        ordenouValidacao = 0;
    }
}

function pesquisa() {
    var input = $('#inputPesquisa').val().toLowerCase();
    $('#tbody tr').each(function() {
        var encontrado = false;
        $(this).find('td').each(function() {
            if ($(this).text().toLowerCase().indexOf(input) > -1) {
                encontrado = true;
                return false; // Sai do loop interno se encontrar correspondência
            }
        });
        $(this).toggle(encontrado); // Exibe ou oculta a linha com base na correspondência
    });
}