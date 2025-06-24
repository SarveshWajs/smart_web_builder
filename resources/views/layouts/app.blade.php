<!DOCTYPE html>
<html>
<head>
    <title>Smart Web Builder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
/* Modern tab style */
.modern-tab {
    border-radius: 1.5rem !important;
    transition: background 0.2s, color 0.2s;
}
.modern-tab.active, .modern-tab:hover {
    background: linear-gradient(90deg, #0d6efd 60%, #6610f2 100%);
    color: #fff !important;
    box-shadow: 0 2px 8px rgba(13,110,253,0.08);
}
</style>

</head>
<body x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
      :class="darkMode ? 'bg-dark text-white' : 'bg-light text-dark'">
{{-- Header --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">Smart Web Builder</a>

        @auth
            <ul class="nav nav-pills mx-auto bg-white rounded-4 shadow-sm px-3 py-2 gap-2" style="max-width: 600px;">
                @if(Auth::user()->is_admin)
                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->routeIs('themes.index') ? 'active modern-tab' : 'text-dark modern-tab' }}"
                           href="{{ route('themes.index') }}">
                            Manage Themes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->routeIs('component.index') ? 'active modern-tab' : 'text-dark modern-tab' }}"
                           href="{{ route('component.index') }}">
                            Manage Components
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->routeIs('projects.create') ? 'active modern-tab' : 'text-dark modern-tab' }}"
                           href="{{ route('projects.create') }}">
                            Create Template
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->routeIs('home') ? 'active modern-tab' : 'text-dark modern-tab' }}"
                           href="{{ route('home') }}">
                            Home Page
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->routeIs('projects.create') ? 'active modern-tab' : 'text-dark modern-tab' }}"
                           href="{{ route('projects.create') }}">
                            Create Template
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->routeIs('projects.favorites') ? 'active modern-tab' : 'text-dark modern-tab' }}"
                           href="{{ route('projects.favorites') }}">
                            Favorites
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->routeIs('projects.myTemplates') ? 'active modern-tab' : 'text-dark modern-tab' }}"
                           href="{{ route('projects.myTemplates') }}">
                            My Templates
                        </a>
                    </li>
                @endif
            </ul>
        @endauth

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
    @stack('scripts')
</body>
</html>
