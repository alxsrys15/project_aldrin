<div class="container">
	<h4>Welcome to LOUKHA CLOTHING</h4>
	<p>
		Please click this link to verify your account.
	</p>
	<p>
		<?= $this->Html->link('Link', $this->Url->build(['controller' => 'Users', 'action' => 'login', '?' => ['user' => $user->verification_token]], true)) ?>
	</p>
</div>