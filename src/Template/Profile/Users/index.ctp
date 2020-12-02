<div class="container">
	<div class="row"> 
        <div class="col-sm-3">
            <?= $this->element('profile_sidebar') ?>
        </div>
        <div class="col-sm-9">
            <?= $this->Form->create(null, ['url' => ['prefix' => 'profile', 'controller' => 'Users', 'action' => 'edit', $user->id]]) ?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="col-sm-12">
                        <label for="first-name" class="col-form-label">First Name</label>
                        <?= $this->Form->control('first_name', ['class'=> 'form-control', 'label' => false, 'required' => true, 'value' => $user->first_name]) ?>
                    </div>
                    <div class="col-sm-12">
                        <label for="last-name" class="col-form-label">Last Name</label>
                        <?= $this->Form->control('last_name', ['class'=> 'form-control', 'label' => false, 'required' => true, 'value' => $user->last_name]) ?>
                    </div>
                    <div class="col-sm-12">
                        <label for="email" class="col-form-label">Email</label>
                        <?= $this->Form->control('email', ['class'=> 'form-control', 'label' => false, 'readonly' => true, 'value' => $user->email]) ?>
                    </div>
                    <div class="col-sm-12">
                        <label for="contact-no" class="col-form-label">Contact #</label>
                        <?= $this->Form->control('contact_no', ['class'=> 'form-control', 'label' => false, 'value' => $user->contact_no]) ?>
                    </div>
                    <div class="col-sm-12 mt-3">
                        <button class="btn btn-dark">Save</button>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="col-sm-12">
                        <label for="street-name" class="col-form-label">Street</label>
                        <?= $this->Form->control('street_name', ['class'=> 'form-control', 'label' => false, 'value' => $user->street_name]) ?>
                    </div>
                    <div class="col-sm-12">
                        <label for="barangay" class="col-form-label">Barangay</label>
                        <?= $this->Form->control('barangay', ['class'=> 'form-control', 'label' => false, 'value' => $user->barangay]) ?>
                    </div>
                    <div class="col-sm-12">
                        <label for="city" class="col-form-label">City</label>
                        <?= $this->Form->control('city', ['class'=> 'form-control', 'label' => false, 'value' => $user->city]) ?>
                    </div>
                    <div class="col-sm-12">
                        <label for="country" class="col-form-label">Country</label>
                        <?= $this->Form->control('country', ['class'=> 'form-control', 'label' => false, 'value' => $user->country]) ?>
                    </div>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>