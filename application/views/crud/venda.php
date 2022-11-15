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
            <?= form_open("dashboard/inserirVenda", 'id="formsubmit"'); ?>

            <div class="row espacoentre-inputs">
                <div class="dashboard">
                    <div class="row alinha-buttons ">
                        <div class="col-md-12 card-venda">
                            <div class="card" style="width: 30rem;">
                                <div class="card-body" style="text-align: center;">
                                    <h5 class="card-title">Produto: <?= $produto->nome; ?> </h5>
                                    <p class="card-text">Este lote vence: <?= $produto->prazo_validade; ?></p>
                                    <p class="card-text">Quantidade do lote: <?= $produto->quantidade; ?></p>
                                    <p class="card-text">Quantidade que será vendida</p>
                                    <input type="tel" id="qtdvendas" name="qtdvendas" required class="form-control" onkeyup="verificaQtd(this.value)" maxlength="10" onkeypress="return somenteNumeros(event)">
                                    <div id="alerta" class="alert alert-danger  align-items-center mt-3" style="display:none;">
                                        
                                        <div>
                                            A quantidade informada ultrapassou o lote!
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="container botoesbottom conteudo">

                    <button type="submit" id="vendas" class="btn btn-primary width-btn">Inserir Venda</button>
                    <?php echo form_close(); ?>

                    <a href="<?= base_url('dashboard/consultar/produtos'); ?>" class="text-voltar btn btn-secondary btn-voltar width-btn"><span class="">Voltar</span></a>
                </div>
            </div>

        </div>
    </main>

</body>

<?php $this->load->view('footer') ?>

<script>
    var qtd_produto_tabela = JSON.parse('<?= json_encode($produto->quantidade); ?>');
    const alerta = document.getElementById('alerta');
    vendas.disabled = true; 
    
    function verificaQtd(qtd) {
        const vendas = document.getElementById('vendas');
           
        
        if (Number(qtd) > Number(qtd_produto_tabela)) {
            alerta.style.display = "block";
            vendas.disabled = true; 
        } else {
            alerta.style.display = "none";
            vendas.disabled = false; 
        }
    }
</script>

</html>