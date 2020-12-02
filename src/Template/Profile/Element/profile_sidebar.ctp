<?php
$controller = $this->request->params['controller'];
$action = $this->request->params['action'];
?>

<style type="text/css">
	.list-group-item.active {
		z-index: 2;
		color: #fff;
		background-color: #343a40!important;
		border-color: #343a40!important;
	}
</style>

<div class="list-group">
    <?= $this->Html->link('My Profile', '/profile', ['class' => $controller === "Users" && $action === "index" ? 'list-group-item list-group-item-action active' : 'list-group-item list-group-item-action']) ?>
    <?= $this->Html->link('My Orders', ['controller' => 'Transactions'], ['class' => $controller === "Transactions" && $action === "index" ? 'list-group-item list-group-item-action active' : 'list-group-item list-group-item-action']) ?>
</div>