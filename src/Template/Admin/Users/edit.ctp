<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $user->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Feed Comments'), ['controller' => 'FeedComments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Feed Comment'), ['controller' => 'FeedComments', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Feed Dislikes'), ['controller' => 'FeedDislikes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Feed Dislike'), ['controller' => 'FeedDislikes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Feed Likes'), ['controller' => 'FeedLikes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Feed Like'), ['controller' => 'FeedLikes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Transactions'), ['controller' => 'Transactions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Transaction'), ['controller' => 'Transactions', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Edit User') ?></legend>
        <?php
            echo $this->Form->control('email');
            echo $this->Form->control('password');
            echo $this->Form->control('contact_no');
            echo $this->Form->control('first_name');
            echo $this->Form->control('last_name');
            echo $this->Form->control('street_name');
            echo $this->Form->control('barangay');
            echo $this->Form->control('city');
            echo $this->Form->control('country');
            echo $this->Form->control('is_admin');
            echo $this->Form->control('is_active');
            echo $this->Form->control('verification_token');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
