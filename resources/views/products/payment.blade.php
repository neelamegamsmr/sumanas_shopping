@extends('layouts.app')

@section('content')
@extends('layouts.header')

<form action="{{ route('processPayment', [$product->name, $product->price]) }}" method="POST" id="subscribe-form">
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">
                <div class="subscription-option">
                    <label for="plan-silver">
                        <div>
                            <h1>{{ $product->name }}</h1>
                            <p>{{ $product->description }}</p>
                            <p>Price: ${{ $product->price }}</p>
                        </div>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div style="margin-bottom: 10px;">
        <label for="card-holder-name">Card Holder Name</label>
        <input id="card-holder-name" type="text" value="{{ $user->name }}" disabled>
    </div>
    @csrf
    <div class="form-row">
        <label for="card-element" style="margin-bottom: 10px;">Credit or debit card</label>
        <div id="card-element" class="form-control"> </div>
        <!-- Used to display form errors. -->
        <div id="card-errors" role="alert"></div>
    </div>
    <div class="stripe-errors"></div>
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
        {{ $error }}<br>
        @endforeach
    </div>
    @endif
    <div class="form-group text-center">
        <button type="button" id="card-button" data-secret="{{ $intent->client_secret }}" class="btn btn-lg btn-success btn-block" id="submitBtn" style="font-size: 10px;margin-top: 10px;">Proceed to Pay</button>
        <a href="{{ route('products.index') }}" class="btn btn-lg btn-secondary btn-block" style="font-size: 10px;margin-top: 10px;">Cancel</a>

    </div>

</form>
<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe('{{ env('STRIPE_KEY') }}');
    var elements = stripe.elements();
    var style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };
    var card = elements.create('card', {
        hidePostalCode: true,
        style: style
    });
    card.mount('#card-element');
    console.log(document.getElementById('card-element'));
    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;
    cardButton.addEventListener('click', async (e) => {
        console.log("attempting");
        const {
            setupIntent,
            error
        } = await stripe.confirmCardSetup(
            clientSecret, {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: cardHolderName.value
                    }
                }
            }
        );
        if (error) {
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = error.message;
        } else {
            paymentMethodHandler(setupIntent.payment_method);
        }
    });

    function paymentMethodHandler(payment_method) {
        var form = document.getElementById('subscribe-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'payment_method');
        hiddenInput.setAttribute('value', payment_method);
        form.appendChild(hiddenInput);
        form.submit();
    }
    // Add event listener to button
    document.getElementById('submitBtn').addEventListener('click', function() {
        // Show loader icon and disable button
        showLoader();

        // Perform action (e.g., AJAX request)
        // After action is complete, hide loader icon and enable button
        setTimeout(function() {
            hideLoader();
        }, 3000); // Simulating a 3-second delay for demonstration
    });

    // Show loader icon and disable button
    function showLoader() {
        document.getElementById('loaderIcon').style.display = 'inline-block';
        document.getElementById('submitBtn').setAttribute('disabled', 'disabled');
    }

    // Hide loader icon and enable button
    function hideLoader() {
        document.getElementById('loaderIcon').style.display = 'none';
        document.getElementById('submitBtn').removeAttribute('disabled');
    }
</script>
@endsection