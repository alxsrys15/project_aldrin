<div class="row">
	<div class="col-6">
		<div class="form-group col-6">
			<label>Select year</label>
			<select id="sales-year" class="form-control">
				<option value="2019">2019</option>
				<?php foreach ($years as $year): ?>
				<option value="<?= $year->year ?>"><?= $year->year ?></option>
				<?php endforeach ?>
			</select>
		</div>
		<canvas id="sales-chart">
			
		</canvas>
	</div>
	<div class="col-6" style="margin-top: 86px">
		<canvas id="stock-chart">
			
		</canvas>
	</div>
</div>


<?= $this->Html->script('Chart.min') ?>

<script type="text/javascript">
	var salesChart = null;
	var stocksChart = null;
	var bestProdChart = null;
	function populateChart (canvas_id, chart, data = null, type, label) {
		if (chart) {
			chart.data.labels = data.map(d => d.label);
			chart.data.datasets[0].data = data.map(d => d.data);
			chart.update();
		} else {
			var ctx = $(canvas_id);
			chart = new Chart(ctx, {
			    type: type,
			    data: {
			        labels: data.map(d => d.label),
			        datasets: [{
			            label: label,
			            data: data.map(d => d.data),
			            borderWidth: 1,
			            backgroundColor: 'rgba(14, 194, 230, 0.1)'
			        }]
			    },
			    options: {
			        scales: {
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
                    populateChart('#sales-chart', salesChart, data, 'line', 'Sales');
                }
            });
		});
		$.ajax({
            headers: {
                'X-CSRF-Token': csrfToken
            },
            url: url + 'admin/dashboards/getStocks',
            type: 'post',
            data: {},
            success: function (data) {
                populateChart('#stock-chart', stocksChart, data, 'bar', 'Stocks');
            }
        });
		$('#sales-year').trigger('change');
	});
</script>