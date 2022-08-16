<header class="bg-blue-900 py-6">
    <div class="container mx-auto flex justify-between items-center px-6">
        <div class="text-lg font-semibold text-gray-100 no-underline flex">
            @guest
                {{ config('app.name', 'Laravel') }}
            @else
                {{Auth::user()->name}}
            @endguest
        </div>
        <nav class="space-x-4 text-gray-300 text-sm sm:text-base">
            @guest
                <a class="no-underline hover:underline font-semibold" href="{{ route('login') }}">{{ __('Login') }}</a>
                @if (Route::has('register'))
                    <a class="no-underline hover:underline font-semibold" href="{{ route('register') }}">{{ __('Register') }}</a>
                @endif
            @else
                <a href="{{ route('logout') }}"
                    class="no-underline hover:underline font-semibold"
                    onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    {{ csrf_field() }}
                </form>
            @endguest
        </nav>
    </div>
</header>