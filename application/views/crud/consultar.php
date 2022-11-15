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
            <div class="row" style="margin-top: 15px;">
                <div class="col-md-12">
                    <div class="table-responsive" style="padding-top: 15px; padding-bottom: 15px;">
                        <table id="example" class="table display tableprodutos" style="width:100%">
                            <thead style="margin-top: 15px;">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Fornecedor</th>
                                    <th scope="col">Valor unitário</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Qtd</th>
                                    <th scope="col">Prazo de validade</th>
                                    <th scope="col">Data de compra</th>
                                    <th scope="col" class="padding-actions">Ações</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="container botoesbottom conteudo">
                    <a></a>
                    <a href="<?= base_url('dashboard'); ?>" class="text-voltar btn btn-secondary btn-voltar width-btn">Voltar</a>
                </div>
            </div>

        </div>
    </main>

    <div class="toast-container text-white position-fixed top-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="message">

                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

</body>

<?php $this->load->view('footer') ?>

<script>
    var table = $('#example').DataTable({
        "paging": true,
        "info": true,
        "processing": true,
        "serverSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json"
        },
        "ajax": "<?= base_url() . 'dashboard/produtos'; ?>"

    });
</script>

<script>
    function ativaToast(msg, tempo, tipoToast) {
        document.getElementById('message').innerHTML = msg;
        const toastLiveExample = document.getElementById('liveToast');
        $('#liveToast').toggleClass(tipoToast);
        const toast = new bootstrap.Toast(toastLiveExample, {
            animation: true,
            autohide: true,
            delay: tempo,
        });
        toast.show();
    }

    var editar = JSON.parse('<?= json_encode($this->session->userdata('editar')); ?>');
    switch (editar) {
        case 'erro':
            ativaToast('Não foi possível editar o produto!', 4000, 'bg-danger');
            break;

        case 'ok':
            ativaToast('Produto editado com sucesso!', 4000, 'bg-success');
            break;

        default:
            break;
    }

    var excluir = JSON.parse('<?= json_encode($this->session->userdata('excluir')); ?>');
    if (excluir == 'ok') {
        ativaToast('Produto excluído com sucesso!', 4000, 'bg-success');
    }
</script>

<?php $this->session->set_userdata('editar', ''); ?>
<?php $this->session->set_userdata('excluir', ''); ?>

</html>