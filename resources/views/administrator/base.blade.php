<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>@yield('page_title')</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link href="{{ asset('home/css/styles.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset( 'home/css/homestyles.css' )}}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Delius+Swash+Caps&family=Mystery+Quest&family=Spicy+Rice&display=swap" rel="stylesheet">

<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>


    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
            
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="/administrator">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('flowers.index') }}">Flowers</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('suppliers.index') }}">Suppliers</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('categories.index') }}">Categories</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('flowersuppliers.index') }}">Flower-Supplier</a></li>
                    </ul>
                    <ul class="navbar-nav">
            
                  <li class="nav-item"><a class="mx-3 nav-link left" aria-current="page" href="{{route('orders.show_pending_orders')}}">Pending Orders</a></li>
                  <li class="nav-item"><a class="mx-3 nav-link left" aria-current="page" href="{{route('orders.show_shipped_orders')}}">Shipped Orders</a></li>
                  <li class="nav-item"><a class="mx-3 nav-link left" aria-current="page" href="{{route('orders.show_delivered_orders')}}">Delivered Orders</a></li>
            @if (Auth::check())
              <li class="nav-item">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="mx-3 nav-link left">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              </li>
            @else
              <li class="nav-item">
                <a class="nav-link mx-3" href="{{ route('login') }}">Login</a>
              </li>
            @endif
          </ul>
          
                </div>
            </div>
        </nav>

        @yield('content')
        
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
      
        
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
