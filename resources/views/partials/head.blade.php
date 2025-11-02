<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- Mobile cache busting adicional -->
<meta name="version" content="{{ time() }}">
<meta name="mobile-cache-bust" content="{{ uniqid() }}">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
<meta name="format-detection" content="telephone=no">

<!-- Script para aplicar estado del sidebar ANTES de renderizar -->
<script>
    // Este script se ejecuta INMEDIATAMENTE, antes de que se renderice el DOM
    (function() {
        const isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
        if (isCollapsed) {
            document.documentElement.classList.add('sidebar-state-collapsed');
            document.body?.classList.add('sidebar-state-collapsed');
        }
    })();
</script>

@fluxAppearance

