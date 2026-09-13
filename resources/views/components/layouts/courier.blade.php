<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#3d6ea8">
    <title>{{ $title }} — Курьер</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="page">
        <header class="header">
            @isset($showLogin)
                <a class="header__login" href="{{ route('login') }}">ivanov</a>
            @endisset
            <h1 class="header__title">{{ $heading }}</h1>
            @isset($subtitle)
                <p class="header__subtitle">{{ $subtitle }}</p>
            @endisset
        </header>
        <main class="page__main">{{ $slot }}</main>
        <x-courier-navigation :active="$active ?? null" />
    </div>
</body>
</html>
