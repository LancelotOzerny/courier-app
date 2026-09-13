<x-layouts.courier title="Главная" heading="Курьер" active="dashboard" :show-login="true">
    <section class="dashboard">
        <p class="dashboard__label">Доступно заказов</p>
        <p class="dashboard__value">3</p>
    </section>

    <nav class="tiles" aria-label="Разделы">
        <a class="tile" href="{{ route('orders.index') }}">
            <img class="tile__icon" src="{{ asset('images/courier/package.svg') }}" alt="" width="128" height="128">
            <span class="tile__title">Заказы</span>
        </a>
        <a class="tile" href="{{ route('settings') }}">
            <img class="tile__icon" src="{{ asset('images/courier/settings.svg') }}" alt="" width="128" height="128">
            <span class="tile__title">Настройки</span>
        </a>
    </nav>
</x-layouts.courier>
