<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title')</title>

    <link rel="stylesheet" href="/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>   
</head>

<body>
    
    <div class="container">
       <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-dark shadow-5-strong fixed-top navsize">
            <!-- Container wrapper -->
            <div class="container-fluid">
                <!-- Navbar brand -->
                <a class="navbar-brand" href="/landing">BOOK CAFE SYSTEM</a>
                <!-- Toggle button -->
                <button class="navbar-toggler"type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
                </button>

                <!-- Collapsible wrapper -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left links -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/landing">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/login">Login</a>
                        </li>  
                        <li class="nav-item">
                            <a class="nav-link" href="/collections">Collection</a>
                        </li>  
                </div>
                <!-- Collapsible wrapper -->
            </div>
            <!-- Container wrapper -->
            </nav>
            <!-- Navbar -->
        {{-- end of nav --}}           
        <h1 style="padding-top:50px;"></h1>

        @yield('content')

        {{--Footer--}}
    <footer>  
      <!-- Copyright -->
      <div class="text-center text-white p-3 fixed-bottom navbar-custom">
        © 2020 Copyright:
        <a class="text-white" href="https://mdbootstrap.com/">MDBootstrap.com</a>
      </div>
      <!-- Copyright -->
    </footer>
    <!-- Footer -->

  {{--JS bootstrap link--}}
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  
</div>
<script>
  @if(session('success'))
    alert('{{ session('success') }}');
  @endif
</script>

<div id="success-popup" style="display: none;">
  <p>Your form has been submitted successfully!</p>
</div>

</body>
</html>