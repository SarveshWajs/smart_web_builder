<!DOCTYPE html>
<html>
<head>
    <title>Smart Web Builder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
      :class="darkMode ? 'bg-dark text-white' : 'bg-light text-dark'">

    {{-- Header --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Smart Web Builder</a>

            <div class="d-flex ms-auto align-items-center">
                @auth
                    <span class="text-white me-3">Hi, {{ Auth::user()->name }}</span>

                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-warning btn-sm me-2">Admin</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">Register</a>
                @endauth

                <button class="btn btn-sm btn-light ms-3"
                        @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)">
                    <span x-text="darkMode ? 'Light Mode' : 'Dark Mode'"></span>
                </button>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <div class="container">
        @yield('content')
    </div>

    {{-- Footer --}}
    <footer :class="darkMode ? 'bg-secondary text-white' : 'bg-dark text-white'" class="mt-5 py-3 text-center">
        <small>&copy; {{ now()->year }} Smart Web Builder</small>
    </footer>

    @yield('scripts')
</body>
</html>

