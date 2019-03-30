/*price range*/

 $('#sl2').slider();
 $('.catalog').dcAccordion({
	 speed: 300
 });

 /*function priceRange(event) {
     var price = $('#price-field').val().serialize();
     $.ajax({
         url: '/',
         type: 'post',
         data: price,
         success: function () {
             console.log('Ajax request is sent');
         },
         error: function () {
             console.log('Произошла ошибка!');
         }
     });
     event.preventDefault();
 }*/

 function showCart(cart) {
 	$('#cart .modal-body').html(cart);
 	$('#cart').modal();
 }


 
 function clearCart() {
     $.ajax({
         url: '/cart/clear',
         type: 'get',
         success: function(result) {
             if (!result) {
                 alert('Cart error');
             }
             showCart(result);
         },
         error: function() {
             alert('Error');
         }

     });
 }
 
 function getCart() {
     $.ajax({
         url: '/cart/show',
         type: 'get',
         success: function(result) {
             if (!result) {
                 alert('Cart error');
             }
             showCart(result);
         },
         error: function() {
             alert('Error');
         }

     });
	 return false; // Отменяем переход по ссылке

 }

 $('#cart .modal-body').on('click', '.del-item', function () {
		var id = $(this).data('id');
     $.ajax({
         url: '/cart/remove-item',
         data: {id: id},
         type: 'get',
         success: function(result) {
             if (!result) {
                 alert('Cart error');
             }
             showCart(result);
             //console.log(result);
         },
         error: function() {
             alert('Error');
         }

     });

 });

 $('.add-to-cart').on('click', function(event) {
 	event.preventDefault(); // or return false
	 var id = $(this).data('id');
	 var quantity = $('#quantity').val();
	 $.ajax({
		 url: '/cart/add',
		 data: {id: id, quantity: quantity},
		 type: 'get',
		 success: function(result) {
		 	if (!result) {
		 		alert('Cart error');
			}
             showCart(result);
             //console.log(result);
		 },
		 error: function() {
		 	alert('Error');
		 }

	 });

 });
	var RGBChange = function() {
	  $('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
	};	
		
/*scroll to top*/

$(document).ready(function(){

	$(function () {
		$.scrollUp({
	        scrollName: 'scrollUp', // Element ID
	        scrollDistance: 300, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 300, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 200, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
	});


	$('#system-search').keyup(function () {
        var x = $(this).val();
        if(x.length < 1 ) {
            return;
        }
            $.ajax({
                type: 'GET',
                url: '/category/search',
                data: 'search='+x,
                success: function (data) {
                    $('#livesearch').html(data);
                },
            });
    });

    $('#price-range-accept').bind('click', function(event) {
        event.preventDefault();
        $.get('/category/index', {
            price: $('#price-field').val()
        }, function(data) {
            data = JSON.parse(data);
            $( "#features_items" ).load( "/" );
            console.log('DONE!!!');
        });
    });

/*

    $(function(){
        $('#price-form').on('click', function(e){
            var data = $("#price-field").val();
            $.ajax({
                url: '/category/index',
                type: 'POST',
                data: {data: data},
                success: function(){
                        $('.features_items').load('.features_items');
                },
                error: function(){
                    console.log('Ajax IS NOT being worked');
                }
        });
            e.preventDefault();
        });
    });
*/



    function clicked() {
        $($(this).innerHTML).addClass('active');
    }

    if(document.getElementsByClassName('nav nav-tabs')[0].getElementsByTagName('li')[0].className === 'active') {
        $(document.querySelectorAll('#jeans')).addClass('active');
    }
});
