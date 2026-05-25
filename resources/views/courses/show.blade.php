@extends('layouts.app')

@section('title', $course->title)

@section('content')
    <section class="grid gap-6 lg:grid-cols-[1.7fr_0.9fr]">
        <article class="panel p-8">
            <span class="section-kicker">Программа курса</span>
            <h1 class="mt-4 text-3xl font-extrabold text-brand-navy">{{ $course->title }}</h1>
            <p class="mt-5 text-lg leading-8 text-brand-slate">{{ $course->description }}</p>

            <div class="mt-8 grid gap-4 sm:grid-cols-2">
                <div class="muted-panel p-5">
                    <div class="text-xs uppercase tracking-[0.2em] text-brand-slate">Длительность</div>
                    <div class="mt-2 text-xl font-bold text-brand-navy">{{ $course->duration }}</div>
                </div>
                <div class="muted-panel p-5">
                    <div class="text-xs uppercase tracking-[0.2em] text-brand-slate">Стоимость</div>
                    <div class="mt-2 text-xl font-bold text-brand-navy">{{ $course->formatted_price }}</div>
                </div>
            </div>
        </article>

        <aside class="panel p-8">
            <div class="text-sm font-semibold uppercase tracking-[0.22em] text-brand-sky">Оформление участия</div>
            <p class="mt-4 leading-7 text-brand-slate">После заполнения анкеты система создаст заявку, автоматически сформирует PDF-договор и CSV-файл для дальнейшей работы менеджера.</p>

            <div class="mt-8 flex flex-col gap-3">
                <a href="{{ auth()->check() ? (auth()->user()->isAdmin() ? route('admin.dashboard') : route('orders.create', ['course' => $course->id])) : route('login') }}" class="btn-primary">
                    Оформить заявку
                </a>
                <a href="{{ route('courses.index') }}" class="btn-secondary">Вернуться к курсам</a>
            </div>
        </aside>
    </section>
@endsection
