<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />



        {{-- <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"> --}}
        <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="loader">
            <div class="letters">
              <canvas id="canvas"></canvas>
            </div>
          </div>
          <video autoplay loop muted id="background-video">
            <source src="{{ asset('assets/videos/vid_background.mp4') }}" type="video/mp4">
          </video>
          <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')
            
            <!-- Page Heading -->
            @if (isset($header))
            <header class="shadow">
              <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <footer class="px-5 bottom-0 d-flex flex-wrap justify-content-between align-items-center py-4 mt-5">
            <p class="col-md-4 mb-0 text-muted">&copy; 2023 Ray AGUE - Tous droits réservés.</p>
        
            <ul class="nav col-md-4 justify-content-center ">
              <li class="nav-item"><a href="{{ route('quiSommesNous') }}" class="nav-link px-2 text-muted">Qui sommes-nous</a></li>
              <li class="nav-item"><a href="{{ route('supports') }}" class="nav-link px-2 text-muted">Supports</a></li>
              <li class="nav-item"><a href="{{ route('politiqueConfidentialite') }}" class="nav-link px-2 text-muted">Politique de confidentialité</a></li>
              <li class="nav-item"><a href="{{ route('faqs') }}" class="nav-link px-2 text-muted">FAQs</a></li>
              <li class="nav-item"><a href="{{ route('temoignages') }}" class="nav-link px-2 text-muted">Témoignages</a></li>
              <li class="nav-item"><a href="{{ route('nousContacter') }}" class="nav-link px-2 text-muted">Nous contacter</a></li>
              </ul>


            <span href="/" class="col-md-4 d-flex align-items-end justify-content-end mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
              <svg class="bi me-2" width="40" height="32"><use xlink:href="#facebook"/></svg>
              <svg class="bi me-2" width="40" height="32"><use xlink:href="#instagram"/></svg>
              <svg class="bi me-2" width="40" height="32"><use xlink:href="#linkedin"/></svg>
            </span>
                
                    {{-- <button id="back-to-top-btn" class="btn btn-primary btn-sm text-light p-3" onclick="scrollToTop()">
                      &uarr;
                  </button> --}}
          </footer>
        <script src="{{ asset('assets/js/loader.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script> 
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script> 
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> 
         <script src="{{ asset('assets/js/script.js') }}"></script> 
         <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        
    </body>
</html>
