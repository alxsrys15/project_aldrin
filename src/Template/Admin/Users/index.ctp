<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */



?>
<?= $this->Html->link('Add admin', ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'add'], ['class' => 'btn btn-dark mb-3']) ?>
<div class="users index large-9 medium-8 columns content">
    <h3><?= __('Administrators') ?></h3>
    <table cellpadding="0" cellspacing="0" class="table">
        <thead>
            <tr>
                <th scope="col">Email</th>
                <th scope="col">Contact No.</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col" class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= h($user->email) ?></td>
                <td><?= h($user->contact_no) ?></td>
                <td><?= h($user->first_name) ?></td>
                <td><?= h($user->last_name) ?></td>
                <td class="actions">
                    <?php if ($user->is_active): ?>
                    <?= $this->Html->link('<i class="fa fa-trash"> Deactivate</i>', ['action' => 'changeStatus', 0, $user->id], ['class' => 'btn btn-danger btn-sm', 'escape' => false]) ?>
                    <?php else: ?>
                    <?= $this->Html->link('<i class="fa fa-plus"> Activate</i>', ['action' => 'changeStatus', 1, $user->id], ['escape' => false, 'class' => 'btn btn-success btn-sm']) ?>
                    <?php endif ?>
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
