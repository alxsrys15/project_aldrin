  
<style type="text/css">
	.invalid {
		border: solid 1px red !important;
	}
	.spinner {
		border: 1px solid;
		position: fixed;
		z-index: 1;
		left: 0;
		right: 0;
		top: 0;
		bottom: 0;
		background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='0 0 50 50'%3E%3Cpath d='M28.43 6.378C18.27 4.586 8.58 11.37 6.788 21.533c-1.791 10.161 4.994 19.851 15.155 21.643l.707-4.006C14.7 37.768 9.392 30.189 10.794 22.24c1.401-7.95 8.981-13.258 16.93-11.856l.707-4.006z'%3E%3CanimateTransform attributeType='xml' attributeName='transform' type='rotate' from='0 25 25' to='360 25 25' dur='0.6s' repeatCount='indefinite'/%3E%3C/path%3E%3C/svg%3E") center / 50px no-repeat;
	}
</style>

<div class="container">
	<div class="row">
		<div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">
			<div class="table-responsive">
				<table class="table" id="cart_table">
					<thead>
						<tr>
							<th scope="col" class="border-0 bg-light">
								<div class="p-2 px-3 text-uppercase">Product</div>
							</th>
							<th scope="col" class="border-0 bg-light">
	                    		<div class="py-2 text-uppercase">Size</div>
	                  		</th>
							<th scope="col" class="border-0 bg-light">
	                    		<div class="py-2 text-uppercase">Price</div>
	                  		</th>
	                  		<th scope="col" class="border-0 bg-light">
	                    		<div class="py-2 text-uppercase">Quantity</div>
	                  		</th>
	                  		<th scope="col" class="border-0 bg-light">
	                    		<div class="py-2 text-uppercase">Action</div>
	                  		</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
				<div class="spinner d-none" id="loader">
					<div class="text-center">
					  	<div class="spinner-border spinner-border-lg" role="status">
					    	<span class="sr-only">Loading...</span>
					  	</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row py-5 p-4 bg-white rounded shadow-sm">
		<div class="col-lg-6">
			<div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Payment Method</div>
			<div class="p-4">
	            <p class="font-italic mb-4">Please select a payment method</p>
	            <div class="input-group mb-4 border rounded-pill p-2">
	              	<select class="form-control border-0" id="payment-select">
	              		<?php foreach ($payment_types as $p): ?>
	              		<option value="<?= $p ?>"><?= $p ?></option>
	              		<?php endforeach ?>
	              	</select>
	            </div>
	            <div class="custom-file" style="display: none" id="uploader-container">
		           	<input type="file" class="custom-file-input" id="customFile" accept="image/x-png,image/gif,image/jpeg" name="image" form="cart-form" style="z-index: 1">
		            <label class="custom-file-label" for="customFile">Choose images</label>
		        </div>
		        <button class="btn btn-dark btn-sm bank-info mt-1" style="display: none" data-toggle="modal" data-target="#bank-info-modal">Bank info</button>
			</div>
			<div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Shipping Address</div>
			<div class="p-4">
            	<p class="font-italic mb-4">Please provide an accurate shipping address below</p>
            	<div class="form-row">
            		<div class="col-sm-12 form-group">
            			<input type="text" id="street" class="form-control" placeholder="Street Address" value="<?= $Auth->User('street_name') ?>">
            		</div>
            		<div class="col-sm-4 form-group">
            			<input type="text" id="brgy" class="form-control" placeholder="Barangay" value="<?= $Auth->User('barangay') ?>">
            		</div>
            		<div class="col-sm-4 form-group">
            			<!-- <input type="text" id="prov" class="form-control" placeholder="Province"> -->
            			<select id="prov" class="form-control" value="<?= $Auth->User('country') ?>"></select>
            		</div>
            		<div class="col-sm-4 form-group">
            			<!-- <input type="text" id="cty" class="form-control" placeholder="City/Municipality"> -->
            			<select id="cty" class="form-control" value="<?= $Auth->User('city') ?>"></select>
            		</div>
            	</div>
          	</div>
		</div>
		<div class="col-lg-6">
			<div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Order summary </div>
			<div class="p-4">
				<ul class="list-unstyled mb-4">
					<li class="d-flex justify-content-between py-3 border-bottom">
						<strong class="text-muted">Order Subtotal </strong>
						<strong id="total-cart">$390.00</strong>
					</li>
					<li class="d-flex justify-content-between py-3 border-bottom">
						<strong class="text-muted">Shipping and handling</strong>
						<strong id="shipping-fee"></strong>
					</li>
					<li class="d-flex justify-content-between py-3 border-bottom">
						<strong class="text-muted">
							Total
						</strong>
                		<h5 class="font-weight-bold" id="total">$400.00</h5>
              		</li>
				</ul>
				<a href="#" class="btn btn-primary rounded-pill py-2 btn-block btn-checkout">Procceed to checkout</a>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="bank-info-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Bank Details</h5>
			</div>
			<div class="modal-body">
				<p>Account Number: XXXX-XXXX-XX</p>
				<p>Account Name: Juan Dela Cruz</p>
				<p>Bank: Banco de Oro</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<?= $this->Form->create(null, ['id' => 'cart-form', 'enctype' => 'multipart/form-data']) ?>
<?= $this->Form->control('payment_type', ['type' => 'hidden']) ?>
<?= $this->Form->control('items', ['type' => 'hidden']) ?>
<?= $this->Form->control('street_address', ['type' => 'hidden']) ?>
<?= $this->Form->control('barangay', ['type' => 'hidden']) ?>
<?= $this->Form->control('city', ['type' => 'hidden']) ?>
<?= $this->Form->control('province', ['type' => 'hidden']) ?>
<?= $this->Form->end() ?>

<?= $this->Html->script('city.min.js') ?>

<script type="text/javascript">
	function populateCartTable () {
		var cart = shoppingCart.listCart();
		$.ajax({
			headers: {
        		'X-CSRF-Token': csrfToken
    		},
			url: url + '/shop/products/populateCartTable',
			type: 'post',
			data: {
				data: JSON.stringify(cart)
			},
			beforeSend: function () {
				$('#loader').removeClass('d-none');
			},
			success: function (data) {
				$('#loader').addClass('d-none');
				$('#cart_table tbody').html(data);
			}
		});
	}

	function populateOrderSummary () {
		var total_cart = shoppingCart.totalCart();
		var cart = shoppingCart.listCart();
		var shipping = cart.length > 0 ? 100 : 0;
		$('#shipping-fee').text('P' + shipping.toFixed(2));
		$('#total-cart').text('P' + total_cart.toFixed(2));
		$("#total").text('P' + (total_cart + shipping).toFixed(2));
	}

	$('#payment-select').on('change', function () {
		$('#payment-type').val($(this).val());
		if ($(this).val() == "Bank Transfer") {
			$('.bank-info').show();
			$('#uploader-container').show();
			$('#customFile').attr('required', true);
		} else {
			$('.bank-info').hide();
			$('#uploader-container').hide();
			$('#customFile').removeAttr('required');
		}
	});
	var c = new City();
	const user = <?= json_encode($Auth->User()) ?>;
	c.showProvinces('#prov');
	c.showCities(user.country,'#cty');
	$(document).ready(function () {
		$('#prov').val(user.country);
		$('#cty').val(user.city);
		populateCartTable();
		populateOrderSummary();
		$('#payment-select').trigger('change');
		$('#customFile').on('change', function (e) {
			$(this).next('.custom-file-label').html(e.target.files[0].name);
		});
		$('.btn-checkout').on('click', function () {
			var cart = shoppingCart.listCart();
			if (cart.length > 0) {
				$('#items').val(JSON.stringify(shoppingCart.listCart()));
				if ($('#street').val() == "") {
					$('#street').addClass('is-invalid');
					$('#street').focus();
					Swal.fire(
		                'Error!',
		                'Please provide a shipping address',
		                'error'
		            );
		            return;
				}
				$('#street-address').val($('#street').val());
				$('#barangay').val($('#brgy').val());
				$('#city').val($('#cty').val());
				$('#province').val($('#prov').val());
				if ($('#payment-type').val() == "Bank Transfer") {
					if($('#customFile').val() == "") {
						Swal.fire(
			                'Error!',
			                'Please provide an image of your bank deposit',
			                'error'
			            );
			            return false;
					}
				}
				$('#cart-form').trigger('submit');
			} else {
				Swal.fire(
	                'Error!',
	                'Your cart is empty',
	                'error'
	            );
	            return;
			}
		});

		$("#cart_table").on('click', '.remove-item', function () {
			var name = $(this).data('name');
			var stock_id = $(this).data('stock_id');
			shoppingCart.removeItemFromCart(name, stock_id);
			populateCartTable();
			populateOrderSummary();
			cartBadge();
		});
	});
</script>