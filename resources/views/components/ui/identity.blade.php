@auth
    <form method="post" action="{{ route('logout') }}" class="flex gap-2 p-0 m-0">
        @csrf
        <x-ui.nav.button type="submit">Logout</x-ui.nav.button>
        <div class="py-1.5 text-gray-400 text-xs">
            ({{ auth()?->user()?->name }})
        </div>
    </form>
@endauth
@guest
    <div class="flex gap-2 items-center">
        <x-ui.nav.link href="{{ route('login') }}">Login</x-ui.nav.link>
        <x-ui.nav.link href="{{ route('register') }}">Register</x-ui.nav.link>
    </div>
@endguest
