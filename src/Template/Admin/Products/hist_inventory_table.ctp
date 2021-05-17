<input type="hidden" id="ps_id" value="<?= $pv_id ?>">
<table class="table">
	<thead>
		<th>Action</th>
		<th>Date</th>
		<th>User</th>
	</thead>
	<tbody>
		<?php if (count($hists) > 0): ?>
			<?php foreach ($hists as $hist): ?>
			<tr>
				<td><?= $hist->action ?></td>
				<td><?= $hist->created->format('Y-m-d H:i:s') ?></td>
				<td><?= $hist->user->first_name ?> <?= $hist->user->last_name ?></td>
			</tr>
			<?php endforeach ?>
		<?php else: ?>
		<tr>
			<td colspan="20" align="center">No records.</td>
		</tr>
		<?php endif ?>
	</tbody>
</table>
<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->prev('Previous') ?>
        <?= $this->Paginator->next('Next') ?>
    </ul>
    <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
</div>