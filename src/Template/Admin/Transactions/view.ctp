<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Transaction $transaction
 */
?>
<div class="transactions view large-9 medium-8 columns content">
    <h3><?= h($transaction->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $transaction->has('user') ? $this->Html->link($transaction->user->id, ['controller' => 'Users', 'action' => 'view', $transaction->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $transaction->has('status') ? $this->Html->link($transaction->status->name, ['controller' => 'Statuses', 'action' => 'view', $transaction->status->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transaction Type') ?></th>
            <td><?= $transaction->has('transaction_type') ? $this->Html->link($transaction->transaction_type->name, ['controller' => 'TransactionTypes', 'action' => 'view', $transaction->transaction_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Paypal Token') ?></th>
            <td><?= h($transaction->paypal_token) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payment Image') ?></th>
            <td><?= h($transaction->payment_image) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Street') ?></th>
            <td><?= h($transaction->street) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Barangay') ?></th>
            <td><?= h($transaction->barangay) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= h($transaction->city) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($transaction->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Price') ?></th>
            <td><?= $this->Number->format($transaction->total_price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Shipping Fee') ?></th>
            <td><?= $this->Number->format($transaction->shipping_fee) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($transaction->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($transaction->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Transaction Details') ?></h4>
        <?php if (!empty($transaction->transaction_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Product Id') ?></th>
                <th scope="col"><?= __('Product Stocks Id') ?></th>
                <th scope="col"><?= __('Total Qty') ?></th>
                <th scope="col"><?= __('Transaction Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($transaction->transaction_details as $transactionDetails): ?>
            <tr>
                <td><?= h($transactionDetails->id) ?></td>
                <td><?= h($transactionDetails->product_id) ?></td>
                <td><?= h($transactionDetails->product_stocks_id) ?></td>
                <td><?= h($transactionDetails->total_qty) ?></td>
                <td><?= h($transactionDetails->transaction_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'TransactionDetails', 'action' => 'view', $transactionDetails->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'TransactionDetails', 'action' => 'edit', $transactionDetails->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'TransactionDetails', 'action' => 'delete', $transactionDetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transactionDetails->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
