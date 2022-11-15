<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title><?php print_r($titulo); ?></title>
    <?php $this->load->view('header') ?>
</head>
<?php
$meses = ['janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'];

$mes = date("m") - 1;

$somavenda = 0;
if ($vendamensal) {
    foreach ($vendamensal as $item) {
        $somavenda += $item->quantidade * $item->valor_unitario;
    }
}

$somavendadiaria = 0;
if ($vendadiaria) {
    foreach ($vendadiaria as $diaria) {
        $somavendadiaria += $diaria->quantidade * $diaria->valor_unitario;
    }
}

$somavendaanual = 0;
if ($vendaanual) {
    foreach ($vendaanual as $anual) {
        $somavendaanual += $anual->quantidade * $anual->valor_unitario;
    }
}

$somaprodutos = 0;
if ($produtos) {
    foreach ($produtos as $produto) {
        $somaprodutos += $produto->quantidade * $produto->valor_unitario;
    }
}

$somapadaria = 0;
if ($padaria) {
    foreach ($padaria as $pad) {
        $somapadaria += $pad->quantidade * $pad->valor_unitario;
    }
}


?>

<body>
    <main>
        <?php $this->load->view('topandsidebar') ?>

        <div class="container">
            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne">
                                    <strong>Informações vendas</strong>
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show mb-4" aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body">
                                    <strong>Vendas no dia <?= date('d/m/Y') ?>: </strong> <?= count($vendadiaria); ?> venda(s), totalizando o valor de <?= 'R$ ' . number_format($somavendadiaria, 2, ",", "."); ?>
                                    <br>
                                    <br>
                                    <strong>Quantidade de vendas no mês de <?= $meses[$mes]; ?>: </strong> <?= count($vendamensal); ?> venda(s), totalizando o valor de <?= 'R$ ' . number_format($somavenda, 2, ",", "."); ?>
                                    <br>
                                    <br>
                                    <strong>Venda neste ano </strong> <?= count($vendaanual); ?> venda(s), totalizando o valor de <?= 'R$ ' . number_format($somavendaanual, 2, ",", "."); ?>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-12 centro-relatorio">
                                        <a href="<?= base_url('dashboard/consultar/vendas') ?>"><button class="btn btn-primary" style="width: 100%; padding: 0 6rem;">Consultar Vendas</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                    <strong>Informações estoque</strong>
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show mb-4" aria-labelledby="panelsStayOpen-headingTwo">
                                <div class="accordion-body">
                                    <strong>Total de </strong> <?= count($produtos); ?> itens no estoque (normal), totalizando o valor de <?= 'R$ ' . number_format($somaprodutos, 2, ",", "."); ?> em produtos.
                                    <br>
                                    <br>
                                    <strong>Total de </strong> <?= count($padaria); ?> itens no estoque (padaria), totalizando o valor de <?= 'R$ ' . number_format($somapadaria, 2, ",", "."); ?> em produtos.
                                    <br>
                                    <br>
                                    <strong>Itens a vencer no mês de <?= $meses[$mes]; ?>: </strong> <?= count($qtdproduto); ?> (exceto itens de padaria).
                                </div>
                                <div class="row">
                                    <div class="col-md-12 centro-relatorio">
                                        <a href="<?= base_url('dashboard/consultar/produtos') ?>"><button class="btn btn-primary" style="width: 100%; padding: 0 6rem;">Consultar Produtos</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>

<?php $this->load->view('footer') ?>

</html>