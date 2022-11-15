function somenteNumeros(e) {
	var charCode = e.charCode ? e.charCode : e.keyCode;
	if (charCode != 8 && charCode != 9) {
		if (charCode < 48 || charCode > 57) {
			return false;
		}
	}
}

// Mask para campo CPF
$(document).ready(function () {
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

	var classesData = document.getElementsByClassName("datavalidadepadaria");
	var datas = Array.from(classesData);
	const validadePadaria = new Date(dataAtual.getFullYear(), dataAtual.getMonth(), dataAtual.getDate());
	validadePadaria.setDate(validadePadaria.getDate() + 30);

	datas.forEach(function (data) {		
		new Cleave(data, {
			date: true,
			delimiter: '/',
			dateMin: dataAtual.getFullYear() + '-' + (dataAtual.getMonth() + 1) + '-' + dataAtual.getDate(),
			dateMax: FormataStringDataPadaria(validadePadaria.toLocaleDateString()),
			datePattern: ['d', 'm', 'Y']

		})
	});

};

// Tratativa para data de validade do produto +5 anos
function FormataStringData(data) {
	var dia = data.split("/")[0];
	var mes = data.split("/")[1];
	var ano = Number(data.split("/")[2]);

	return (ano + 5) + '-' + ("0" + mes).slice(-2) + '-' + ("0" + dia).slice(-2);
}

// Tratativa para data de validade do produto de padaria
function FormataStringDataPadaria(data) {
	var dia = data.split("/")[0];
	var mes = data.split("/")[1];
	var ano = Number(data.split("/")[2]);

	return ano + '-' + ("0" + mes).slice(-2) + '-' + ("0" + dia).slice(-2);
}


// Formata moeda para preço unitário
function formatarMoeda(i) {
	var v = i.value.replace(/\D/g, '');
	v = (v / 100).toFixed(2) + '';
	v = v.replace(".", ",");
	v = v.replace(/(\d)(\d{3})(\d{3}),/g, "$1.$2.$3,");
	v = v.replace(/(\d)(\d{3}),/g, "$1.$2,");
	i.value = v;
	i.value = 'R$ ' + i.value;

}

$('.select2').select2({
	selectOnClose: true
});


function formataCNPJ(cnpj) {
	const element = document.querySelector('#cnpj');
	if (validarCNPJ(cnpj.value)) {
		element.classList.remove('cnpj');
		inserir.disabled = false;
	} else {
		element.classList.add('cnpj');
		inserir.disabled = true;
	}
}

function validarCNPJ(cnpj) {

	cnpj = cnpj.replace(/[^\d]+/g, '');

	if (cnpj == '') return false;

	if (cnpj.length != 14)
		return false;

	// Elimina CNPJs invalidos conhecidos
	if (cnpj == "00000000000000" ||
		cnpj == "11111111111111" ||
		cnpj == "22222222222222" ||
		cnpj == "33333333333333" ||
		cnpj == "44444444444444" ||
		cnpj == "55555555555555" ||
		cnpj == "66666666666666" ||
		cnpj == "77777777777777" ||
		cnpj == "88888888888888" ||
		cnpj == "99999999999999")
		return false;

	// Valida DVs
	tamanho = cnpj.length - 2
	numeros = cnpj.substring(0, tamanho);
	digitos = cnpj.substring(tamanho);
	soma = 0;
	pos = tamanho - 7;
	for (i = tamanho; i >= 1; i--) {
		soma += numeros.charAt(tamanho - i) * pos--;
		if (pos < 2)
			pos = 9;
	}
	resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
	if (resultado != digitos.charAt(0))
		return false;

	tamanho = tamanho + 1;
	numeros = cnpj.substring(0, tamanho);
	soma = 0;
	pos = tamanho - 7;
	for (i = tamanho; i >= 1; i--) {
		soma += numeros.charAt(tamanho - i) * pos--;
		if (pos < 2)
			pos = 9;
	}
	resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
	if (resultado != digitos.charAt(1))
		return false;

	return true;

}

new Cleave(
	document.getElementById('cnpj'), {
		delimiters: ['.', '.', '/', '-'],
		blocks: [2, 3, 3, 4, 2],
		numericOnly: true,
		delimiterLazyShow: true
	}
);


