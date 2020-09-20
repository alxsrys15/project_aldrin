<div class="container">
	<h4>Welcome to NAME NG BENEF.</h4>
	<p>
		Please click this link to verify your account.
	</p>
	<p>
		<?= $this->Html->link('Link', $this->Url->build(['controller' => 'Users', 'action' => 'login', '?' => ['user' => $user->verification_token]], true)) ?>
	</p>
</div>