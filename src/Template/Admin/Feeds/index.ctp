<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Feed[]|\Cake\Collection\CollectionInterface $feeds
 */
?>

<?= $this->Html->link('Add New Entry', ['prefix' => 'admin', 'controller' => 'Feeds', 'action' => 'add'], ['class' => 'btn btn-dark mb-3']) ?>

<style type="text/css">
    .img-size {
        width: inherit;
        height: inherit;
    }
</style>

<div style="height: 70vh; overflow-y: auto; overflow-x: hidden;">
    <div class="row" style="height: 100%">
        <div class="col-sm-6 offset-sm-3" style="height: 100%">
            <?php foreach ($feeds as $feed): ?>
            <?php $images = explode(',', $feed->img_name) ?>
            <div class="card mb-2">
                <div class="card-body">
                    <div class="carousel slide" data-ride="carousel" id="productCarousel<?= $feed->id ?>">
                        <div class="carousel-inner">
                            <?php if (!empty($feed->img_name)): ?>
                                <?php foreach ($images as $key => $image): ?>
                                <div class="carousel-item <?= $key === 0 ? 'active' : '' ?>">
                                    <?= $this->Html->image('feed_images/' . $image, ['class' => 'img-size']) ?>
                                </div>
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>
                        <a class="carousel-control-prev" href="#productCarousel<?= $feed->id ?>" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#productCarousel<?= $feed->id ?>" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            <i class="fa fa-smile-beam"></i>
                            <?= !empty($feed->feed_likes) ? count($feed->feed_likes) : 0?>
                        </div>
                        <div class="col-6">
                            <i class="fa fa-frown-open"></i>
                            <?= !empty($feed->feed_dislikes) ? count($feed->feed_dislikes) : 0?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
        </div>
    </div>
</div>
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