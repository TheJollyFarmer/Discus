<nav
        class="navbar is-fixed-top is-primary"
        role="navigation"
        aria-label="main navigation"
        style="box-shadow: 0 1px 10px #999">
    <div class="container">
        <div class="navbar-brand">
            <!-- Branding Image -->
            <a class="navbar-item" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <!-- Collapsed Hamburger -->
            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div class="navbar-menu" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <div class="navbar-start">
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        Channels
                    </a>

                    <div class="navbar-dropdown">
                        @foreach ($channels as $channel)
                            <a class="navbar-item" href="/threads/{{ $channel->slug }}">{{ $channel->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Right Side Of Navbar -->
            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="control has-icons-left has-icons-right">
                        <input class="input" type="text" placeholder="Search for something..." name="q">
                        <span class="icon is-small is-left">
                            <i class="fas fa-search"></i>
                        </span>
                        <span class="icon is-small is-right">
                            <i class="fas fa-times-circle"></i>
                        </span>
                    </div>
                </div>
            @if (Auth::guest())
                <!-- Authentication Links -->
                    <a class="navbar-item" href="{{ route('login') }}">Login</a>
                    <a class="navbar-item" href="{{ route('register') }}">Register</a>
            </div>
            @else
                <nav-links
                        :channels="{{ $channels }}"
                        recapt="{{ config("services.recaptcha.key") }}"/>
            @endif

        </div>
    </div>
</nav>