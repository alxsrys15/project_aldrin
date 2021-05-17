<div>
	<h3><?= $product->name ?></h3>
	<table class="table">
		<thead>
			<th>Variant</th>
			<th>Stock available</th>
			<th>Actions</th>
		</thead>
		<tbody>
			<?php foreach ($product->product_stocks as $stock): ?>
			<tr>
				<td><?= $stock->variant . ', ' . $stock->size->name ?></td>
				<td><?= $stock->sku ?></td>
				<td>
					<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#stock-form-modal" data-pv_id="<?= $stock->id ?>"><i class="fa fa-plus"></i> Add Stock</button>
					<button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#remove-form-modal" data-pv_id="<?= $stock->id ?>"><i class="fa fa-trash"></i> Remove Stock</button>
					<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#stock-history-modal" data-pv_id="<?= $stock->id ?>"><i class="fa fa-eye"></i> View History</button>
				</td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>
<div class="modal fade" id="remove-form-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Remove Stock</h5>
			</div>
			<div class="modal-body">
				<?= $this->Form->create(null, ['id' => 'remove-stock-form', 'url' => ['action' => 'removeStocks']]) ?>
					<?= $this->Form->control('rem_pv_id', ['type' => 'hidden']) ?>
					<?= $this->Form->control('rem_quantity', ['type' => 'number', 'class' => 'form-control', 'label' => false, 'min' => '1', 'value' => '1']) ?>
					<small id="passwordHelpBlock" class="form-text text-muted">
  						Please input the quantity of items to be removed.
					</small>
				<?= $this->Form->end() ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" form="remove-stock-form" class="btn btn-primary">Save</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="stock-form-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Stock</h5>
			</div>
			<div class="modal-body">
				<?= $this->Form->create(null, ['id' => 'add-stock-form', 'url' => ['action' => 'addStocks']]) ?>
					<?= $this->Form->control('pv_id', ['type' => 'hidden']) ?>
					<?= $this->Form->control('quantity', ['type' => 'number', 'class' => 'form-control', 'label' => false, 'min' => '1', 'value' => '1']) ?>
				<?= $this->Form->end() ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" form="add-stock-form" class="btn btn-primary">Save</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="stock-history-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Stock history</h5>
			</div>
			<div class="modal-body" id="hist-modal-body">
				<div class="d-flex justify-content-center" id="loader">
					<div class="spinner-border text-primary" role="status">
  						<span class="sr-only">Loading...</span>
					</div>
				</div>
				<div id="wrapper">
					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		$('#stock-form-modal').on('show.bs.modal', function (e) {
			const trigger = e.relatedTarget;
			$('#pv-id').val($(trigger).data('pv_id'));
		});

		$('#stock-form-modal').on('hide.bs.modal', function () {
			$('#quantity').val('1');
			$('#pv-id').val('');
		});

		$('#remove-form-modal').on('show.bs.modal', function (e) {
			const trigger = e.relatedTarget;
			$('#rem-pv-id').val($(trigger).data('pv_id'));
		});

		$('#remove-form-modal').on('hide.bs.modal', function () {
			$('#rem-quantity').val('1');
			$('#rem-pv-id').val('');
		});

		$('#stock-history-modal').on('show.bs.modal', function (e) {
			const trigger = e.relatedTarget;
			const pv_id = $(trigger).data('pv_id');
			$.ajax({
				headers: {
        		'X-CSRF-Token': csrfToken
	    		},
				url: url + '/admin/products/stockHistory',
				type: 'post',
				data: {
					pv_id: pv_id
				},
				success: function (data) {
					$('#loader').removeClass('d-flex').addClass('d-none');
					$('#wrapper').html(data);
				}
			});
		});

		$('#stock-history-modal').on('hide.bs.modal', function () {
			$('#wrapper').html('');
		});

		$(document).on('click','.page-link' , function () {
			const url = $(this).attr('href');
			$.ajax({
				headers: {
        		'X-CSRF-Token': csrfToken
	    		},
				url: url,
				type: 'post',
				data: {
					pv_id: $('#ps_id').val()
				},
				beforeSend: function () {
					$('#loader').addClass('d-flex').removeClass('d-none');
				},
				success: function (data) {
					$('#loader').removeClass('d-flex').addClass('d-none');
					$('#wrapper').html(data);
				}
			});
			return false;
		});
	});
</script>
