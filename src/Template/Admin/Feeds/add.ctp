<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Feed $feed
 */
?>

<?= $this->Form->create(null,['url' => ['action' => 'add'], 'enctype' => 'multipart/form-data']) ?>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="description" class="col-form-label">Description:</label>
            <?= $this->Form->input('description', ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'label' => false, 'type' => 'textarea']) ?>
        </div>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFile" multiple="" accept="image/x-png,image/gif,image/jpeg" name="images[]" required>
            <label class="custom-file-label" for="customFile">Choose images</label>
        </div>
        <?= $this->Form->button('Add Feed', ['type' => 'submit', 'class' => 'btn btn-dark mt-3']) ?>
    </div>
    <div class="col-sm-6">
        <h5>Images Preview</h5>
        <div class="row" id="preview-container">
        
        </div>
    </div>
</div>
<?= $this->Form->end() ?>

<script type="text/javascript">
    function readURL (input, uploader) {
        const files = input.files;
        if (files) {
            $.each(files, function (i, el) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    console.log(e);
                    const markUp = `
                        <div class="col-sm-4 m-3">
                            <img src="${e.target.result}" class="mx-auto img-fluid" width="200" height="200" />
                        </div>
                    `;
                    $('#preview-container').append(markUp);
                }
                reader.readAsDataURL(el);
            });
        }
    }
    $(document).ready(function () {
        $('#customFile').on('change', function () {
            readURL(this, $(this));
        });
    });
</script>