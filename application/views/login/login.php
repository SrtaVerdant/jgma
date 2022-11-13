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

	<?php $this->load->view('topandsidebar') ?>

	<?php if (!empty($this->session->userdata('recuperacpf'))) {
		$this->session->set_userdata('recuperacpf', '');
	} ?>

	<main>

		<div class="container conteudo">

			<?= form_open("funcionarios/login", 'id="formsubmit"'); ?>

			<div class="row">
				<div class="formulario">

					<div class="img-formulario">
						<img class="perfil" src="<?= base_url('assets/img/perfil-jgma.jpg') ?>" alt="Foto do Perfil">
					</div>

					<div class="form form-group">
						<label for="funcional" class="form-label">Funcional</label>
						<input class="form-control" type="tel" name="funcional" id="funcional" required>
					</div>

					<div class="form form-group">
						<label for="senha" class="form-label">Senha</label>
						<input class="form-control" type="password" name="senha" id="senha" required>
					</div>

					<div class="col-md-12 link">
						<a href="<?= base_url('recuperar-senha') ?>">Esqueci minha senha</a>
					</div>

					<div class="form form-group">
						<button type="submit" class="btn btn-primary" id="login" value="Login">Login</button>
					</div>

				</div>
			</div>

			<?php echo form_close(); ?>

		</div>

	</main>

	<div class="toast-container text-white position-fixed top-0 end-0 p-3">
		<div id="liveToast" class="toast bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
			<div class="d-flex">
				<div class="toast-body" id="message">

				</div>
				<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>
		</div>
	</div>

</body>

<?php $this->load->view('footer') ?>

<script src="<?php echo base_url('assets/js/functions.js') ?>"></script>

<script>
	function ativaToast(msg, tempo) {
		document.getElementById('message').innerHTML = msg;
		const toastLiveExample = document.getElementById('liveToast');
		const toast = new bootstrap.Toast(toastLiveExample, {
			animation: true,
			autohide: true,
			delay: tempo,
		});
		toast.show();
	}

	var login = JSON.parse('<?= json_encode($this->session->userdata('login')); ?>');
	if (login == 'erro') {
		ativaToast('Usuário e/ ou senha inválidos!!', 4000);

	}
</script>

<script>
	var tentativas = JSON.parse('<?= json_encode($this->session->userdata('tentativasLog')); ?>');
	if (tentativas >= 3) {
		let button = document.getElementById('login');
		button.disabled = true;
		ativaToast('Quantidade máxima de tentativas inválidas de login, clique em "Esqueci minha senha"', 5000);
	}
</script>

<script>
	var cpf = JSON.parse('<?= json_encode($this->session->userdata('recuperacpf')); ?>');
	if (cpf == 'ok') {
		let button = document.getElementById('login');
		button.disabled = false;
	}
</script>

</html>