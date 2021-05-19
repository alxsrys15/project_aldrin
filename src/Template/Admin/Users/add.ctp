<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$init_pass = generateRandomString(8);

?>

<?= $this->Form->create() ?>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="first_name" class="col-form-label">First Name:</label>
            <?= $this->Form->input('first_name', ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'label' => false]) ?>
        </div>
        <div class="form-group">
            <label for="last_name" class="col-form-label">Last Name:</label>
            <?= $this->Form->input('last_name', ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'label' => false]) ?>
        </div>
        <div class="form-group">
            <label for="contact_no" class="col-form-label">Contact No:</label>
            <?= $this->Form->input('contact_no', ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'label' => false]) ?>
        </div>
        <div class="form-group">
            <label for="email" class="col-form-label">Email:</label>
            <?= $this->Form->input('email', ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'label' => false]) ?>
        </div>
        <div class="form-group">
            <label for="password" class="col-form-label">Initial Password:</label>
            <div class="input-group">
                <?= $this->Form->input('password', ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'label' => false, 'readOnly', 'value' => $init_pass, 'type' => 'text']) ?>
                <div class="input-group-append spinner add">
                    <button class="btn btn-success generate-password" type="button" id="button-addon1"><i class="fa fa-magic"> Generate Password</i></button>
                </div>
            </div>
            <small id="passwordHelpBlock" class="form-text text-muted">
                Please copy first the initial password before saving.
            </small>
        </div>
    </div>
</div>
<?= $this->Form->button('Add User', ['type' => 'submit', 'class' => 'btn btn-dark']) ?>
<?= $this->Form->end() ?>

<script type="text/javascript">
    function generateRandomString (length) {
        var result = [];
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
          result.push(characters.charAt(Math.floor(Math.random() * charactersLength)));
        }
        return result.join('');
    }
    $(document).ready(function () {
        $('.generate-password').on('click', function () {
            $('#password').val(generateRandomString(8));
        });
    });
</script>