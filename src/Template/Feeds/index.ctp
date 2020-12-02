<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Feed[]|\Cake\Collection\CollectionInterface $feeds
 */
$user_id = $this->request->session()->read('Auth.User.id');
$feeds = $feeds->toArray();
foreach ($feeds as $key => $feed) {
    $user_liked = [];
    $user_disliked = [];
    foreach ($feed->feed_likes as $like) {
        $user_liked[] = $like->user_id;
    }
    foreach ($feed->feed_dislikes as $dislike) {
        $user_disliked[] = $dislike->user_id;
    }
    $feeds[$key]['user_liked'] = $user_liked;
    $feeds[$key]['user_disliked'] = $user_disliked;
}

?>

<style type="text/css">
    .img-size {
        width: inherit;
        height: inherit;
    }
</style>

<div>
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
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
                            <button class="btn btn-react <?= in_array($user_id, $feed['user_liked']) ? 'btn-outline-primary pressed' : '' ?>" data-reaction="like" data-feed_id="<?= $feed->id ?>" <?= empty($this->request->session()->read('Auth.User.id')) ? 'disabled' : '' ?> id="btn-like-<?= $feed->id ?>">
                                <i class="fa fa-smile-beam"></i>
                                <span id="feed-<?= $feed->id ?>-like"><?= !empty($feed->feed_likes) ? count($feed->feed_likes) : 0?></span>
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-react <?= in_array($user_id, $feed['user_disliked']) ? 'btn-outline-primary pressed' : '' ?>" data-reaction="dislike" data-feed_id="<?= $feed->id ?>" <?= empty($this->request->session()->read('Auth.User.id')) ? 'disabled' : '' ?> id="btn-dislike-<?= $feed->id ?>">
                                <i class="fa fa-frown-open"></i>
                                <span id="feed-<?= $feed->id ?>-dislike"><?= !empty($feed->feed_dislikes) ? count($feed->feed_dislikes) : 0?></span>
                            </button>
                        </div>
                        <div class="col-12 mt-2">
                            <?= $this->Html->link('View Feed', ['action' => 'view', $feed->id], ['escape' => false, 'class' => 'btn btn-dark btn-sm']) ?>
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
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.btn-react').on('click', function () {
            const react = $(this).data('reaction');
            const feed_id = $(this).data('feed_id');
            const current_like = Number($('#feed-'+feed_id+'-like').html());
            const current_dislike = Number($('#feed-'+feed_id+'-dislike').html());
            $.ajax({
                headers: {
                    'X-CSRF-Token': csrfToken
                },
                url: url + '/feeds/react',
                type: 'post',
                data: {
                    feed_id: feed_id,
                    react: react,
                },
                success: function (data) {
                    const r = JSON.parse(data);
                    if (r.react_status === "new_liked") {
                        $('#btn-like-'+feed_id).addClass('btn-outline-primary');
                        $('#feed-'+feed_id+'-like').html(current_like + 1);
                    } else if (r.react_status === "unliked") {
                        $('#btn-like-'+feed_id).removeClass('btn-outline-primary');
                        $('#feed-'+feed_id+'-like').html(current_like - 1);
                    } else if (r.react_status === "undisliked_then_liked") {
                        $('#btn-like-'+feed_id).addClass('btn-outline-primary');
                        $('#feed-'+feed_id+'-like').html(current_like + 1);
                        $('#btn-dislike-'+feed_id).removeClass('btn-outline-primary');
                        $('#feed-'+feed_id+'-dislike').html(current_dislike - 1);
                    } else if (r.react_status === "new_disliked") {
                        $('#btn-dislike-'+feed_id).addClass('btn-outline-primary');
                        $('#feed-'+feed_id+'-dislike').html(current_dislike + 1);
                    } else if(r.react_status === "undisliked") {
                        $('#btn-dislike-'+feed_id).removeClass('btn-outline-primary');
                        $('#feed-'+feed_id+'-dislike').html(current_dislike - 1);
                    } else {
                        $('#btn-like-'+feed_id).removeClass('btn-outline-primary');
                        $('#feed-'+feed_id+'-like').html(current_like - 1);
                        $('#btn-dislike-'+feed_id).addClass('btn-outline-primary');
                        $('#feed-'+feed_id+'-dislike').html(current_dislike + 1);
                    }
                }
            });
        });
    });
</script>