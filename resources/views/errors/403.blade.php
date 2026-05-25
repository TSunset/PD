@extends('layouts.app')

@section('title', '403')

@section('content')
    <section class="mx-auto max-w-3xl panel p-8 text-center">
        <span class="section-kicker">Ошибка доступа</span>
        <h1 class="mt-4 text-4xl font-extrabold text-brand-navy">403</h1>
        <p class="mt-4 text-lg leading-8 text-brand-slate">У вас нет прав для просмотра этой страницы или скачивания этого документа.</p>
        <div class="mt-8 flex justify-center gap-3">
            <a href="{{ route('home') }}" class="btn-primary">На главную</a>
            @auth
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="btn-secondary">В кабинет</a>
            @endauth
        </div>
    </section>
@endsection
