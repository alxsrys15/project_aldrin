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
    <?= $this->Html->css('bootstrap.min.css') ?>
    <?= $this->Html->script('jquery.min.js') ?> 
    <?= $this->Html->script('bootstrap.bundle.min.js') ?>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" integrity="sha384-KA6wR/X5RY4zFAHpv/CnoG2UW1uogYfdnP67Uv7eULvTveboZJg0qUpmJZb5VqzN" crossorigin="anonymous">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
    <?= $this->Html->script('https://cdn.jsdelivr.net/npm/sweetalert2@9') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark bg-dark topbar static-top shadow">
        <a href="/" class="navbar-brand">LOUKHA</a>
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/shop">Shop</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/feeds">Feed</span></a>
                </li>
            </ul>
        </div>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <?php if (!$this->request->session()->read('Auth.User.is_admin')): ?>
                <?= $this->Html->link('<span class="badge badge-danger rounded-circle position-absolute king-badger cart-badge"></span><i class="fa fa-shopping-cart"></i>', ['prefix' => 'shop', 'controller' => 'Products', 'action' => 'cart'], ['escape' => false, 'class' => 'btn btn-link nav-link']) ?>    
                <?php endif ?>
            </li>
            <?php if ($this->request->session()->read('Auth')): ?>
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                        <?= $this->request->session()->read('Auth.User.first_name') . ' ' .$this->request->session()->read('Auth.User.last_name') ?>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <?= $this->Html->link('<i class="fas fa-user-alt fa-sm fa-fw mr-2 text-gray-400"></i> Profile', '/profile', ['escape' => false, 'class' => 'dropdown-item']) ?>
                    <?= $this->Html->link('<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout', ['prefix' => false,'controller' => 'Users', 'action' => 'logout'], ['escape' => false, 'class' => 'dropdown-item']) ?>
                </div>
            </li>
            <?php else: ?>
            <li class="nav-item">
                <?= $this->Html->link('Login', ['prefix' => false, 'controller' => 'Users', 'action' => 'login'], ['class' => 'nav-link btn-outline-dark']) ?>
            </li>
            <?php endif ?>
            
        </ul>
    </nav>
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
    <footer>
    </footer>
    
</body>
<?= $this->Html->script('cart'); ?>

<script type="text/javascript">
    var url = '<?= $this->Url->build('/', true); ?>';
    var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
    function cartBadge () {
        var cartCounter = shoppingCart.listCart().length;
        $('.cart-badge').text(cartCounter);
    }
    $(document).ready(function () {
        cartBadge();
    });
</script>
<?= $this->fetch('script') ?>
</html>
