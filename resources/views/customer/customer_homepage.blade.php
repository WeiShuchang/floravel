@extends('customer.base')

@section('page_title', 'homepage')

@section('content')

<body class="main-layout">

<section>
    <div id="main_slider" class="carousel slide banner-main" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#main_slider" data-slide-to="0" class="active"></li>
            <li data-target="#main_slider" data-slide-to="1"></li>
            <li data-target="#main_slider" data-slide-to="2"></li>
        </ol>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="container">
                    <div class="row marginii">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            @if(session('success'))
                                <div class="alert alert-success" role="alert" id="alert-message">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <div class="alert alert-info" role="alert">
                                <ul>
                                    <li class="text-warning">You have {{ $pendingCount }} pending orders</li>
                                    <li class="text-primary">You have {{ $shippingCount }} orders being shipped</li>
                                    <li class="text-success">You have {{ $deliveredCount }} orders delivered</li>
                                </ul>
                            </div>
                            <div class="carousel-caption ">
                                <h1><strong class="color">Welcome {{ auth()->user()->name }}!</strong></h1>
                                <p>Your Favorite Flower Shop!</p>
                                <a class="btn btn-lg btn-primary" href="{{route('orders.index')}}" role="button">Shop Now</a>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="img-box">
                                <figure><img src="{{ asset('images/gyufyufyu.png') }}" alt="img"/></figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@if($userCancelledCount >= 1)
<div class="modal fade" id="viewDeliveredModal" tabindex="-1" role="dialog" aria-labelledby="viewDeliveredModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title" id="viewDeliveredModalLabel">Order Cancelled</h5>
                <button type="button" class="close" aria-label="Close" id="closeModalButtonJS">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="text-align: center;">
                <p>You have {{$userCancelledCount}} cancelled order(s)</p>
            </div>
                <form action="{{route('notify_cancel_func')}}" method="POST" style="display:flex; justify-content:center;background:none">
                    @csrf
                    <button type="submit" class="btn btn-primary">View</button>
                </form>
               
        </div>
    </div>
</div>
@endif



<!-- Your JavaScript files -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/jquery-3.0.0.min.js') }}"></script>
<script src="{{ asset('js/plugin.js') }}"></script>
<script src="{{ asset('js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('js/owl.carousel.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
<script>
    $(document).ready(function(){
        // Show modal when document is ready (remove this if not desired)
        $('#viewDeliveredModal').modal('show');

        $(".fancybox").fancybox({
            openEffect: "none",
            closeEffect: "none"
        });

        $(".zoom").hover(function(){
            $(this).addClass('transition');
        }, function(){
            $(this).removeClass('transition');
        });

        // Hide success message after 5 seconds
        let alertMessage = document.getElementById("alert-message");
        setTimeout(function() {
            alertMessage.style.display = "none";
        }, 5000); 
    });

    $(document).ready(function(){
        // Function to close the modal when the close button is clicked
        $('#closeModalButtonJS').click(function(){
            $('#viewDeliveredModal').modal('hide');
        });
    });
</script>
</body>
</html>

@endsection