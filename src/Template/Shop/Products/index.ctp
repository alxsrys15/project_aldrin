<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product[]|\Cake\Collection\CollectionInterface $products
 */
?>

<div class="container">
    <div class="row">
        <div class="col-sm3">
            <div class="card">
                <div class="card-header text-center">
                    <h5 class="panel-title">PRODUCT CATEGORIES</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 mx-auto my-4">
                    <div class="list-group list-group-flush " id="list-tab" role="tablist">
                        <?php foreach ($categories as $category): ?>
                            <?= $this->Html->link($category->name, ['prefix' => 'shop','controller' => 'products', 'action' => 'index', '?' => ['category' => $category->id]], ['class' => 'list-group-item list-group-item-action' ]) ?>
                        <?php endforeach ?>
                    </div>  
                </div>
            </div>
        </div>
        <div class="col-sm-9 ml-3">
            <div class="row">
                <?php foreach ($products as $product): ?>
                <?php $images = explode(',', $product->imgs) ?>
                <div class="col-sm-4>">
                    <div class="card shadow-lg rounded mb-3" style="width: 18rem;">
                        <?= $this->Html->link(
                            $this->Html->image('product_images/' . $images[0], ['class' => 'card-img-top']),
                            ['controller' => 'products', 'action' => 'view', $product->id],
                            ['escape' => false]
                        )
                     ?>
                    <div class="card-body">
                        <?= $this->Html->link('<h5>'.$product->name.'</h5>', ['controller' => 'products', 'action' => 'view', $product->id], ['class' => 'card-title', 'escape' => false]) ?>
                        <p class="justify-content-center text-muted">
                            <?= $product->description ?>
                        </p>
                    </div>
                    <div class="card-footer">
                        <p class="card-text text-center"><?= 'PHP ' . number_format($product->price, 2) ?></p>
                    </div>
                    </div>
                    
                </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>