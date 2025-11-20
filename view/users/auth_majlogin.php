<div class="d-flex justify-content-center h-100">
	<div class="card">
		<div class="card-header">
			<h3>Se connecter</h3>
			<div class="d-flex justify-content-center" style="color: white;"><?php echo $this->Session->flash(); ?></div>   
		</div>
		<div class="card-body">
			<form action="<?php echo Router::url('users/auth_majlogin'); ?>" method="post">
				<div class="input-group form-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fas fa-user"></i></span>
					</div>
					<?php echo $this->Form->input('login', 'identifiant', array('type'=>'input-class'), 'input-class'); ?>
				</div>
				<div class="form-group">
					<input type="submit" class="btn float-right login_btn" value="Mise à jour">
				</div>
			</form>	
		</div>
		<div class="card-footer">
			<div class="d-flex justify-content-center">
				<a href="<?php echo Router::url('users/auth_login'); ?>">Se connecter</a>
			</div>
		</div>
	</div>
</div>