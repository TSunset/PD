@extends('layouts.app')

@section('title', '404')

@section('content')
    <section class="mx-auto max-w-3xl panel p-8 text-center">
        <span class="section-kicker">Страница не найдена</span>
        <h1 class="mt-4 text-4xl font-extrabold text-brand-navy">404</h1>
        <p class="mt-4 text-lg leading-8 text-brand-slate">Запрошенная страница, заявка или файл не найдены. Проверьте адрес или вернитесь к основным разделам сайта.</p>
        <div class="mt-8 flex justify-center gap-3">
            <a href="{{ route('home') }}" class="btn-primary">На главную</a>
            <a href="{{ route('courses.index') }}" class="btn-secondary">К курсам</a>
        </div>
    </section>
@endsection
