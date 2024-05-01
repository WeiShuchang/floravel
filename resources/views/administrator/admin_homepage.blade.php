@extends('administrator.base')

@section('page_title', 'Administrator')

@section('content')
@if(session('success'))
    <div class="alert alert-success" role="alert" id="alert-message">
        {{ session('success') }}
    </div>
    @endif
<header class="py-5"  style="background-color:#196612">

        <div class="container px-5">
            <div class="row gx-5 align-items-center justify-content-center">
                <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center"><img class="img-fluid rounded-3 my-5" src="{{asset('home/images/floravel_bg.png')}}" alt="..." /></div>
                <div class="col-lg-8 col-xl-7 col-xxl-6">
                    <div class="my-5 text-center text-xl-start">
                        <h1 class="display-1 fw-bolder text-white mb-2 font-italic">Floravel Administrator</h1>
                        <p class="lead fw-normal text-white-50 mb-4">Welcome Admin!</p>
                        
                    </div>
                </div>
            </div>
        </div>
    </header>
<script>
        document.addEventListener("DOMContentLoaded", function() {
        // Get the alert message element
        let alertMessage = document.getElementById("alert-message");
        
        // Set timeout to hide the alert after 5000 milliseconds (5 seconds)
        setTimeout(function() {
            // Hide the alert by changing its display style to "none"
            alertMessage.style.display = "none";
        }, 4000); 
    });

</script>
@endsection