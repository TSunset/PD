@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
    <section class="mx-auto max-w-3xl panel p-8">
        <span class="section-kicker">Регистрация</span>
        <h1 class="mt-4 text-3xl font-extrabold text-brand-navy">Создание учётной записи</h1>
        <p class="mt-3 text-brand-slate">После регистрации вы сразу попадёте в личный кабинет и сможете оформить первую заявку на курс.</p>

        <form action="{{ route('register.store') }}" method="POST" class="mt-8 grid gap-5">
            @csrf
            <div>
                <label for="name" class="mb-2 block text-sm font-semibold text-brand-navy">ФИО</label>
                <input id="name" name="name" type="text" class="input-field" value="{{ old('name') }}" required>
            </div>
            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold text-brand-navy">Email</label>
                    <input id="email" name="email" type="email" class="input-field" value="{{ old('email') }}" required>
                </div>
                <div>
                    <label for="phone" class="mb-2 block text-sm font-semibold text-brand-navy">Телефон</label>
                    <input id="phone" name="phone" type="text" class="input-field" value="{{ old('phone') }}">
                </div>
            </div>
            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="password" class="mb-2 block text-sm font-semibold text-brand-navy">Пароль</label>
                    <input id="password" name="password" type="password" class="input-field" required aria-describedby="password_rules">
                    <p id="password_rules" class="mt-2 text-sm leading-6 text-brand-gray">
                        Минимум 8 символов. Пароль должен содержать хотя бы одну латинскую букву и хотя бы одну цифру.
                    </p>
                </div>
                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-brand-navy">Подтверждение пароля</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="input-field" required>
                </div>
            </div>
            <div class="flex flex-wrap gap-3">
                <button type="submit" class="btn-primary">Зарегистрироваться</button>
                <a href="{{ route('login') }}" class="btn-secondary">У меня уже есть аккаунт</a>
            </div>
        </form>
    </section>
@endsection
