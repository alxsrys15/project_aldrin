<div class="container">
	<div class="row"> 
        <div class="col-sm-3">
            <?= $this->element('profile_sidebar') ?>
        </div>
        <div class="col-sm-9">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Invoice</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($transactions) > 0): ?>
                        <?php foreach ($transactions as $transaction): ?>
                        <tr>
                            <td><?= $transaction->created->format('Y-m-d h:i a') ?></td>
                            <td><?= $transaction->paypal_token ?></td>
                            <td>P <?= number_format($transaction->total_price, 2) ?></td>
                            <td><?= $transaction->status->name ?></td>
                            <td>
                                <?= $this->Html->link('Details', ['prefix' => 'shop', 'controller' => 'Products', 'action' => 'orderTracker', '?' => ['token' => $transaction->paypal_token]], ['class' => 'btn btn-sm btn-dark']) ?>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="20" align="center">No records found</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
            <div class="paginator">
                <ul class="pagination">
                    <?= $this->Paginator->prev('Prev') ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next('Next') ?>
                </ul>
            </div>
        </div>
    </div>
</div>