<!doctype html>
<html lang="pt-br">
	<head>
		<title></title>
	</head>

	

	<header>
		<nav class="navbar navbar-expand-lg">
			<div class="container-fluid">
				<img class="logo-jgma" src="<?= base_url('assets/img/logo-jgma.png')?>" alt="Logo JGMA">
				<?php if ($this->session->userdata('login') == 'ok') { ?>
					<?php 
						$nome = $this->session->userdata('nome');
						$nome = explode(' ', $nome);
						$nome = $nome[0];
					?>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav me-auto mb-2 mb-lg-0">
						
					</ul>
					<div class="info-user">
						<span class="mostra-info">Funcionario: <span class="info-normal"><?php print_r($nome); ?></span></br>Funcional: <span class="info-normal"><?php print_r($this->session->userdata('funcional')); ?></span></span>
						<a href="<?= 'logout'; ?>" style="margin-left: 3rem;" class="btn btn-secondary">Sair</a>
					</div>
				</div>
				<?php } ?>
			</div>
		</nav>
	</header>

	<div class="row-purple">

	</div>

	

</html>
