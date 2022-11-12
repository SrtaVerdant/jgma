<?php
    function formataCPF($cpf){
        $cpf = str_replace('.','', str_replace('-','', $cpf));
        return $cpf;
    }

    function formataMoedaDecimal($valor) {
        $valor = str_replace('R$ ','', str_replace(',','.', str_replace('.','Y', $valor)));
        $valor = str_replace('Y', '', $valor);
        return (float) $valor;
    }

?>