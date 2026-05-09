@extends('layouts.master')
@section('content')

<!--PreLoader-->
<div class="loader">
    <div class="loader-inner">
        <div class="circle"></div>
    </div>
</div>
<!--PreLoader Ends-->

<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Fresh and Organic</p>
                    <h1>Check Out Product</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->

<!-- check out section -->
<div class="checkout-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="checkout-accordion-wrap">
                    <div class="accordion" id="accordionExample">
                      <div class="card single-accordion">
                        <div class="card-header" id="headingOne">
                          <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                              Billing Address
                            </button>
                          </h5>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                          <div class="card-body">
                            <div class="billing-address-form">
                                <form action="{{ route('checkout.process') }}" method="POST">
                                    @csrf
                                    <p><input type="text" name="customer_name" placeholder="Name" value="{{ old('customer_name', $user->name ?? '') }}" required></p>
                                    <p><input type="email" name="customer_email" placeholder="Email" value="{{ old('customer_email', $user->email ?? '') }}" required></p>
                                    <p><input type="text" name="customer_phone" placeholder="Phone" value="{{ old('customer_phone', $user->phone ?? '') }}" required></p>
                                    <p><input type="text" name="billing_address" placeholder="Address" value="{{ old('billing_address') }}" required></p>
                                    <p><textarea name="notes" id="bill" cols="30" rows="10" placeholder="Say Something">{{ old('notes') }}</textarea></p>
                                </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card single-accordion">
                        <div class="card-header" id="headingTwo">
                          <h5 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                              Shipping Address
                            </button>
                          </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                          <div class="card-body">
                            <div class="shipping-address-form">
                                <p>Your shipping address form is here.</p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card single-accordion">
                        <div class="card-header" id="headingThree">
                          <h5 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                              Card Details
                            </button>
                          </h5>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                          <div class="card-body">
                            <div class="card-details">
                                <p>Your card details goes here.</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-4">
                <div class="order-details-wrap">
                    <table class="order-details">
                        <thead>
                            <tr>
                                <th>Your order Details</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody class="order-details-body">
                            @foreach($cartItems as $item)
                            <tr>
                                <td>{{ $item->product->nameProduct }}</td>
                                <td>${{ number_format($item->product->priceProduct * $item->quantity, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tbody class="checkout-details">
                            <tr>
                                <td>Subtotal</td>
                                <td>${{ number_format($total, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Shipping</td>
                                <td>$50.00</td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td>${{ number_format($total + 50, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="submit" form="checkout-form" class="boxed-btn">Place Order</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end check out section -->

<!-- logo carousel -->
<div class="logo-carousel-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="logo-carousel-inner">
                    <div class="single-logo-item">
                        <img src="assets/img/company-logos/1.png" alt="">
                    </div>
                    <div class="single-logo-item">
                        <img src="assets/img/company-logos/2.png" alt="">
                    </div>
                    <div class="single-logo-item">
                        <img src="assets/img/company-logos/3.png" alt="">
                    </div>
                    <div class="single-logo-item">
                        <img src="assets/img/company-logos/4.png" alt="">
                    </div>
                    <div class="single-logo-item">
                        <img src="assets/img/company-logos/5.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end logo carousel -->

f

</body>
</html>

@endsection
