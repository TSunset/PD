@extends('layouts.app')

@section('title', 'Вход')

@section('content')
    <section class="mx-auto max-w-2xl panel p-8">
        <span class="section-kicker">Авторизация</span>
        <h1 class="mt-4 text-3xl font-extrabold text-brand-navy">Вход в систему</h1>
        <p class="mt-3 text-brand-slate">Пользователь попадает в личный кабинет, администратор — в админ-панель.</p>

        <form action="{{ route('login.store') }}" method="POST" class="mt-8 grid gap-5">
            @csrf
            <div>
                <label for="email" class="mb-2 block text-sm font-semibold text-brand-navy">Email</label>
                <input id="email" name="email" type="email" class="input-field" value="{{ old('email') }}" required>
            </div>
            <div>
                <label for="password" class="mb-2 block text-sm font-semibold text-brand-navy">Пароль</label>
                <input id="password" name="password" type="password" class="input-field" required>
            </div>
            <label class="flex items-center gap-3 text-sm text-brand-slate">
                <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-slate-300">
                Запомнить меня
            </label>
            <div class="flex flex-wrap gap-3">
                <button type="submit" class="btn-primary">Войти</button>
                <a href="{{ route('register') }}" class="btn-secondary">Регистрация</a>
            </div>
        </form>
    </section>
@endsection
