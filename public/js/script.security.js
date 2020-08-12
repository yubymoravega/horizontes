// A reference to Stripe.js initialized with a fake API key.
//Sign in to see examples pre-filled with your key.
var stripe = Stripe("pk_test_51GqMhfF2pLNIoJ5OZOn2hPgISbzCyX390U4JNhGqREy0ROZ7LYYZI6fWc2GX8afffee5RRiHkaob2siID4oBqgqA00YhsncFkb");
// The items the customer wants to buy

var monto = null ;
var tel = null ;

var split = window.location.pathname.split('\/');

var purchase = {
  items: [{ id: "xl-tshirt" , tel : split[3], monto: split[4], last4: split[5]}]
};
// Disable the button until we have Stripe set up on the page


if(split[5] === 'token123456qwer'){

  $("#mensaje").text("Proceso Completado");
  $("#mensaje").css({'color':'black'}); 
  $("#home").css({'display':''}); 

}

fetch("http://127.0.0.1/index.php/api.security", {
  method: "POST",
  headers: {
    "Content-Type": "application/json"
  },
  body: JSON.stringify(purchase)
})
.then(function(result) 
{
  return result.json();
})

.then(function(intent) {
  
    if(intent.mStatus){ 
   
      if(intent.mStatus === 'succeeded'){

        $.ajax({url:'https://www.horizontesclub.com/simplerest/api/person/Stripe_Card_Transaction',method:'post',
        dataType : 'json', data:{'data': intent}});

      $("#mensaje").text("Cobro Exitoso");
      $("#mensaje").css({'color':'green'}); 
      $("#home").css({'display':''}); 
      history.pushState({}, null, 'token123456qwer');

    }else{

      $("#mensaje").text("Tarjeta Declinada");
      $("#mensaje").css({'color':'red'}); 
      $("#home").css({'display':''}); 
      history.pushState({}, null, 'token123456qwer');
    }  
    }

  if(intent.error === 'authentication_required'){

 // Pass the failed PaymentIntent to your client from your server
 stripe.confirmCardPayment(intent.clientSecret, {
  payment_method: intent.paymentMethod
}).then(function(result) {


  if (result.error) {

    // Show error to your customer
    $("#mensaje").text(result.error.message);
    $("#mensaje").css({'color':'red'});
    $("#home").css({'display':''}); 
    history.pushState({}, null, 'token=123456qwer');

  } else {

    if (result.paymentIntent.status === 'succeeded') {

      intent.json.mStatus = result.paymentIntent.status;

      $.ajax({url:'https://www.horizontesclub.com/simplerest/api/person/Stripe_Card_Transaction',method:'post',
      dataType : 'json', data:{'data': intent.json}});

      // The payment is complete!
      $("#mensaje").text("Cobro Exitoso");
      $("#mensaje").css({'color':'green'});
      $("#home").css({'display':''}); 
      history.pushState({}, null, 'token=123456qwer');    

    }
  }

  

});}


});  




 