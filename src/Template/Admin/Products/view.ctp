<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Product'), ['action' => 'edit', $product->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Product'), ['action' => 'delete', $product->id], ['confirm' => __('Are you sure you want to delete # {0}?', $product->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Products'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Product'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Product Stocks'), ['controller' => 'ProductStocks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Product Stock'), ['controller' => 'ProductStocks', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Transaction Details'), ['controller' => 'TransactionDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Transaction Detail'), ['controller' => 'TransactionDetails', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="products view large-9 medium-8 columns content">
    <h3><?= h($product->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($product->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($product->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Category') ?></th>
            <td><?= $product->has('category') ? $this->Html->link($product->category->name, ['controller' => 'Categories', 'action' => 'view', $product->category->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($product->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Price') ?></th>
            <td><?= $this->Number->format($product->price) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Product Stocks') ?></h4>
        <?php if (!empty($product->product_stocks)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Product Id') ?></th>
                <th scope="col"><?= __('Size Id') ?></th>
                <th scope="col"><?= __('Variant') ?></th>
                <th scope="col"><?= __('Sku') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($product->product_stocks as $productStocks): ?>
            <tr>
                <td><?= h($productStocks->id) ?></td>
                <td><?= h($productStocks->product_id) ?></td>
                <td><?= h($productStocks->size_id) ?></td>
                <td><?= h($productStocks->variant) ?></td>
                <td><?= h($productStocks->sku) ?></td>
                <td><?= h($productStocks->created) ?></td>
                <td><?= h($productStocks->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ProductStocks', 'action' => 'view', $productStocks->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ProductStocks', 'action' => 'edit', $productStocks->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ProductStocks', 'action' => 'delete', $productStocks->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productStocks->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Transaction Details') ?></h4>
        <?php if (!empty($product->transaction_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Product Id') ?></th>
                <th scope="col"><?= __('Product Stocks Id') ?></th>
                <th scope="col"><?= __('Total Qty') ?></th>
                <th scope="col"><?= __('Transaction Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($product->transaction_details as $transactionDetails): ?>
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
