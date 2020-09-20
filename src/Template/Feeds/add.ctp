<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Feed $feed
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Feeds'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Feed Dislikes'), ['controller' => 'FeedDislikes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Feed Dislike'), ['controller' => 'FeedDislikes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Feed Likes'), ['controller' => 'FeedLikes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Feed Like'), ['controller' => 'FeedLikes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="feeds form large-9 medium-8 columns content">
    <?= $this->Form->create($feed) ?>
    <fieldset>
        <legend><?= __('Add Feed') ?></legend>
        <?php
            echo $this->Form->control('description');
            echo $this->Form->control('img_name');
            echo $this->Form->control('img_ext');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
