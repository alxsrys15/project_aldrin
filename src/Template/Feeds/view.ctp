<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Feed $feed
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Feed'), ['action' => 'edit', $feed->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Feed'), ['action' => 'delete', $feed->id], ['confirm' => __('Are you sure you want to delete # {0}?', $feed->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Feeds'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Feed'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Feed Dislikes'), ['controller' => 'FeedDislikes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Feed Dislike'), ['controller' => 'FeedDislikes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Feed Likes'), ['controller' => 'FeedLikes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Feed Like'), ['controller' => 'FeedLikes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="feeds view large-9 medium-8 columns content">
    <h3><?= h($feed->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($feed->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Img Name') ?></th>
            <td><?= h($feed->img_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Img Ext') ?></th>
            <td><?= h($feed->img_ext) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($feed->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($feed->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($feed->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Feed Dislikes') ?></h4>
        <?php if (!empty($feed->feed_dislikes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Feed Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($feed->feed_dislikes as $feedDislikes): ?>
            <tr>
                <td><?= h($feedDislikes->id) ?></td>
                <td><?= h($feedDislikes->feed_id) ?></td>
                <td><?= h($feedDislikes->user_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'FeedDislikes', 'action' => 'view', $feedDislikes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'FeedDislikes', 'action' => 'edit', $feedDislikes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'FeedDislikes', 'action' => 'delete', $feedDislikes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $feedDislikes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Feed Likes') ?></h4>
        <?php if (!empty($feed->feed_likes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Feed Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($feed->feed_likes as $feedLikes): ?>
            <tr>
                <td><?= h($feedLikes->id) ?></td>
                <td><?= h($feedLikes->feed_id) ?></td>
                <td><?= h($feedLikes->user_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'FeedLikes', 'action' => 'view', $feedLikes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'FeedLikes', 'action' => 'edit', $feedLikes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'FeedLikes', 'action' => 'delete', $feedLikes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $feedLikes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
