<x-layouts.courier :title="'Заказ №'.$orderNumber" heading="Заказ" active="orders" :show-login="true">
    <article class="order">
        <h2 class="order__number">№{{ $orderNumber }}</h2>
        <p class="order__date">Добавлен: 10.09.2026, 14:20</p>
        <p class="order__postamat">Постамат ПВЗ-07, ул. Ленина, 12</p>
        <section class="order__section">
            <h3 class="order__section-title">Товары</h3>
            <ul class="goods">
                @foreach (['Вода 5 л' => 2, 'Молоко 1 л' => 1, 'Хлеб' => 1] as $name => $quantity)
                    <li class="goods__item"><span class="goods__name">{{ $name }}</span><span class="goods__qty">× {{ $quantity }}</span></li>
                @endforeach
            </ul>
        </section>
        <section class="order__section">
            <h3 class="order__section-title">Ячейки</h3>
            <ul class="cells"><li class="cells__item">A-12</li><li class="cells__item">A-13</li></ul>
        </section>
        <div class="order__actions"><button class="btn btn_primary" type="button">Открыть ячейки</button><button class="btn btn_success" type="button">Заказ доставлен</button></div>
    </article>
</x-layouts.courier>
