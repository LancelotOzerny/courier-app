<x-layouts.courier title="Заказы" heading="Заказы" active="orders" :show-login="true">
    <section class="orders">
        @forelse ($orders as $order)
            <article class="order-card">
                <h2 class="order-card__id">Заказ №{{ $order->number }}</h2>
                <p class="order-card__meta">Постамат {{ $order->parcelLocker->number }} · {{ $order->parcelLocker->address }}</p>
                <a class="order-card__link btn btn_ghost" href="{{ route('orders.show', $order->number) }}">Открыть заказ</a>
            </article>
        @empty
            <p class="empty-state">Вам пока не назначены заказы.</p>
        @endforelse
    </section>
</x-layouts.courier>
