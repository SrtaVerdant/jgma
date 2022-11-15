<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!doctype html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<title><?php print_r($titulo); ?></title>

	<?php $this->load->view('header') ?>
</head>

<body>
	<main>
		<?php $this->load->view('topandsidebar') ?>

		<div class="container conteudo">
			<div class="dashboard">
				<div class="row alinha-buttons">
					<div class="col-md-3">
						<a href="<?= base_url('dashboard/inserir') ?>"><button class="btn btn-primary">Inserir Produto</button></a>
					</div>
					<div class="col-md-3">
						<a href="<?= base_url('dashboard/fornecedor/inserir') ?>"><button class="btn btn-primary">Inserir Fornecedor</button></a>
					</div>
				</div>
				<div class="row alinha-buttons">
					<div class="col-md-3">
						<a href="<?= base_url('dashboard/consultar/produtos') ?>"><button class="btn btn-primary">Consultar Produtos</button></a>
					</div>
					<div class="col-md-3">
						<a href="<?= base_url('dashboard/fornecedor/consultar') ?>"><button class="btn btn-primary">Consultar Fornecedores</button></a>
					</div>
				</div>
				<div class="row alinha-buttons">	
					<div class="col-md-3">
						<a href="<?= base_url('dashboard/relatorio') ?>"><button class="btn btn-primary">Inserir Item de Padaria</button></a>
					</div>				
					<div class="col-md-3">
						<a href="<?= base_url('dashboard/relatorio') ?>"><button class="btn btn-primary">Relatório de Produtos</button></a>
					</div>
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
	//Fazer validação de cargo
	var cargo = JSON.parse('<?= json_encode($this->session->userdata('cargo')); ?>');
	if (cargo > 2) {
		document.getElementById('oculta-btn').style.display = 'none';
	}
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

	var inserir = JSON.parse('<?= json_encode($this->session->userdata('inserir')); ?>');
	switch (inserir) {
		case 'erro':
			ativaToast('Não foi possível adicionar o produto!', 4000, 'bg-danger');
			break;

		case 'ok':
			ativaToast('Produto adicionado com sucesso!', 4000, 'bg-success');
			break;

		default:
			break;
	}

	var inserir_fornecedor = JSON.parse('<?= json_encode($this->session->userdata('inserir_fornecedor')); ?>');
	switch (inserir_fornecedor) {
		case 'erro':
			ativaToast('Não foi possível adicionar o fornecedor!', 4000, 'bg-danger');
			break;

		case 'ok':
			ativaToast('Fornecedor adicionado com sucesso!', 4000, 'bg-success');
			break;

		default:
			break;
	}
</script>

<?php $this->session->set_userdata('inserir', ''); ?>
<?php $this->session->set_userdata('inserir_fornecedor', ''); ?>

</html>