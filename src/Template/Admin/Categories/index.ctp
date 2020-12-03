<?= $this->Html->link('Add Category', ['prefix' => 'admin', 'controller' => 'Categories', 'action' => 'add'], ['class' => 'btn btn-dark mb-3']) ?>

<table class="table">
	<thead>
		<tr>
			<th>Name</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($categories as $category): ?>
		<tr>
			<td><?= $category->name ?></td>
			<td>
				<?php if ($category->is_active): ?>
				<?= $this->Html->link('Deactivate', ['action' => 'updateCat', $category->id, 0], ['class' => 'btn btn-sm btn-success']) ?>
				<?php else: ?>
				<?= $this->Html->link('Activate', ['action' => 'updateCat', $category->id], ['class' => 'btn btn-sm btn-danger']) ?>
				<?php endif ?>
			</td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>
<div class="row justify-content-center">
    <div class="col-12">
        <nav>
            <ul class="pagination" id="pagination">
                <?= $this->Paginator->prev('Previous') ?>
                <?= $this->Paginator->numbers(['modulus' => 2]) ?>
                <?= $this->Paginator->next('Next') ?>
            </ul>
        </nav>
    </div>
</div>