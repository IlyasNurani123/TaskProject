    @extends('layouts.app')
    <script src="https://js.stripe.com/v3/"></script>
    @section('content')
    <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header"> Subscribe</div>
              <div class="card-body">
                {{-- <form> --}}
                  {{-- @csrf --}}
                  <div class="form-group">
                    <select class="custom-select mr-sm-2" id="subscription-plan" name="services">
                    @foreach ($plans as $key => $plan)
                    <option value="{{$key}}">{{$plan}}</option>
                    @endforeach
                    </select>
                    <label for="card-holder-name">Name</label>
                    <input id="card-holder-name" class="form-control mb-2" type="text">
                <!-- Stripe Elements Placeholder -->
                    <div id="card-element"></div>
                  </div>
                  <button class="btn btn-primary" id="card-button" data-secret="{{ $intent->client_secret }}">
                    {{-- <span class="spinner-border spinner-border-sm"></span> --}}
                    subscribe
                </button>
                {{-- </form> --}}
              </div>
            </div>
          </div>
        </div>
      </div>

{{-- </body> --}}
<script  type="application/javascript">

    window.addEventListener('load',function(){
     const stripe = Stripe('{{env('STRIPE_KEY')}}');
    const elements = stripe.elements();
    const cardElement = elements.create('card');

cardElement.mount('#card-element');

    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');
    const plan = document.getElementById('subscription-plan').value;
    const clientSecret = cardButton.dataset.secret;

cardButton.addEventListener('click', async (e) => {
    $("#card-button").attr('disabled',"true");
    const { setupIntent, error } = await stripe.confirmCardSetup(
        clientSecret, {
            payment_method: {
                card: cardElement,
                billing_details: { name: cardHolderName.value }
            }
        }
    );

    if (error) {
        console.log("error",error)
    } else {
        console.log('handling',setupIntent.payment_method);
        axios.post('/subscribe',{
            payment_method: setupIntent.payment_method,
            plan:plan
        }).then(response=>{
            $("#card-button").attr('disabled',"false");
            window.location.href = "/dashboard";
        }).catch(error =>{
            $("#card-button").attr('disabled',"false");
            console.log("there are some error",error);
        })
        // The card has been verified successfully...
    }
});
    });

</script>
@endsection
{{-- </html> --}}
