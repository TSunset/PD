@extends('layouts.app')

@section('title', 'Курсы корпоративного университета')

@section('content')
    <section class="panel p-8">
        <span class="section-kicker">Каталог курсов</span>
        <div class="mt-4 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-brand-navy">Программы онлайн-обучения</h1>
                <p class="mt-3 max-w-3xl text-brand-slate">Курсы подготовлены для специалистов финансового рынка, управляющих компаний, спецдепозитариев и подразделений внутреннего контроля.</p>
            </div>
            @auth
                @if (! auth()->user()->isAdmin())
                    <a href="{{ route('orders.create') }}" class="btn-primary">Создать новую заявку</a>
                @endif
            @endauth
        </div>

        <div class="mt-8 grid gap-5 lg:grid-cols-2">
            @foreach ($courses as $course)
                <article class="muted-panel flex h-full flex-col p-6">
                    <div class="flex items-start justify-between gap-3">
                        <h2 class="text-xl font-bold text-brand-navy">{{ $course->title }}</h2>
                        <span class="rounded-full bg-white px-3 py-1 text-sm font-semibold text-brand-sky">{{ $course->duration }}</span>
                    </div>
                    <p class="mt-4 flex-1 leading-7 text-brand-slate">{{ $course->description }}</p>
                    <div class="mt-6 flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <div class="text-xs uppercase tracking-[0.2em] text-brand-slate">Стоимость</div>
                            <div class="font-display text-2xl font-extrabold text-brand-navy">{{ $course->formatted_price }}</div>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('courses.show', $course) }}" class="btn-secondary">Подробнее</a>
                            <a href="{{ auth()->check() ? (auth()->user()->isAdmin() ? route('admin.dashboard') : route('orders.create', ['course' => $course->id])) : route('login') }}" class="btn-primary">
                                Оформить заявку
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
@endsection
