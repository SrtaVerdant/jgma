<?php
function formataCPF($cpf){

   $cpf = str_replace('.','', str_replace('-','', $cpf));

    return $cpf;
}
?>