<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>


<?= $this->Form->create(null,['url' => ['action' => 'add'], 'enctype' => 'multipart/form-data']) ?>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name" class="col-form-label">Name:</label>
            <?= $this->Form->input('name', ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'label' => false]) ?>
        </div>
        <div class="row form-group">
            <div class="col-sm-6">
                <label for="category-id" class="col-form-label">Category:</label>
                <?= $this->Form->input('category_id', ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'label' => false, 'type' => 'select']) ?>
            </div>
            <div class="col-sm-6">
                <label for="gender-id" class="col-form-label">Price:</label>
                <?= $this->Form->input('price', ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'label' => false, 'type' => 'number', 'min' => '1']) ?>
            </div>
        </div>
        <div class="form-group">
            <label for="description" class="col-form-label">Description:</label>
            <?= $this->Form->input('description', ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'label' => false, 'type' => 'textarea']) ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="col-12">
            <h5>Images</h5>
        </div>
        <div class="row">
            <div class="col-4">
                <?= $this->Html->image('assets/default-image.jpg', ['class' => 'mx-auto img-fluid preview', 'data-input' => '#img1', 'style' => ['cursor: pointer'],'id' => 'image1-preview']) ?>
                <div class="custom-file d-none">
                      <?= $this->Form->input('images[0]', ['type' => 'file', 'data-preview' => '#image1-preview', 'class' => 'uploader', 'accept' => 'image/x-png,image/gif,image/jpeg', 'id' => 'img1']) ?>
                </div>
            </div>
            <div class="col-4">
                <?= $this->Html->image('assets/default-image.jpg', ['class' => 'mx-auto img-fluid preview', 'data-input' => '#img2', 'style' => ['cursor: pointer'],'id' => 'image2-preview']) ?>
                <div class="custom-file d-none">
                      <?= $this->Form->input('images[1]', ['type' => 'file', 'data-preview' => '#image2-preview', 'class' => 'uploader', 'accept' => 'image/x-png,image/gif,image/jpeg', 'id' => 'img2']) ?>
                </div>
            </div>
            <div class="col-4">
                <?= $this->Html->image('assets/default-image.jpg', ['class' => 'mx-auto img-fluid preview', 'data-input' => '#img3', 'style' => ['cursor: pointer'],'id' => 'image3-preview']) ?>
                <div class="custom-file d-none">
                      <?= $this->Form->input('images[2]', ['type' => 'file', 'data-preview' => '#image3-preview', 'class' => 'uploader', 'accept' => 'image/x-png,image/gif,image/jpeg', 'id' => 'img3']) ?>
                </div>
            </div>
        </div>
        <div class="form-group mt-3">
            <a href="#!" class="btn btn-sm btn-primary btn-add-stocks">Add Size</a>
        </div>
        <div id="sizes" class="container">

        </div>
    </div>
</div>
<?= $this->Form->button('Add Product', ['type' => 'submit', 'class' => 'btn btn-dark']) ?>
<?= $this->Form->end() ?>

<div id="template" class="d-none">
    <div class="form-row align-items-center">
        <div class="col-4">
            <label class="sr-only">Size</label>
            <?= $this->Form->input('product_stocks.0.size_id', ['class' => 'form-control', 'type' => 'select', 'label' => false]) ?>
        </div>
        <div class="col-4">
            <label class="sr-only">Stock</label>
            <?= $this->Form->input('product_stocks.0.variant', ['class' => 'form-control', 'type' => 'text', 'label' => false, 'placeholder' => 'Variant/Color', 'required']) ?>
        </div>
        <div class="col-3">
            <label class="sr-only">Stock</label>
            <?= $this->Form->input('product_stocks.0.sku', ['class' => 'form-control sku', 'type' => 'number', 'min' => 1, 'label' => false, 'placeholder' => 'Quantity', 'required']) ?>
        </div>
        <div class="col-1">
            <a class="btn btn-sm btn-danger btn-remove-stocks"><i class="fa fa-minus-circle" aria-hidden="true"></i></a>
        </div>
    </div>
</div>

<script type="text/javascript">
    function renameStockInputs () {
        $('#sizes').find('input[type=number]').each(function (i) {
            $(this).attr('name', 'product_stocks['+i+'][sku]');
            $(this).attr('id', 'product-stocks-'+i+'-sku');
        });
        $('#sizes').find('select').each(function (i) {
            $(this).attr('name', 'product_stocks['+i+'][size_id]');
            $(this).attr('id', 'product-stocks-'+i+'-size_id');
        });
    }

    function readURL (input, uploader) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
              $(uploader.data('preview')).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
         }
    }

    $(document).ready(function () {
        $(document).on('click', '.btn-add-stocks', function () {
            $('#sizes').append($('#template').html());
            renameStockInputs();
        });

        $(document).on('click', '.btn-remove-stocks', function () {
            $(this).parent().parent().remove();
            renameStockInputs();
        });
    });

    $('.preview').on('click', function () {
        $($(this).data('input')).trigger('click');
    });

    $('.uploader').on('change', function () {
        readURL(this, $(this));
    });
</script>