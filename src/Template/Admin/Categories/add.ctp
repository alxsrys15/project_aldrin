<?= $this->Form->create() ?>
<div class="form-row">
	<div class="col-md-4">
		<label for="category-name">Name</label>
		<input type="text" name="name" class="form-control" required>
	</div>
</div>
<button class="btn btn-dark mt-3" type="submit">Add Category</button>

<?= $this->Form->end() ?>