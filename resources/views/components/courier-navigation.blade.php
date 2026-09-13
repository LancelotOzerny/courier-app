<nav class="nav" aria-label="Основная навигация">
    <ul class="nav__list">
        <li class="nav__item"><a class="nav__link {{ $active === 'dashboard' ? 'nav__link_active' : '' }}" href="{{ route('dashboard') }}"><img class="nav__icon" src="{{ asset('images/courier/house.svg') }}" alt="Главная"></a></li>
        <li class="nav__item"><a class="nav__link {{ $active === 'orders' ? 'nav__link_active' : '' }}" href="{{ route('orders.index') }}"><img class="nav__icon" src="{{ asset('images/courier/package.svg') }}" alt="Заказы"></a></li>
        <li class="nav__item"><a class="nav__link {{ $active === 'notifications' ? 'nav__link_active' : '' }}" href="{{ route('notifications.index') }}"><span class="nav__icon-wrap"><img class="nav__icon" src="{{ asset('images/courier/bell.svg') }}" alt="Уведомления"><span class="nav__badge">+1</span></span></a></li>
        <li class="nav__item"><a class="nav__link {{ $active === 'settings' ? 'nav__link_active' : '' }}" href="{{ route('settings') }}"><img class="nav__icon" src="{{ asset('images/courier/settings.svg') }}" alt="Настройки"></a></li>
    </ul>
</nav>
