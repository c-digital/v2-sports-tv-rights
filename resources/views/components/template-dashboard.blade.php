<!DOCTYPE html>
<html lang="{{ config('language') }}">
<head>
<meta charset="{{ config('charset') }}">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Sports TV Rights">
<meta name="theme-color" content="#212529">

<meta name="htmx-config" content='{"timeout":"600000"}'>

<title>{{ config('application_name') }}</title>

<link rel="icon" href="{{ asset('img/logo-index.png') }}">

<link rel="stylesheet" href="{{ node('flowbite/dist/flowbite.css') }}">
<link rel="stylesheet" href="{{ node('@fortawesome/fontawesome-free/css/all.css') }}">
<link rel="stylesheet" href="{{ node('sweetalert2/dist/sweetalert2.css') }}">

<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet" href="{{ asset('css/v3.all.opta-widgets.css') }}">
{{-- <link rel="stylesheet" href="https://secure.widget.cloud.opta.net/v3/css/v3.all.opta-widgets.css"> --}}

<style>
    @font-face {
        font-family: soulcraftgx;
        src: url('https://api-v2.sportstvrights.com/resources/assets/fonts/soulcraftgx.ttf');
    }

    .soulcraftg {
        font-family: soulcraftgx;
    }

    .wg_modal {
        z-index: 100 !important;
    }

    .Opta .Opta-H2, .Opta h2 {
        background-color: #132141 !important;
    }

    .bg-blue-tigo, .btn-blue-tigo {
        background-color: #071029 !important;
    }

    .bg-blue-tigo-1 {
        background-color: #132141;
    }

    select, input {
        color: black !important;
    }

    th, td {
        color: black !important;
    }

    @if(strpos($_SERVER['REQUEST_URI'], 'copa') || get('competition') == 593)
        nav {
            background-image: url('https://api-v2.sportstvrights.com/resources/assets/img/navbar-copa.png');
            background-size: 100% 100%;
        }

        body {
            background: url('{{ asset('img/fondo-copa.jpg') }}');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

        .match-btn, .match-btn:hover, .match-btn:focus {
            background-color: #ffbe00 !important;
            border-color: #ffbe00 !important;
            font-family: soulcraftgx;
        }

    @else
        nav {
            background-image: url('https://api-v2.sportstvrights.com/resources/assets/img/navbar-liga.png');
            background-size: 100% 100%;
        }

        body {
            background: url('{{ asset('img/fondo-liga.jpg') }}');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

        .match-btn, .match-btn:hover, .match-btn:focus {
            background-color: #132141 !important;
            border-color: #132141 !important;
            font-family: soulcraftgx;
        }
    @endif
</style>

</head>

<body x-data="app()" class="bg-gray-100 font-sans leading-normal tracking-normal">
    <nav style="" class="bg-blue-tigo fixed w-full z-10 top-0 shadow">
        <div class="w-full container mx-auto flex flex-wrap items-center mt-0 pt-3 pb-3 md:pb-0">
            <div class="w-1/2 pl-2 md:pl-0">
                <a class="text-gray-900 text-base xl:text-xl no-underline hover:no-underline font-bold" href="/dashboard">
                    <img class="w-1/3" src="{{ asset('img/transparente.png') }}" alt="Logo">
                </a>
            </div>

            <div class="w-1/2 pr-0">
                <div class="flex relative inline-block float-right">
                    <div class="relative text-sm">
                        <button x-on:click="showUserMenu = !showUserMenu" class="flex items-center focus:outline-none mr-3">
                            <img class="w-8 h-8 rounded-full mr-4" src="{{ auth()->photo }}" alt="Avatar of User"> 
                            <span class="hidden md:inline-block text-white">{{ auth()->name }}</span>
                        </button>

                        <div x-show="showUserMenu" class="bg-blue-tigo rounded shadow-md mt-2 absolute mt-12 top-0 right-0 min-w-full overflow-auto z-30">
                            <ul class="list-reset">
                                <li>
                                    <a href="{{ '/dashboard/users/edit/' . auth()->id }}" class="px-4 py-2 block text-white no-underline hover:no-underline">{{ lang('dashboard.profile') }}</a>
                                </li>

                                <li>
                                    <a href="/logout" class="px-4 py-2 block text-white no-underline hover:no-underline">{{ lang('dashboard.logout') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="block lg:hidden pr-4">
                        <button x-on:click="showMainMenu = !showMainMenu" class="flex items-center px-3 py-2 border rounded text-white border-gray-600 hover:border-teal-500 appearance-none focus:outline-none">
                            <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <title>{{ lang('dashboard.menu') }}</title>
                                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z">
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div x-show="showMainMenu" class="mainMenu w-full flex-grow lg:flex lg:items-center lg:w-auto lg:block mt-2 lg:mt-0 z-20">
                <ul class="list-reset lg:flex flex-1 items-center px-4 md:px-0">
                    <li class="mr-2 my-2 md:my-0">
                        <a href="/dashboard" class="{{ ($active == 'home') ? 'block py-1 md:py-3 pl-1 align-middle text-[#FFC200] no-underline border-b-2 border-[#FFC200] hover:border-[#FFC200]' : 'block py-1 md:py-3 pl-1 align-middle text-white no-underline border-b-2 border-white hover:border-silver-500' }}">
                            <i class="fas fa-home fa-fw mr-2 text-silver-600"></i> <span class="pb-1 md:pb-0 text-sm">{{ lang('dashboard.home') }}</span>
                        </a>
                    </li>

                    <li class="mr-2 my-2 md:my-0">
                        <a href="/bolivia/liga" class="{{ ($active == 'bolivia.liga') ? 'block py-1 md:py-3 pl-1 align-middle text-[#FFC200] no-underline border-b-2 border-[#FFC200] hover:border-[#FFC200]' : 'block py-1 md:py-3 pl-1 align-middle text-white no-underline border-b-2 border-white hover:border-[#FFC200]' }}">
                            <i class="fas fa-futbol fa-fw mr-2 text-silver-600"></i> <span class="pb-1 md:pb-0 text-sm">{{ 'Liga Tigo FBF' }}</span>
                        </a>
                    </li>

                    <li class="mr-2 my-2 md:my-0">
                        <a href="/bolivia/copa" class="{{ ($active == 'bolivia.copa') ? 'block py-1 md:py-3 pl-1 align-middle text-[#FFC200] no-underline border-b-2 border-[#FFC200] hover:border-[#FFC200]' : 'block py-1 md:py-3 pl-1 align-middle text-white no-underline border-b-2 border-white hover:border-[#FFC200]' }}">
                            <i class="fas fa-futbol fa-fw mr-2 text-silver-600"></i> <span class="pb-1 md:pb-0 text-sm">{{ 'Copa Tigo FBF' }}</span>
                        </a>
                    </li>

                    @if(auth()->role == 'producer' || auth()->role == 'admin')                    
                        <li class="mr-2 my-2 md:my-0">
                            <a href="/export" class="{{ ($active == 'export') ? 'block py-1 md:py-3 pl-1 align-middle text-[#FFC200] no-underline border-b-2 border-[#FFC200] hover:border-[#FFC200]' : 'block py-1 md:py-3 pl-1 align-middle text-white no-underline border-b-2 border-white hover:border-[#FFC200]' }}">
                                <i class="fas fa-download fa-fw mr-2"></i> <span class="pb-1 md:pb-0 text-sm">Exportar datos</span>
                            </a>
                        </li>
                    @endif

                    @if(auth()->role == 'admin')
                        <li class="mr-3 my-2 md:my-0">
                            <a href="/dashboard/users" class="{{ ($active == 'users') ? 'block py-1 md:py-3 pl-1 align-middle text-[#FFC200] no-underline border-b-2 border-[#FFC200] hover:border-[#FFC200]' : 'block py-1 md:py-3 pl-1 align-middle text-white no-underline border-b-2 hover:border-[#FFC200]' }}">
                                <i class="fas fa-users fa-fw mr-3"></i> <span class="pb-1 md:pb-0 text-sm">{{ lang('dashboard.users') }}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container w-full mx-auto pt-20">
        <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-white leading-normal">
            <div class="flex flex-wrap">
                {{ $slot }}
            </div>
        </div>
    </div>

    <footer class="text-white text-center mb-5">
        <center>Powered by <img width="150px" src="https://sportstvrights.com/wp-content/uploads/2022/06/SPORTSTVRIGHTS-CON-BOCETO-BLANCO.png" alt=""></center>
    </footer>

    <input type="hidden" id="confirm_delete_text" value="{{ lang('users.confirm_delete_text') }}">
    <input type="hidden" id="confirm_delete_accept" value="{{ lang('users.confirm_delete_accept') }}">
    <input type="hidden" id="confirm_delete_cancel" value="{{ lang('users.confirm_delete_cancel') }}">

    <script src="{{ node('flowbite/dist/flowbite.js') }}" defer></script>
    <script src="{{ node('alpinejs/dist/cdn.js') }}" defer></script>
    <script src="{{ node('sweetalert2/dist/sweetalert2.js') }}"></script>
    <script src="{{ node('htmx.org/dist/htmx.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <script type="module" src="https://widgets.api-sports.io/2.0.3/widgets.js"></script>

     <script src="https://secure.widget.cloud.opta.net/v3/v3.opta-widgets.js"></script>

    <script>
        var opta_settings = {
            subscription_id: 'e2d5d74052a8b20e5601161fc71896ce',
            language: 'es_ES',
            timezone: 'America/La_Paz'
        };
    </script>
</body>
</html>