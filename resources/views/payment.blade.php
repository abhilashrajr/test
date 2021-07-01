<script src="https://js.stripe.com/v3/"></script>
        <script>
            var stripe = Stripe('{{$purcahse_key}}', {stripeAccount: '{{$restaurant->stripe_id}}'});
            stripe.redirectToCheckout({
                sessionId: '{{$session->id}}'
            }).then(function (result) {

                // using `result.error.message`.
            });
        </script>
