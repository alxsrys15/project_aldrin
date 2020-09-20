<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Feed $feed
 */

// pr($feed);die();
$images = explode(',', $feed->img_name);

?>

<style type="text/css">
    .img-size {
        width: inherit;
        height: inherit;
    }
</style>

<div class="row">
    <div class="col-sm-6">
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
        </div>
        <div class="col-sm-12 mt-3">
            <?= $this->Form->create() ?>
            <div class="form-group">
                <?= $this->Form->input('comment', ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'label' => false, 'type' => 'textarea', 'placeholder' => 'What do you think?']) ?>
                <button class="btn btn-dark btn-sm mt-3" type="submit">Add comment</button>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <div class="col-sm-6">
        <h5>Comments</h5>
        <div class="row">
            <div class="col-sm-12">
                <?php if (count($feed_comments) < 1): ?>
                <div class="card">
                    <div class="card-body">
                        Be the one to comment first.
                    </div>
                </div>
                <?php else: ?>
                    <?php foreach ($feed_comments as $comment): ?>
                    <div class="card mb-2">
                        <div class="card-body">
                            <p><?= $comment->comment ?></p>
                            <small><?= $comment->user->first_name ?> <?= $comment->user->last_name ?></small>
                            <br>
                            <small><?= $comment->created->format('Y-m-d H:i:s') ?></small>
                        </div>
                    </div>
                    <?php endforeach ?>
                    <div class="paginator mt-3">
                        <ul class="pagination">
                            <?= $this->Paginator->first(__('First')) ?>
                            <?= $this->Paginator->prev(\__('Previous')) ?>
                            <?= $this->Paginator->numbers() ?>
                            <?= $this->Paginator->next(__('Next')) ?>
                            <?= $this->Paginator->last(__('Last')) ?>
                        </ul>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
