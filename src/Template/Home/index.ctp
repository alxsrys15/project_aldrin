<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <?= $this->Html->image('carousel_images/car1.png', ['class' => 'd-block w-100','style' => 'height:650px;']) ?>
    </div>
    <div class="carousel-item">
      <?= $this->Html->image('carousel_images/car2.png', ['class' => 'd-block w-100','style' => 'height:650px;']) ?>
    </div>
    <div class="carousel-item">
      <?= $this->Html->image('carousel_images/car3.png', ['class' => 'd-block w-100','style' => 'height:650px;']) ?>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<div class="w-100"><br><br><br><br><br></div>
        <div class="col-sm-9 mx-auto my-4">
            <div class="row">
                <?php foreach ($products as $product): ?>
                <?php $images = explode(',', $product->imgs) ?>
                <div class="col-sm-4 mb-3">
                    <div class="card shadow-lg rounded mb-3">
                        <?= $this->Html->link(
                            $this->Html->image('product_images/' . $images[0], ['class' => 'card-img-top']),
                            ['prefix'=>'shop','controller' => 'products', 'action' => 'view', $product->id],
                            ['escape' => false]
                        )
                     ?>
                    <div class="card-body">
                        <?= $this->Html->link('<h5>'.$product->name.'</h5>', ['prefix'=>'shop','controller' => 'products', 'action' => 'view', $product->id], ['class' => 'card-title', 'escape' => false]) ?>
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