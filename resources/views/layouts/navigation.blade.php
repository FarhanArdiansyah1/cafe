<nav class="navbar navbar-expand-md navbar-light bg-white border-bottom sticky-top">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="/">
            <img src="{{ asset('img/logo.png') }}" alt="logo" style="object-fit: contain; width: 50px; height: 50px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                <x-nav-link href="{{ url('order') }}" :active="request()->routeIs('order')">
                    {{ __('Pesan') }}
                </x-nav-link>
                <x-nav-link href="{{ url('orders') }}" :active="request()->routeIs('orders')">
                    {{ __('Pesanan') }}
                </x-nav-link>
                @role(['admin', 'manager'])
                <x-nav-link href="{{ url('menu') }}" :active="request()->routeIs('orders')">
                    {{ __('Menu') }}
                </x-nav-link>
                @endrole
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav">

                <!-- Settings Dropdown -->
                @auth
                <div name="content">
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')"
                                         onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </div>
                @endauth
            </ul>
        </div>
    </div>
</nav>