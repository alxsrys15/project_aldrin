<div class="row">
	<div class="col-6">
		<div class="form-group col-6">
			<label>Select year</label>
			<select id="sales-year" class="form-control">
				<?php foreach ($years as $year): ?>
				<option value="<?= $year->year ?>"><?= $year->year ?></option>
				<?php endforeach ?>
			</select>
		</div>
		<canvas id="chart#1">
			
		</canvas>
	</div>
</div>


<?= $this->Html->script('Chart.min') ?>

<script type="text/javascript">
	function populateChart (canvas_id) {
		var ctx = document.getElementById('chart#1');
		var salesChart = new Chart(ctx, {
		    type: 'bar',
		    data: {
		        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
		        datasets: [{
		            label: 'Sales',
		            data: [12, 19, 3, 5, 2, 3],
		            backgroundColor: [
		                'rgba(255, 99, 132, 0.2)',
		                'rgba(54, 162, 235, 0.2)',
		                'rgba(255, 206, 86, 0.2)',
		                'rgba(75, 192, 192, 0.2)',
		                'rgba(153, 102, 255, 0.2)',
		                'rgba(255, 159, 64, 0.2)',
		                'rgba(255, 99, 132, 0.2)',
		                'rgba(54, 162, 235, 0.2)',
		                'rgba(255, 206, 86, 0.2)',
		                'rgba(75, 192, 192, 0.2)',
		                'rgba(153, 102, 255, 0.2)',
		                'rgba(255, 159, 64, 0.2)'
		            ],
		            borderColor: [
		                'rgba(255, 99, 132, 1)',
		                'rgba(54, 162, 235, 1)',
		                'rgba(255, 206, 86, 1)',
		                'rgba(75, 192, 192, 1)',
		                'rgba(153, 102, 255, 1)',
		                'rgba(255, 159, 64, 1)',
		                'rgba(255, 99, 132, 0.2)',
		                'rgba(54, 162, 235, 0.2)',
		                'rgba(255, 206, 86, 0.2)',
		                'rgba(75, 192, 192, 0.2)',
		                'rgba(153, 102, 255, 0.2)',
		                'rgba(255, 159, 64, 0.2)'
		            ],
		            borderWidth: 1
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
                    console.log(data);
                }
            });
		});
	});
</script>