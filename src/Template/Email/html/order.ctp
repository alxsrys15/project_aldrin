<div class="container">
	<h4>Your order has been placed.</h4>
	<p>
		Please click this link to track the details of your order
	</p>
	<p>
		<?= $this->Html->link('Link', $this->Url->build(['prefix' => 'shop','controller' => 'Products', 'action' => 'orderTracker', '?' => ['token' => $transaction->paypal_token]], true)) ?>
	</p>
</div>