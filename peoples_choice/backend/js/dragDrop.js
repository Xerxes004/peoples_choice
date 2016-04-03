$(document).ready(function() {
	$("#cart").find(".hide-in-cart").hide();
	$(".quantity-selector").change(postCart);

	calculatePrice();
});

function calculatePrice()
{
	var items = $("#cart").find(".item");
	var prices = $("#cart").find(".item-price");
	var sum = 0.0;
	for (var i = 0; i < prices.length; i++)
	{
		var numItems = $(items[i]).find(".quantity-selector").val();
		sum += parseFloat($(items[i]).find(".item-price").text() * parseInt(numItems));
	}
	$("#cart-total").text(" $" + parseFloat(sum).toFixed(2));
}

function populate(location) {
	var selected = [];
	$('#store input:checked').each(function() {
	    selected.push($(this).closest(".item"));
	});

	$($("#"+location).closest(".droppable")).append(selected);

	$("#cart").find(".hide-in-cart").hide();
	$("#store").find(".hide-in-cart").show();

	postCart();
}

function clearCart() {
	$("#store").append($("#cart").find(".item"));
	
	$("#cart").find(".hide-in-cart").hide();
	$("#store").find(".hide-in-cart").show();
	$("#store").find(".add-to-cart-checkbox").prop("checked", false);

	postCart();
}

function checkMyBox(id) {
	var checkbox = $("#"+id).find(".add-to-cart-checkbox");
	checkbox.prop("checked", !checkbox.prop("checked"));
}

function allowDrop(e) {
	e.preventDefault();
}

function drag(e) {
	e.dataTransfer.setData("text", e.target.id);
}

function drop(e) {
	e.preventDefault();
	
	var data = e.dataTransfer.getData("text");

	$(e.target.closest(".droppable")).append(document.getElementById(data));
	$("#cart").find(".hide-in-cart").hide();
	$("#store").find(".hide-in-cart").show();
	$("#store").find(".add-to-cart-checkbox").prop("checked", false);

	postCart();
}

function postCart(){
	calculatePrice();
	var cart = getCart();
	if(cart){
		$.post("http://judah.cedarville.edu/kelly/Project4", cart);
	}
}

function getCart(){
	var cartItems = [];
	var numItems = 0;
	$("#cart").find("tbody>tr").each(function(index){
		var item = $(this);
		var quantity = item.find(".quantity-selector").val();
		cartItems.push({itemID:item.attr("id"), quantity:quantity});
		numItems++;
	});
	var cartJSON = JSON.stringify(cartItems);
	console.log(cartJSON);
	
	if(numItems == 0){
		return null;
	}
	
	return {numIt:numItems, cart:cartJSON};
}
