// A reference to Stripe.js initialized with a fake API key.
//Sign in to see examples pre-filled with your key.
var stripe = Stripe("pk_test_51GqMhfF2pLNIoJ5OZOn2hPgISbzCyX390U4JNhGqREy0ROZ7LYYZI6fWc2GX8afffee5RRiHkaob2siID4oBqgqA00YhsncFkb");
// The items the customer wants to buy
var customerID = null ;
var tel = null ;
var send = null;

var split = window.location.pathname.split('\/');
console.log(split);
var purchase = {
  items: [{ id: "xl-tshirt" , tel : split[2], monto: split[3]}]
};
// Disable the button until we have Stripe set up on the page
document.querySelector("button").disabled = true;
fetch('https://'+location.hostname+'/index.php/api.create', {
  method: "POST",
  headers: {
    "Content-Type": "application/json"
  },
  body: JSON.stringify(purchase)
})
  .then(function(result) {
  
    return result.json();
  })
  .then(function(data) {
    var elements = stripe.elements();
    var style = {
      base: {
        color: "#32325d",
        fontFamily: 'Arial, sans-serif',
        fontSmoothing: "antialiased",
        fontSize: "16px",
        "::placeholder": {
          color: "#32325d"
        }
      },
      invalid: {
        fontFamily: 'Arial, sans-serif',
        color: "#fa755a",
        iconColor: "#fa755a"
      }
    };
    var card = elements.create("card", { style: style });
    // Stripe injects an iframe into the DOM
    card.mount("#card-element");
    card.on("change", function (event) {
      // Disable the Pay button if there are no card details in the Element
      document.querySelector("button").disabled = event.empty;
      document.querySelector("#card-error").textContent = event.error ? event.error.message : "";
    });
    var form = document.getElementById("payment-form");
    form.addEventListener("submit", function(event) {
      event.preventDefault();
      // Complete payment when the submit button is clicked
      customerID = data.customer
      tel = data.tel;
     
      payWithCard(stripe, card, data.clientSecret);
    });
  });
// Calls stripe.confirmCardPayment
// If the card requires authentication Stripe shows a pop-up modal to
// prompt the user to enter authentication details without leaving your page.
var payWithCard = function(stripe, card, clientSecret) {
  loading(true);
  stripe
    .confirmCardPayment(clientSecret, {
      payment_method: {
        card: card,
        
      },
      setup_future_usage: 'off_session'
    })
    .then(function(result) {
      if (result.error) {
        // Show error to your customer
      
        var json = {};
        json['mPhoneNo'] = tel;
        json['mCardTypeID'] = result.error.payment_method.card.brand;
        json['mCard4'] =  result.error.payment_method.card.last4;
        json['mAmount'] = result.error.payment_intent.amount/100;
        json['mStatus'] = result.error.code
        json['pi'] = result.error.payment_intent.id;

        $.ajax({url:'https://'+location.hostname+'/index.php/api.rep',method:'post',dataType : 'json',
        data:{'data': json}, 
        success: function(){}});

      
        showError(result.error.message);
      } else {

        // The payment succeeded!
          orderComplete(result.paymentIntent.id);
       $.ajax({url:'https://'+location.hostname+'/index.php/api.status',method:'post',
       data:{"status":result.paymentIntent.status,"customer":customerID,'metodoPago':result.paymentIntent.payment_method,'tel':tel , 'monto':split[4]},
       success: function(data) { data = JSON.parse(data); data.pi = result.paymentIntent.id;

        $.ajax({url:'https://'+location.hostname+'/index.php/api.rep',method:'post',dataType : 'json',
        data:{'data': data}, 
        success: function(){}});
            },    
      });
      
      }
    });
};
/* ------- UI helpers ------- */
// Shows a success message when the payment is complete
var orderComplete = function(paymentIntentId) {
  loading(false);
  document
    .querySelector(".result-message a")
    .setAttribute(
      "href",
      "https://dashboard.stripe.com/test/payments/" + paymentIntentId
    );
  document.querySelector(".result-message").classList.remove("hidden");
  document.querySelector("button").disabled = true;

};
// Show the customer the error from Stripe if their card fails to charge
var showError = function(errorMsgText) {
  loading(false);
  var errorMsg = document.querySelector("#card-error");
  errorMsg.textContent = errorMsgText;
};
// Show a spinner on payment submission
var loading = function(isLoading) {
  if (isLoading) {
    // Disable the button and show a spinner
    document.querySelector("button").disabled = true;
    document.querySelector("#spinner").classList.remove("hidden");
    document.querySelector("#button-text").classList.add("hidden");
  } else {
    document.querySelector("button").disabled = false;
    document.querySelector("#spinner").classList.add("hidden");
    document.querySelector("#button-text").classList.remove("hidden");
  }
};