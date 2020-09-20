<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product[]|\Cake\Collection\CollectionInterface $products
 */
?>
<?= $this->Html->link('Add Product', ['prefix' => 'admin', 'controller' => 'Products', 'action' => 'add'], ['class' => 'btn btn-dark mb-3']) ?>
<div class="products index large-9 medium-8 columns content">
    <h3><?= __('Products') ?></h3>
    <table cellpadding="0" cellspacing="0" class="table">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?= h($product->name) ?></td>
                <td><?= h($product->description) ?></td>
                <td>P <?= number_format($product->price, 2) ?></td>
                <td class="actions">
                    <!-- <a class="btn"><i class="fa fa-edit" aria-hidden="true"></i></a> -->
                    <?= $this->Html->link('<i class="fa fa-edit" aria-hidden="true"></i>', ['prefix' => 'admin', 'controller' => 'Products', 'action' => 'edit', $product->id], ['class' => 'btn btn-sm', 'escape' => false]) ?>
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
