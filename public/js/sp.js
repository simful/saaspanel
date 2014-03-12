function updateCart() {
	var cycle = $('#billingCycle input[name=cycle]:checked').attr('data-cycle');
	var pack = $('#packageSelect input[name=option]:checked').attr('data-base-price');
	var serviceName = $('#packageSelect input[name=option]:checked').attr('data-fullname');
	var total = cycle * pack;
	$('#item').html('<b>' + serviceName + '</b><br>recurring every ' + cycle + ' months');
	$('#total').html(accounting.formatMoney(total));

	if (total > 0) 
		$('#addToCart').removeAttr('disabled');
	else
		$('#addToCart').addAttr('disabled');
}

$(document).ready(function() {
	$('.service-cycle, .service-option').click(function() {
		updateCart();
	});

	$('.removeFromCart').click(function() {
		$.post('/order/removeFromCart', { id: $(this).attr('data-key') }, function() { location.reload(); });
	});

	$('.monFor').each(function(i, e) {
		$(this).html(accounting.formatMoney($(this).html()));
	});
});