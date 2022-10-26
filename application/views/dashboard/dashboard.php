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
							<a href="<?= base_url('dashboard/inserir') ?>"><button class="btn btn-primary">Inserir produto</button></a>
						</div>
					</div>
					<div class="row alinha-buttons">
						<div class="col-md-3">
						<a href="<?= base_url('dashboard/consultar') ?>"><button class="btn btn-primary">Consultar Produtos</button></a>
						</div>								
					</div>
					<div class="row alinha-buttons" id="oculta-btn">							
						<div class="col-md-3">
						<a href="<?= base_url('dashboard/relatorio') ?>"><button class="btn btn-primary">Relatório de Produtos</button></a>
						</div>
					</div>			
				</div>
			</div>
		</main>
	</body>

	<?php $this->load->view('footer') ?>

	<script>
		var cargo = JSON.parse('<?= json_encode($this->session->userdata('cargo')); ?>');

		console.log(cargo);

		if (cargo > 2) {
			document.getElementById('oculta-btn').style.display = 'none';
		}
	</script>

</html>
