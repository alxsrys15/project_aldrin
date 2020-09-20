<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Transaction[]|\Cake\Collection\CollectionInterface $transactions
 */
?>
<div class="transactions index large-9 medium-8 columns content">
    <h3><?= __('Transactions') ?></h3>
    <table cellpadding="0" cellspacing="0" class="table">
        <thead>
            <tr>
                <th scope="col">User</th>
                <th scope="col">Total</th>
                <th scope="col">Status</th>
                <th scope="col">Payment Type</th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td><?= $transaction->user->first_name ?> <?= $transaction->user->last_name ?></td>
                <td>P <?= $this->Number->format($transaction->total_price) ?></td>
                <td><?= $transaction->status->name ?></td>
                <td><?= $transaction->transaction_type->name ?></td>
                <td class="actions">
                    <div class="dropdown">
                        <?= $this->Html->link('<i class="fa fa-eye" aria-hidden="true"></i>', ['prefix' => 'admin', 'controller' => 'Transactions', 'action' => 'view', $transaction->id], ['class' => 'btn btn-sm', 'escape' => false]) ?>
                        <button class="btn btn-sm <?= $transaction->status_id === 4 ? "disabled" : "" ?>" data-toggle="dropdown"><i class="fa fa-edit" aria-hidden="true"></i></button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <?php foreach ($statuses as $status): ?>
                            <?= $this->Html->link($status->name, ['prefix' => 'admin', 'controller' => 'Transactions', 'action' => 'changeStatus', $status->id, $transaction->id], ['class' => 'dropdown-item']) ?>
                            <?php endforeach ?>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
