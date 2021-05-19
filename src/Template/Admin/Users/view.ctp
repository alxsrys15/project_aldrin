<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Feed Comments'), ['controller' => 'FeedComments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Feed Comment'), ['controller' => 'FeedComments', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Feed Dislikes'), ['controller' => 'FeedDislikes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Feed Dislike'), ['controller' => 'FeedDislikes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Feed Likes'), ['controller' => 'FeedLikes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Feed Like'), ['controller' => 'FeedLikes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Transactions'), ['controller' => 'Transactions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Transaction'), ['controller' => 'Transactions', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Contact No') ?></th>
            <td><?= h($user->contact_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('First Name') ?></th>
            <td><?= h($user->first_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Last Name') ?></th>
            <td><?= h($user->last_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Street Name') ?></th>
            <td><?= h($user->street_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Barangay') ?></th>
            <td><?= h($user->barangay) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= h($user->city) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Country') ?></th>
            <td><?= h($user->country) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Verification Token') ?></th>
            <td><?= h($user->verification_token) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Admin') ?></th>
            <td><?= $this->Number->format($user->is_admin) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Active') ?></th>
            <td><?= $this->Number->format($user->is_active) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Feed Comments') ?></h4>
        <?php if (!empty($user->feed_comments)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Feed Id') ?></th>
                <th scope="col"><?= __('Comment') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->feed_comments as $feedComments): ?>
            <tr>
                <td><?= h($feedComments->id) ?></td>
                <td><?= h($feedComments->user_id) ?></td>
                <td><?= h($feedComments->feed_id) ?></td>
                <td><?= h($feedComments->comment) ?></td>
                <td><?= h($feedComments->created) ?></td>
                <td><?= h($feedComments->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'FeedComments', 'action' => 'view', $feedComments->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'FeedComments', 'action' => 'edit', $feedComments->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'FeedComments', 'action' => 'delete', $feedComments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $feedComments->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Feed Dislikes') ?></h4>
        <?php if (!empty($user->feed_dislikes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Feed Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->feed_dislikes as $feedDislikes): ?>
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
        <?php if (!empty($user->feed_likes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Feed Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->feed_likes as $feedLikes): ?>
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
    <div class="related">
        <h4><?= __('Related Transactions') ?></h4>
        <?php if (!empty($user->transactions)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Total Price') ?></th>
                <th scope="col"><?= __('Shipping Fee') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Status Id') ?></th>
                <th scope="col"><?= __('Transaction Type Id') ?></th>
                <th scope="col"><?= __('Paypal Token') ?></th>
                <th scope="col"><?= __('Payment Image') ?></th>
                <th scope="col"><?= __('Street') ?></th>
                <th scope="col"><?= __('Barangay') ?></th>
                <th scope="col"><?= __('City') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->transactions as $transactions): ?>
            <tr>
                <td><?= h($transactions->id) ?></td>
                <td><?= h($transactions->user_id) ?></td>
                <td><?= h($transactions->total_price) ?></td>
                <td><?= h($transactions->shipping_fee) ?></td>
                <td><?= h($transactions->created) ?></td>
                <td><?= h($transactions->modified) ?></td>
                <td><?= h($transactions->status_id) ?></td>
                <td><?= h($transactions->transaction_type_id) ?></td>
                <td><?= h($transactions->paypal_token) ?></td>
                <td><?= h($transactions->payment_image) ?></td>
                <td><?= h($transactions->street) ?></td>
                <td><?= h($transactions->barangay) ?></td>
                <td><?= h($transactions->city) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Transactions', 'action' => 'view', $transactions->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Transactions', 'action' => 'edit', $transactions->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Transactions', 'action' => 'delete', $transactions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transactions->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
