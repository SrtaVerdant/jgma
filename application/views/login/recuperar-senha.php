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

		<main>	
			<div class="container conteudo" >

				<?= form_open("funcionarios/recuperar", 'id="formsubmit"'); ?>

				<div class="row">
					<div class="formulario">
						<div class="img-formulario">
							<img class="perfil" src="<?= base_url('assets/img/perfil-jgma.jpg')?>" alt="Foto do Perfil">
						</div>

						<div class="form form-group">
							<label for="cpf" class="form-label">Digite seu CPF</label>
							<input class="form-control" type="text" name="cpf" id="cpf" autocomplete="off" required onkeypress="return somenteNumeros(event)">
						</div>

						<div class="form form-group" style="margin-top: 3rem">
							<button type="submit" class="btn btn-primary" value="Recuperar">Recuperar</button>
						</div>					
						
					</div>
				</div>

				<?php echo form_close(); ?>

				<div class="form form-group">
					<a href="<?= base_url(''); ?>" style="color: #fff;"><button class="btn btn-secondary btn-voltar" value="Voltar">Voltar</button></a>
				</div>

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

		<!-- Modal -->
		<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="staticBackdropLabel">Recuperação de dados</h5>
						<i class="icons-padrao fa fa-times" aria-hidden="true" data-bs-dismiss="modal" aria-label="Close" style="font-size: 30px;"></i>
					</div>
					<div class="modal-body">
						<form>
							<div class="row">
								<div class="col-12 col-sm-12 mb-3">
									<span id="mostrafuncional">Sua Funcional: </span>
								</div>
							</div>
							<div class="row">
								<div class="col-10 col-sm-10 mb-3">
									<span id="mostrasenha">Sua senha: ******</span>
								</div>
								<div class="col-2 col-sm-2">
									<a href="#" onclick="mostraSenha()"><i class="fa fa-eye" id="text"></i></a>
									<a href="#" onclick="mostraSenha()"><i class="fa fa-eye-slash" id="pass" style="display: none;"></i></a>
								</div>
							</div>					
						</form>
					</div>
				</div>
			</div>
		</div>
		
	</body>		

	<?php $this->load->view('footer') ?>

	<script src="<?php echo base_url('assets/js/functions.js')?>"></script>

	<script>
		function ativaToast(msg, tempo) {
			document.getElementById('message').innerHTML = msg;
			const toastLiveExample = document.getElementById('liveToast');
			const toast = new bootstrap.Toast(toastLiveExample, {
				animation: true,
				autohide: true,
				delay: 5000,
			});
			toast.show();
		}

		var cpf = JSON.parse('<?= json_encode($this->session->userdata('recuperacpf')); ?>');
		
		if (cpf == 'erro') {
			ativaToast('CPF inválido! Digite novamente.', 4000);
		}

		if (cpf == 'ok') {
			var funcional = JSON.parse('<?= json_encode($this->session->userdata('funcional')); ?>');
			var senha = JSON.parse('<?= json_encode($this->session->userdata('senha')); ?>');
			document.getElementById('mostrafuncional').innerHTML = 'Sua funcional: ' + funcional;

			var myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'), {
			keyboard: false
			})
			var modalToggle = document.getElementById('staticBackdrop');
			myModal.show(modalToggle)

		}

		var visibilidade = true; 

		function mostraSenha() {
			
			if (visibilidade) {
				document.getElementById("mostrasenha").innerHTML = 'Sua senha: ' + senha;
				document.getElementById("text").style.display = 'none';
				document.getElementById("pass").style.display = 'block';
				visibilidade = false;
			} else {
				document.getElementById("text").style.display = 'block';
				document.getElementById("pass").style.display = 'none';
				
				document.getElementById("mostrasenha").innerHTML = 'Sua senha: *******';
				visibilidade = true;
			}
			
		}
		
	</script>



</html>
