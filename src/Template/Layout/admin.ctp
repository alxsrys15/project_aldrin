<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'Loukha Clothing';
$controller = strtolower($this->request->params['controller']);
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" integrity="sha384-KA6wR/X5RY4zFAHpv/CnoG2UW1uogYfdnP67Uv7eULvTveboZJg0qUpmJZb5VqzN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark bg-dark topbar mb-4 static-top shadow">
    	<a href="#!" class="navbar-brand">LOUKHA</a>
	    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
	        <i class="fa fa-bars"></i>
	    </button>
	    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    		<ul class="navbar-nav">
    			<li class="nav-item dropdown <?= $controller == "products" ? "active" : "" ?>">
        			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          				Products
        			</a>
        			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          				<?= $this->Html->link('Product List', '/admin', ['class' => 'dropdown-item']) ?>
          				<?= $this->Html->link('Categories', ['prefix' => 'admin', 'controller' => 'Categories', 'action' => 'index'], ['class' => 'dropdown-item']) ?>
        			</div>
      			</li>
                <li class="nav-item <?= $controller == "users" ? "active" : "" ?>">
                    <?= $this->Html->link('Users', ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'index'], ['class' => 'nav-link']) ?>
                </li>
      			<li class="nav-item <?= $controller == "transactions" ? "active" : "" ?>">
                    <?= $this->Html->link('Transactions', ['prefix' => 'admin', 'controller' => 'Transactions', 'action' => 'index'], ['class' => 'nav-link']) ?>
      			</li>
      			<li class="nav-item <?= $controller == "feeds" ? "active" : "" ?>">
        			<?= $this->Html->link('Feeds', ['prefix' => 'admin', 'controller' => 'Feeds', 'action' => 'index'], ['class' => 'nav-link']) ?>
      			</li>
      			<li class="nav-item <?= $controller == "dashboards" ? "active" : "" ?>">
        			<?= $this->Html->link('Dashboards', ['prefix' => 'admin', 'controller' => 'Dashboards', 'action' => 'index'], ['class' => 'nav-link']) ?>
      			</li>
    		</ul>
  		</div>
	    <ul class="navbar-nav ml-auto">
	        <li class="nav-item dropdown no-arrow">
	            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
	                    <?= $this->request->session()->read('Auth.User.first_name') . ' ' .$this->request->session()->read('Auth.User.last_name') ?>
	                </span>
	            </a>
	            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a href="#" class="dropdown-item" data-toggle="modal" data-target="#change-pass-modal">
                        <i class="fa fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Change Password
                    </a>
	                <?= $this->Html->link('<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout', ['prefix' => false,'controller' => 'Users', 'action' => 'logout'], ['escape' => false, 'class' => 'dropdown-item']) ?>
	            </div>
	        </li>
	    </ul>
	</nav>
    <?= $this->Flash->render() ?>
    <div class="container">
        <nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item" aria-current="page">
					<?php if ($this->request->params['action'] !== "index"): ?>
					<?= $this->Html->link($this->request->params['controller'], ['prefix' => 'admin', 'controller' => $this->request->params['controller'], 'action' => 'index']) ?>
					<?php else: ?>
					<?= $this->request->params['controller'] ?>
					<?php endif ?>
				</li>
				<?php if ($this->request->params['action'] !== "index"): ?>
				<li class="breadcrumb-item" aria-current="page" style="text-transform: capitalize;"><?= $this->request->params['action'] ?></li>
				<?php endif ?>
			</ol>
			
		</nav>
        <?= $this->fetch('content') ?>
    </div>
    <div class="modal fade" id="change-pass-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Password</h5>
                </div>
                <div class="modal-body">
                    <?= $this->Form->create(null, ['url' => ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'changePassword'], 'id' => 'change-pass-form']) ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="curr_pass" class="col-form-label">Current Password</label>
                                <?= $this->Form->input('curr_password', ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'label' => false, 'type' => 'password']) ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="new_pass" class="col-form-label">New Password</label>
                                <?= $this->Form->input('new_pass', ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'label' => false, 'type' => 'password']) ?>
                            </div>
                            <div class="invalid-feedback validation-helper" style="display: none">
                                Password do not match.
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="con_new_pass" class="col-form-label">Confirm New Password</label>
                                <?= $this->Form->input('con_new_pass', ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'label' => false, 'type' => 'password']) ?>
                            </div>
                            <div class="invalid-feedback validation-helper" style="display: none">
                                Password do not match.
                            </div>
                        </div>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="change-pass-form">Save</button>
                </div>
            </div>
        </div>
    </div>
    <footer>
    </footer>
</body>
<script type="text/javascript">
    var url = '<?= $this->Url->build('/', true); ?>';
    var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
    $(document).ready(function () {
        $('#change-pass-form').on('submit', function () {
            const password = $('#new-pass').val();
            const password2 = $('#con-new-pass').val();
            if (password !== password2) {
                $('#new-pass, #con-new-pass').addClass('is-invalid');
                $('.validation-helper').show();
                return false;
            }
        });

        $('#change-pass-modal').on('hide.bs.modal', function () {
            $('#new-pass, #con-new-pass').removeClass('is-invalid');
            $('#new-pass, #con-new-pass, #curr-password').val('');
            $('.validation-helper').hide();
        });
    });
</script>
</html>
