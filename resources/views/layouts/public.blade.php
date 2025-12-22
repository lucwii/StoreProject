<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Farbara')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS (opciono) -->
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100" style="background:#ffffff;">

<!-- FLASH PORUKE -->
<div class="container mt-2">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

<!-- GLAVNI SADRŽAJ -->
<main class="container my-5 flex-grow-1">
    @yield('content')
</main>

<!-- FOOTER -->
<footer class="bg-dark text-white text-center py-3 mt-auto">
    <small>&copy; {{ date('Y') }} Farbara | Laravel aplikacija</small>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')
</body>
</html>
