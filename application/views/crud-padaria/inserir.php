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

        <div class="container ">

            <?= form_open("dashboard/inserirProdutoPadaria", 'id="formsubmit"'); ?>

            
            <div class="row">
                <div class="mt-3">
                    <div class="row alinha-buttons">
                        <div class="col-md-3">
                            <label for="produto" class="font-weight-normal">Nome:</label>
                            <input type="text" name="produto" required class="form-control">
                        </div>
                    </div>
                    <div class="row alinha-buttons mt-2">
                        <div class="col-md-3">
                            <label for="quantidade" class="font-weight-normal">Quantidade:</label>
                            <input type="tel" name="quantidade" required class="form-control" maxlength="5" onkeypress="return somenteNumeros(event)">
                        </div>
                    </div>
                    <div class="row alinha-buttons mt-2">
                        <div class="col-md-3">
                            <label for="preco" class="font-weight-normal">Valor unitário:</label>
                            <input type="tel" name="preco" class="form-control valor" onkeyup="formatarMoeda(this)" onkeypress="return somenteNumeros(event)" maxlength="14" value="R$ 0,00">
                        </div>
                    </div>
                    <div class="row alinha-buttons mt-2">
                        <div class="col-md-3">
                            <label for="validade" class="font-weight-normal">Prazo de validade:</label>
                            <input type="tel" id="validade" name="validade" required class="datavalidadepadaria form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="container botoesbottom conteudo">

                    <button type="submit" class="btn btn-primary width-btn">Inserir</button>
                    <?php echo form_close(); ?>

                    <a href="<?= base_url('dashboard'); ?>" class="text-voltar btn btn-secondary btn-voltar width-btn"><span class="">Voltar</span></a>
                </div>
            </div>
        </div>
    </main>

</body>

<?php $this->load->view('footer') ?>


<script>

</script>

</html>