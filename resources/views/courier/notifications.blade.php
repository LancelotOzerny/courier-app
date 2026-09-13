<x-layouts.courier title="Уведомления" heading="Уведомления" active="notifications" :show-login="true">
    <section class="notices">
        @foreach ([['Новый заказ №1851', '10.09.2026, 16:40'], ['Ячейки A-12 и A-13 открыты', '10.09.2026, 15:02'], ['Заказ №1840 доставлен', '10.09.2026, 12:18']] as [$message, $time])
            <article class="notice">
                <h2 class="notice__title">{{ $message }}</h2>
                <p class="notice__time">{{ $time }}</p>
            </article>
        @endforeach
    </section>
</x-layouts.courier>
