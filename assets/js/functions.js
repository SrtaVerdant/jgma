function somenteNumeros(e) {
    var charCode = e.charCode ? e.charCode : e.keyCode;
    if (charCode != 8 && charCode != 9) {
        if (charCode < 48 || charCode > 57) {
            return false;
        }
    }
}

// Mask para campo CPF
$(document).ready(function(){
    $("#cpf").mask("999.999.999-99");
});

window.onload = function () {
    var date = new Date().toLocaleDateString();
    dataFormatada = FormataStringData(date);   
    const dataAtual = new Date();

    var classesData = document.getElementsByClassName("datavalidade");
    var datas = Array.from(classesData);
    datas.forEach(function (data) {
        new Cleave(data, {
            date: true,
            delimiter: '/',
            dateMin: dataAtual.getFullYear() + '-' + (dataAtual.getMonth() + 1) + '-' + dataAtual.getDate(),
            dateMax: dataFormatada,
            datePattern: ['d', 'm', 'Y']
            
        })
    }); 
    
    var classesDataCompra = document.getElementsByClassName("datacompra");
    var dataCompra = Array.from(classesDataCompra);
    dataCompra.forEach(function (data) {
        new Cleave(data, {
            date: true,
            delimiter: '/',
            dateMax: dataAtual.getFullYear() + '-' + (dataAtual.getMonth() + 1) + '-' + dataAtual.getDate(),
            datePattern: ['d', 'm', 'Y']
            
        })
    });    
};

// Tratativa para data de validade do produto
function FormataStringData(data) {
    var dia = data.split("/")[0];
    var mes = data.split("/")[1];
    var ano = Number(data.split("/")[2]); 
    
    return (ano + 5) + '-' + ("0"+mes).slice(-2) + '-' + ("0"+dia).slice(-2);
}

// Formata moeda para preço unitário
function formatarMoeda(i) {	
    var v = i.value.replace(/\D/g,'');
    v = (v/100).toFixed(2) + '';
    v = v.replace(".", ",");
    v = v.replace(/(\d)(\d{3})(\d{3}),/g, "$1.$2.$3,");
    v = v.replace(/(\d)(\d{3}),/g, "$1.$2,");
    i.value = v;
    i.value = 'R$ ' + i.value;
	
}

$('.select2').select2({   
    selectOnClose: true
});




