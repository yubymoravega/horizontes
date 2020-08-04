// A reference to Stripe.js initialized with a fake API key.
//Sign in to see examples pre-filled with your key.
var stripe = Stripe("pk_test_51GqMhfF2pLNIoJ5OZOn2hPgISbzCyX390U4JNhGqREy0ROZ7LYYZI6fWc2GX8afffee5RRiHkaob2siID4oBqgqA00YhsncFkb");
// The items the customer wants to buy

var monto = null ;
var tel = null ;

var split = window.location.pathname.split('\/');

var purchase = {
  items: [{ id: "xl-tshirt" , tel : split[3], monto: split[4]}]
};
// Disable the button until we have Stripe set up on the page

fetch("http://127.0.0.1/index.php/api.security", {
  method: "POST",
  headers: {
    "Content-Type": "application/json"
  },
  body: JSON.stringify(purchase)
})
.then(function(result) {
  
  return result.json();
})

.then(function(intent) {

  console.log(intent);

 // Pass the failed PaymentIntent to your client from your server
 stripe.confirmCardPayment(intent.clientSecret, {
  payment_method: intent.paymentMethod
}).then(function(result) {
  if (result.error) {
    // Show error to your customer
    console.log(result.error.message);
  } else {
    if (result.paymentIntent.status === 'succeeded') {
      // The payment is complete!
    }
  }
});

});


 