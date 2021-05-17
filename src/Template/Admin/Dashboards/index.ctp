<div class="row">
	<div class="col-6">
		<div class="form-group col-6">
			<h4>SALES</h4>
			<label>Select year</label>
			<select id="sales-year" class="form-control">
				<?php foreach ($years as $year): ?>
				<option value="<?= $year->year ?>"><?= $year->year ?></option>
				<?php endforeach ?>
			</select>
		</div>
		<canvas id="sales-chart">
			
		</canvas>
		<small id="passwordHelpBlock" class="form-text text-muted">
			Red color means that sales for the month is below the 10,000 threshold.
		</small>
	</div>
	<div class="col-6">
		<div class="form-group col-6">
			<h4>INVENTORY</h4>
			<label>Select Product</label>
			<select id="product-id" class="form-control">
				<?php foreach ($products as $product): ?>
				<option value="<?= $product->id ?>"><?= $product->name ?></option>
				<?php endforeach ?>
			</select>
		</div>
		<canvas id="stock-chart">
			
		</canvas>
		<small id="passwordHelpBlock" class="form-text text-muted">
			Red color means that variant quantity is below the 50pcs threshold.
		</small>
	</div>
	<div class="col-12">
		<h4>BEST SELLERS</h4>
		<div class="row">
			<div class="col-6">
				<div class="row">
					<div class="col-3">
						<label>Select year</label>
						<select class="form-control" id="best-seller-year">
							<?php foreach ($years as $year): ?>
							<option value="<?= $year->year ?>"><?= $year->year ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="col-3">
						<label>Select month</label>
						<select class="form-control" id="best-seller-month">
							<?php foreach ($months as $m => $month): ?>
								<option value="<?= $m ?>"><?= $month ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="col-3">
						<label>Select category</label>
						<select class="form-control" id="category">
							<?php foreach ($categories as $cat_id => $category): ?>
							<option value="<?= $cat_id ?>"><?= $category ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="col-3" style="padding-top: 2em">
						<button class="btn btn-sm btn-primary best-seller-btn">
							<i class="fa fa-search"></i> Display
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12" align="center">
				<canvas id="best-seller-chart">
			
				</canvas>
			</div>
			<div class="col-12" align="center" id="helper-text" style="display: none">
				<h4>NO DATA AVAILABLE</h4>
			</div>
		</div>
	</div>
</div>


<?= $this->Html->script('Chart.min') ?>

<script type="text/javascript">
	var charts = {
		"sales-chart": null,
		"stock-chart": null,
		"best-seller-chart": null
	}
	function populateChart (canvas_id, chart, data = null, type, label) {
		if (charts[chart]) {
			charts[chart].data.labels = data.data.map(d => d.label);
			charts[chart].data.datasets[0].data = data.data.map(d => d.data);
			charts[chart].data.datasets[0].backgroundColor = data.bg_colors.map(c => c);
			charts[chart].data.datasets[0].label = label;
			charts[chart].update();
		} else {
			console.log(data);
			var ctx = $(canvas_id);
			charts[chart] = new Chart(ctx, {
			    type: type,
			    data: {
			        labels: data.data.map(d => d.label),
			        datasets: [
				        {
				            label: label,
				            data: data.data.map(d => d.data),
				            borderWidth: 1,
				            backgroundColor: data.bg_colors.map(c => c)
				        }
			        ]
			    },
			    options: {
			        scales: type == 'pie' ? {} : {
			            yAxes: [{
			                ticks: {
			                    beginAtZero: true
			                }
			            }]
			        }
			    }
			});
		}
	}
	$(document).ready(function () {
		$('#sales-year').on('change', function () {
			const year = $(this).val();
			$.ajax({
                headers: {
                    'X-CSRF-Token': csrfToken
                },
                url: url + 'admin/dashboards/salesPerYear',
                type: 'post',
                data: {
                    year: year
                },
                success: function (data) {
                    populateChart('#sales-chart', 'sales-chart', data, 'bar', 'Sales');
                }
            });
		});
		$("#product-id").on('change', function () {
			$.ajax({
	            headers: {
	                'X-CSRF-Token': csrfToken
	            },
	            url: url + 'admin/dashboards/getStocks',
	            type: 'post',
	            data: {
	            	prod_id: $(this).val()
	            },
	            success: function (data) {
	                populateChart('#stock-chart', 'stock-chart', data, 'bar', 'Variants');
	            }
	        });
		});
		$('.best-seller-btn').on('click', function () {
			$.ajax({
	            headers: {
	                'X-CSRF-Token': csrfToken
	            },
	            url: url + 'admin/dashboards/getBestSeller',
	            type: 'post',
	            data: {
	            	category: $('#category').val(),
	            	month: $('#best-seller-month').val(),
	            	year: $('#best-seller-year').val()
	            },
	            success: function (data) {
	            	if(data.data.length > 0) {
	            		$('#best-seller-chart').show();
	            		$('#helper-text').hide()
	            		populateChart('#best-seller-chart', 'best-seller-chart', data, 'pie', '');
	            	} else {
	            		$('#best-seller-chart').hide();
	            		$('#helper-text').show()
	            	}
	            }
	        });
		});
		$('.best-seller-btn').trigger('click');
		$('#sales-year').trigger('change');
		$("#product-id").trigger('change');
	});
</script>