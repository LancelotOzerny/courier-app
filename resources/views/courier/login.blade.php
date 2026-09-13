<x-layouts.courier title="Вход" heading="Вход" subtitle="Авторизация курьера">
    <form class="form" action="{{ route('dashboard') }}" method="get">
        <div class="form__field">
            <label class="form__label" for="login">Логин</label>
            <input class="form__input" id="login" name="login" type="text" autocomplete="username" required>
        </div>
        <div class="form__field">
            <label class="form__label" for="password">Пароль</label>
            <input class="form__input" id="password" name="password" type="password" autocomplete="current-password" required>
        </div>
        <button class="btn btn_primary" type="submit">Войти</button>
    </form>
</x-layouts.courier>
