<x-layouts.courier :title="'Заказ №'.$order->number" heading="Заказ" active="orders" :show-login="true">
    <article class="order">
        <h2 class="order__number">№{{ $order->number }}</h2>
        <p class="order__date">Добавлен курьеру: {{ $order->courier_created_at->format('d.m.Y, H:i') }}</p>
        <p class="order__postamat">Постамат {{ $order->parcelLocker->number }}, {{ $order->parcelLocker->address }}</p>
        <section class="order__section">
            <h3 class="order__section-title">Товары</h3>
            <ul class="goods">
                @forelse ($order->items as $item)
                    <li class="goods__item"><span class="goods__name">{{ $item->name }}</span><span class="goods__qty">× {{ $item->quantity }}</span></li>
                @empty
                    <li class="goods__item">Товары не добавлены.</li>
                @endforelse
            </ul>
        </section>
        <section class="order__section">
            <h3 class="order__section-title">Ячейки</h3>
            <ul class="cells">
                @forelse ($order->lockerCells as $cell)
                    <li class="cells__item">{{ $cell->number }}</li>
                @empty
                    <li class="cells__item cells__item_empty">Не назначены</li>
                @endforelse
            </ul>
        </section>
        <div class="order__actions">
            <button class="btn btn_primary" type="button" disabled>Открыть ячейки</button>
            <button class="btn btn_success" type="button" disabled>Заказ доставлен</button>
        </div>
    </article>
</x-layouts.courier>
