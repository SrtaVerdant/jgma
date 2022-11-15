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

            <?= form_open("dashboard/inserirFornecedor", 'id="formsubmit"'); ?>

            <div class="row espacoentre-inputs">
                <div class="dashboard">
                    <div class="row alinha-buttons">
                        <div class="col-md-3">
                            <label for="fornecedor" class="font-weight-normal">Nome:</label>
                            <input type="text" name="fornecedor" required class="form-control">
                        </div>
                    </div>
                    <div class="row alinha-buttons" style="margin-top: .5rem;">
                        <div class="col-md-3">
                            <label for="cnpj" class="font-weight-normal">CNPJ:</label>
                            <input type="tel" id="cnpj" name="cnpj" required class="cnpj form-control" onkeyup="formataCNPJ(this)" maxlength="18" onkeypress="return somenteNumeros(event)">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="container botoesbottom conteudo">

                    <button type="submit" id="inserir" class="btn btn-primary width-btn">Inserir</button>
                    <?php echo form_close(); ?>

                    <a href="<?= base_url('dashboard'); ?>" class="text-voltar btn btn-secondary btn-voltar width-btn"><span class="">Voltar</span></a>
                </div>
            </div>

        </div>
    </main>

</body>

<?php $this->load->view('footer') ?>

<script>
    inserir.disabled = true;    
</script>

</html>