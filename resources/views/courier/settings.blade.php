<x-layouts.courier title="Настройки" heading="Настройки" active="settings" :show-login="true">
    <form class="form" action="{{ route('login') }}" method="get">
        <div class="form__field"><label class="form__label" for="name">Имя</label><input class="form__input" id="name" name="name" type="text" value="ivanov"></div>
        <button class="btn btn_primary" type="submit">Выйти</button>
    </form>
</x-layouts.courier>
