<x-layouts.courier title="Заказы" heading="Заказы" active="orders" :show-login="true">
    <section class="orders">
        @foreach ([1842 => 'Постамат ПВЗ-07 · ул. Ленина, 12', 1845 => 'Постамат ПВЗ-03 · пр. Мира, 45', 1851 => 'Постамат ПВЗ-11 · ул. Садовая, 8'] as $number => $location)
            <article class="order-card">
                <h2 class="order-card__id">Заказ №{{ $number }}</h2>
                <p class="order-card__meta">{{ $location }}</p>
                <a class="order-card__link btn btn_ghost" href="{{ route('orders.show', $number) }}">Открыть заказ</a>
            </article>
        @endforeach
    </section>
</x-layouts.courier>
