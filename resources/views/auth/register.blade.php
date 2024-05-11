@extends('base')

@section('page_title', 'Log-in')

@section('content')
<section class="" style="background-color: #fff; margin-top:150px;">
  <div class="container py-2 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="{{asset('home/images/image_1.jpeg')}}"
                alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
            </div>
            <div class="col-md-6 col-lg-7 align-items-center  bg-light">
              <div class="card-body   text-white">

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                  <h5 class="fw-normal mb-1 text-white" style="letter-spacing: 1px;">Create An Account</h5>
                  
                  <div data-mdb-input-init class="form-outline ">
                    <input type="text" id="form2Example17" class="form-control form-control-sm" name="name"/>
                    <label class="form-label" for="form2Example17" >Name</label>
                  </div>

                  <div data-mdb-input-init class="form-outline ">
                    <input type="email" id="form2Example17" class="form-control form-control-sm" name="email"/>
                    <label class="form-label" for="form2Example17">Email address</label>
                  </div>

                  <div data-mdb-input-init class="form-outline ">
                    <input type="password" id="form2Example27" class="form-control form-control-sm" name="password" />
                    <label class="form-label" for="form2Example27">Password</label>
                  </div>

                  <div data-mdb-input-init class="form-outline ">
                    <input type="password" id="form2Example27" class="form-control form-control-sm" name="password_confirmation" />
                    <label class="form-label" for="form2Example27">Confirm Password</label>
                  </div>

                  <div class="pt-1 mb-1">
                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-lg btn-block" type="submit" >Sign Up</button>
                  </div>

                
                  <div>Already have an account? <a href="/login"
                      style="color: black;background-color:white;background:none;">Login Here!</a></div>
       
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<script>
    // Ensure the DOM is loaded before accessing elements
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
