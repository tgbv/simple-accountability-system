<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title')</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <style>

        /* sidenav */
        header, main, footer {
            padding-left: 300px;
        }

        @media only screen and (max-width : 992px) {
            header, main, footer {
                padding-left: 0;
            }
        }

        .main-sidenav {
            border-right: 1px solid lightgray;
        }

        /* footer */
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        main {
            flex: 1 0 auto;
        }

        footer {
            border-top: 1px solid lightgray;
        }

        /* main navbar */
        .main-navbar {
            border-bottom: 1px solid lightgray;
        }
        .main-navbar ul a {
            color: black;
        }

    </style>

    @yield('head')
</head>
<body>

    {{-- header  --}}
    <header>

        <!--- sidenav --->
        <ul id="slide-out" class="main-sidenav sidenav sidenav-fixed z-depth-0">
            <li><a href="{{ route('categories') }}">Categories</a></li>
            <li><a href="#!">Entities</a></li>
        </ul>

        {{-- language dropdown --}}
        <ul id="lang-dropdown" class="dropdown-content">
            <li><a href="#!">RO</a></li>
            <li><a href="#!">EN</a></li>
        </ul>

        {{-- navbaaar --}}
        <nav class="main-navbar z-depth-0">
            <div class="nav-wrapper white ">
                {{-- <a href="#" class="brand-logo">Logo</a> --}}

                {{-- MED/SMALL SCREEN NAVBARS --}}
                <ul id="nav-mobile" class="left ">
                    <li class="hide-on-large-only">
                        <a data-target="slide-out" class="sidenav-trigger "> <i class="material-icons">menu</i> </a>
                    </li>
                </ul>


                {{-- LARGE SCREEN NAVBARs --}}
                <ul id="nav-mobile" class="left ">
                    @yield('navbar-left')

                </ul>
                <ul id="nav-mobile" class="right hide-on-med-and-down ">
                    @yield('navbar-right')

                    <li>
                        <a href="#!" class="dropdown-trigger " data-target="lang-dropdown">
                            <span>Lang</span>
                            <i class="material-icons right ">arrow_drop_down</i>
                        </a>
                    </li>
                    <li><a href="collapsible.html">Logout</a></li>
                </ul>
            </div>
            </nav>
    </header>

    {{-- main content --}}
    <main>
        <div class="row">
            <div class="col s12">

@yield('main')

            </div>
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="page-footer">
        <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="white-text">Footer Content</h5>
                <p class="grey-text text-lighten-4">You can use rows and columns here to organize your footer content.</p>
              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Links</h5>
                <ul>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
            © 2014 Copyright Text
            <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
            </div>
          </div>
    </footer>

    {{-- some scripts --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    {{-- if it's dev env we can afford to have full length scripts --}}
    @if(config('app.env') === 'dev')
        <script src="https://vuejs.org/js/vue.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.js" integrity="sha512-otOZr2EcknK9a5aa3BbMR9XOjYKtxxscwyRHN6zmdXuRfJ5uApkHB7cz1laWk2g8RKLzV9qv/fl3RPwfCuoxHQ==" crossorigin="anonymous"></script>
    @else
        <script src="https://vuejs.org/js/vue.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js" integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ==" crossorigin="anonymous"></script>
    @endif

    <script>
        /*
        *   util functions
        */
        const link = function(url){
            window.location = url
        }
        const _ = function(el_id){
           return document.getElementById(el_id)
        }
        const toast = function(message){
            return M.toast({html: message})
        }

        /*
        *   configure axios interceptors for response
        */
        axios.interceptors.response.use(response=>{
            return response
        }, error=>{
            toast(error.response.data.message)
            return Promise.reject(error.message)
        })

        /*
        *   material design init
        */
        M.Sidenav.init( document.querySelectorAll('.sidenav') )
        // M.Modal.init( document.querySelectorAll('.modal') )
        M.Dropdown.init( document.querySelectorAll('.dropdown-trigger') )
        M.Tooltip.init( document.querySelectorAll('.tooltipped') )
    </script>

    <script>
        @yield('script')
    </script>


    {{-- Before End Of Body --}}
    @yield('BEOB')
</body>
</html>
