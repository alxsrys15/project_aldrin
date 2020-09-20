<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Register</div>
                    <div class="card-body">
                        <?= $this->Form->create(null, ['url' => ['action' => 'register'], 'id' => 'register-form']) ?>
                        <div class="form-group">
                        	<label for="first-name" class="col-md-4 col-form-label">First Name</label>
                        	<div class="col-md-12">
                        		<?= $this->Form->input('first_name', ['class' => 'form-control', 'label' => false, 'required']) ?>
                        	</div>
                        </div>
                        <div class="form-group">
                        	<label for="last-name" class="col-md-4 col-form-label">Last Name</label>
                        	<div class="col-md-12">
                        		<?= $this->Form->input('last_name', ['class' => 'form-control', 'label' => false]) ?>
                        	</div>
                        </div>
                        <div class="form-group">
                        	<label for="email" class="col-md-4 col-form-label">Email address</label>
                        	<div class="col-md-12">
                        		<input type="email" name="email" id="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" required>
                        		<?php if (isset($errors['email'])): ?>
                        		<div class="invalid-feedback">
              						<?= $errors['email']['unique'] ?>
            					</div>
                        		<?php endif ?>
                        	</div>
                        </div>
                        <div class="form-group">
                        	<label for="password2" class="col-md-4 col-form-label">Password</label>
                        	<div class="col-md-12">
                        		<input type="password" name="password" id="password" required class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>">
                        		<?php if (isset($errors['password'])): ?>
                        		<div class="invalid-feedback password-helper">
              						<?= $errors['password']['sameAs'] ?>
            					</div>
                        		<?php endif ?>
                        	</div>
                        </div>
                        <div class="form-group">
                        	<label for="password2" class="col-md-4 col-form-label">Confirm Password</label>
                        	<div class="col-md-12">
                        		<input type="password" name="password2" id="password2" required class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>">
                        		<?php if (isset($errors['password'])): ?>
                        		<div class="invalid-feedback password-helper">
              						<?= $errors['password']['sameAs'] ?>
            					</div>
                        		<?php endif ?>
                        	</div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="col-md-12">
                                <?= $this->Form->button('Register', ['type' => 'submit', 'class' => 'btn btn-dark btn-block submit-btn']) ?>
                            </div>
                        </div>
                        <?= $this->Form->input('is_admin', ['type' => 'hidden', 'value' => '0']) ?>
                        <?= $this->Form->input('is_active', ['type' => 'hidden', 'value' => '0']) ?>
                        <?= $this->Form->end() ?>
                    </div>
            </div>
        </div>
    </div>
</div>

