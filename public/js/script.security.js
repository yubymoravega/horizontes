// A reference to Stripe.js initialized with a fake API key.
//Sign in to see examples pre-filled with your key.
var stripe = Stripe(
  "pk_live_51HJlIfIqYTGPXQXuLsUVb5kempohAPBLEkW6EprE3lRgp7YoAsmuaUnq08XOAEZi6LFxynqCKeqPhNFvnUm7zz2p007ceFM7E1"
);
// The items the customer wants to buy

var monto = null;
var tel = null;

var split = window.location.pathname.split("/");

var purchase = {
  items: [{ id: "xl-tshirt", tel: split[2], monto: split[3], last4: split[4] }],
};
// Disable the button until we have Stripe set up on the page

if (split[4] === "injjn32522mnmn") {
  $("#mensaje").text("Proceso Completado");
  $("#mensaje").css({ color: "white" });
  $("#home").css({ display: "" });
  $("img").remove("#espere");
}

fetch(
  window.location.protocol +
    "//" +
    location.hostname +
    ":" +
    window.location.port +
    "/index.php/api.security",
  {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(purchase),
  }
)
  .then(function (result) {
    return result.json();
  })

  .then(function (intent) {
    if (intent) {
      if (!intent.error) {
        if (intent.mStatus === "succeeded") {
          $("#mensaje").text("Cobro Exitoso");
          $("#mensaje").css({ color: "white" });
          $("#mensaje").css({ "font-size": "25px" });
          $("#home").css({ display: "" });
          $("#espere").css({ display: "none" });
          $("#aprobada").css({ display: "" });
          history.pushState({}, null, "injjn32522mnmn");

          $.ajax({
            url:
              window.location.protocol +
              "//" +
              location.hostname +
              ":" +
              window.location.port +
              "/index.php/api.rep",
            method: "post",
            dataType: "json",
            data: { data: intent },
            success: function () {},
          });
        } else {
          $("#mensaje").text("Tarjeta Declinada");
          $("#mensaje").css({ "font-size": "25px" });
          $("#espere").css({ display: "none" });
          $("#diclinada").css({ display: "" });
          $("#mensaje").css({ color: "white" });
          $("#home").css({ display: "" });
          history.pushState({}, null, "injjn32522mnmn");
        }
      }
    }

    if (intent.error === "authentication_required") {
      // Pass the failed PaymentIntent to your client from your server
      stripe
        .confirmCardPayment(intent.clientSecret, {
          payment_method: intent.paymentMethod,
        })
        .then(function (result) {
          if (result.error) {
            intent.json.pi = result.error.payment_intent.id;
            intent.json.mStatus = result.error.message;
            // Show error to your customer
            $("#mensaje").text(result.error.message);
            $("#mensaje").css({ color: "white" });
            $("#mensaje").css({ "font-size": "25px" });
            $("#home").css({ display: "" });
            $("#espere").css({ display: "none" });
            $("#diclinada").css({ display: "" });
            history.pushState({}, null, "injjn32522mnmn");
            console.log(result);
          } else {
            intent.json.mStatus = result.paymentIntent.status;
            intent.json.pi = result.paymentIntent.id;

            if (result.paymentIntent.status === "succeeded") {
              // The payment is complete!
              $("#mensaje").text("Cobro Exitoso");
              $("#mensaje").css({ "font-size": "25px" });
              $("#mensaje").css({ color: "white" });
              $("#home").css({ display: "" });
              $("#espere").css({ display: "none" });
              $("#aprobada").css({ display: "" });
              history.pushState({}, null, "injjn32522mnmn");
            }
          }

          $.ajax({
            url:
              window.location.protocol +
              "//" +
              location.hostname +
              ":" +
              window.location.port +
              "/index.php/api.rep",
            method: "post",
            dataType: "json",
            data: { data: intent.json },
            success: function () {},
          });
        });
    }
  });
