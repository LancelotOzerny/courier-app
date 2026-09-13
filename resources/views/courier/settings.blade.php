<x-layouts.courier title="Настройки" heading="Настройки" active="settings" :show-login="true">
    <form class="form" action="{{ route('logout') }}" method="post">
        @csrf
        <div class="form__field">
            <label class="form__label" for="login">Логин</label>
            <input class="form__input" id="login" type="text" value="{{ auth()->user()->login }}" readonly>
        </div>
        <div class="form__field">
            <label class="form__label" for="email">Email</label>
            <input class="form__input" id="email" type="email" value="{{ auth()->user()->email }}" readonly>
        </div>
        <div class="form__field">
            <label class="form__label" for="phone">Телефон</label>
            <input class="form__input" id="phone" type="tel" value="{{ auth()->user()->phone }}" readonly>
        </div>
        <div class="form__field">
            <label class="form__label" for="created-at">Дата регистрации</label>
            <input class="form__input" id="created-at" type="text" value="{{ auth()->user()->created_at->format('d.m.Y, H:i') }}" readonly>
        </div>
        <button class="btn btn_primary" type="submit">Выйти</button>
    </form>
</x-layouts.courier>
