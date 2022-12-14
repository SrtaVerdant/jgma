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

<body>
    <main>
        <?php $this->load->view('topandsidebar') ?>

        <div class="container">
            <?= form_open("dashboard/editarProduto", 'id="formsubmit"'); ?>

            <div class="row espacoentre-inputs">
                <div class="col-md-6">
                    <label for="produto" class="font-weight-normal">Nome:</label>
                    <input type="text" name="produto" required class="form-control" value="<?= $produto->nome ?>">
                </div>

                <div class="col-md-6">
                    <label for="quantidade" class="font-weight-normal">Quantidade:</label>
                    <input type="tel" name="quantidade" required class="form-control" maxlength="5" onkeypress="return somenteNumeros(event)" value="<?= $produto->quantidade ?>">
                </div>
            </div>

            <div class="row espacoentre-inputs">
                <div class="col-md-6">
                    <label for="fornecedor" class="font-weight-normal">Fornecedor:</label>
                    <select class="form-control js-example-placeholder-single js-states select2" name="fornecedor">
                        <option disabled value="-" selected>-</option>
                        <?php foreach ($fornecedores as $fornecedor) { ?>
                            <option value="<?php print_r($fornecedor->id_forne_pk); ?>" <?php if ($fornecedor->id_forne_pk == $produto->fk_forne) {
                                                                                            echo "selected='selected'";
                                                                                        } ?>><?= $fornecedor->nome_forne; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="validade" class="font-weight-normal">Prazo de validade:</label>
                    <input type="tel" id="validade" name="validade" required class="datavalidade form-control" value="<?= $produto->prazo_validade ?>">
                </div>
            </div>

            <div class="row espacoentre-inputs">
                <div class="col-md-6">
                    <label for="tipo" class="font-weight-normal">Tipo:</label>
                    <select class="form-control js-example-placeholder-single js-states select2" name="tipo">
                        <option disabled value="-" selected>-</option>
                        <?php foreach ($tiposProdutos as $tipo) { ?>
                            <option value="<?php print_r($tipo->id_prod_tipo_pk); ?>" <?php if ($tipo->id_prod_tipo_pk == $produto->fk_prod_tipo) {
                                                                                            echo "selected='selected'";
                                                                                        } ?>><?= $tipo->desc_tipo; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="datacompra" class="font-weight-normal">Data de compra:</label>
                    <input type="tel" name="datacompra" required class="datacompra form-control" onkeypress="return somenteNumeros(event)" value="<?= $produto->data_compra; ?>">
                </div>
            </div>

            <div class="row espacoentre-inputs">
                <div class="col-md-6">
                    <label for="preco" class="font-weight-normal">Valor unit??rio:</label>
                    <input type="tel" name="preco" class="form-control valor" onkeyup="formatarMoeda(this)" onkeypress="return somenteNumeros(event)" maxlength="14" value="<?= 'R$ ' . number_format($produto->valor_unitario, 2, ",", "."); ?>">
                </div>
                <div class="col-md-6">
                    <label for="qtdmin" class="font-weight-normal">Quantidade m??nima:</label>
                    <input type="tel" name="qtdmin" required class="form-control" maxlength="5" onkeypress="return somenteNumeros(event)" value="<?= $produto->qtd_min; ?>">
                </div>
            </div>

            <div class="row espacoentre-inputs">                
                <div class="col-md-6">
                    <label for="qtdmax" class="font-weight-normal">Quantidade m??xima:</label>
                    <input type="tel" name="qtdmax" required class="form-control" maxlength="5" onkeypress="return somenteNumeros(event)" value="<?= $produto->qtd_max; ?>">
                </div>
            </div>

            <div class="row">
                <div class="container botoesbottom conteudo">

                    <button type="submit" class="btn btn-primary width-btn">Editar</button>
                    <?php echo form_close(); ?>

                    <a href="<?= base_url('dashboard/consultar/produtos'); ?>" class="text-voltar btn btn-secondary btn-voltar width-btn"><span class="">Voltar</span></a>
                </div>
            </div>

        </div>
    </main>

</body>

<?php $this->load->view('footer') ?>

</html>