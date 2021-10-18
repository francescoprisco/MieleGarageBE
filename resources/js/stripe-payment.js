$( document ).ready(function() {
    "use strict";

    stripe.redirectToCheckout({ sessionId: sessionId });

});
