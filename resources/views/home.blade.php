@extends('layouts.app')

@section('title', 'Онлайн-обучение для специалистов финансового рынка')

@section('content')
    <section class="panel hero-card home-hero">
        <div class="hero-grid">
            <div class="hero-content">
                <span class="section-kicker">Автоматизация заявок на обучение</span>
                <h1 class="mt-6 max-w-4xl text-4xl font-extrabold leading-[1.05] text-brand-charcoal lg:text-6xl">
                    Онлайн-обучение для специалистов финансового рынка
                </h1>
                <p class="hero-copy mt-6">
                    Демонстрационный MVP корпоративного университета АО «Специализированный депозитарий «ИНФИНИТУМ»:
                    оформление заявки, автоматическая подготовка договора и структурированная передача данных
                    в единый рабочий контур администратора.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('courses.index') }}" class="btn-primary">Выбрать курс</a>
                    @guest
                        <a href="{{ route('register') }}" class="btn-secondary">Зарегистрироваться</a>
                        <a href="{{ route('login') }}" class="btn-ghost">Войти</a>
                    @else
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="btn-secondary">
                            Перейти в кабинет
                        </a>
                    @endguest
                </div>
            </div>

            <aside class="hero-sidebar">
                <div class="muted-panel h-full p-6 lg:p-7">
                    <img src="{{ asset('images/infinitum-logo.png') }}" alt="ИНФИНИТУМ" class="hero-emblem">

                    <div class="hero-metrics">
                        <div class="metric-card">
                            <strong>Одна заявка — два готовых файла</strong>
                            <span>После отправки автоматически формируются PDF-договор и CSV с данными слушателя.</span>
                        </div>
                        <div class="metric-card">
                            <strong>Единая точка контроля</strong>
                            <span>Администратор видит заявку, документы и статус обработки в одном интерфейсе.</span>
                        </div>
                        <div class="metric-card">
                            <strong>Деловая подача и понятный сценарий</strong>
                            <span>Интерфейс ориентирован на корпоративное обучение и последующую ручную обработку менеджером.</span>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </section>

    <section class="mt-8 panel showcase-block">
        <div class="flex flex-col gap-3 border-b border-brand-line pb-6 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <span class="section-kicker">Каталог программ</span>
                <h2 class="mt-4 text-3xl font-bold text-brand-charcoal">Курсы корпоративного университета</h2>
                <p class="mt-3 max-w-3xl text-base leading-8 text-brand-gray">
                    Актуальные программы для управляющих компаний, спецдепозитариев, подразделений внутреннего контроля
                    и специалистов финансовой инфраструктуры.
                </p>
            </div>
            <a href="{{ route('courses.index') }}" class="btn-secondary">Все курсы</a>
        </div>

        <div class="mt-8 grid gap-5 lg:grid-cols-3">
            @foreach ($featuredCourses as $course)
                <article class="course-card">
                    <div class="course-meta">{{ $course->duration }}</div>
                    <h3 class="mt-4 text-xl font-bold text-brand-charcoal">{{ $course->title }}</h3>
                    <p class="mt-4 flex-1 text-sm leading-7">{{ $course->description }}</p>
                    <div class="mt-6 flex items-end justify-between gap-3">
                        <div>
                            <div class="text-xs uppercase tracking-[0.18em] text-brand-gray">Стоимость</div>
                            <div class="mt-1 font-display text-2xl font-extrabold text-brand-charcoal">{{ $course->formatted_price }}</div>
                        </div>
                        <a href="{{ auth()->check() ? (auth()->user()->isAdmin() ? route('admin.dashboard') : route('orders.create', ['course' => $course->id])) : route('login') }}" class="btn-primary">
                            Оформить
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="mt-8 panel cta-band">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-3xl">
                <span class="inline-flex rounded-full border border-white/20 px-4 py-2 text-xs font-semibold uppercase tracking-[0.16em] text-white/80">
                    Демонстрационный контур
                </span>
                <h2 class="mt-4 text-3xl font-bold">Готово для презентации на защите</h2>
                <p class="mt-3 text-base leading-8">
                    Пользователь выбирает курс, оформляет заявку и получает договор. Администратор открывает карточку,
                    скачивает PDF и CSV, затем меняет статус обработки.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('courses.index') }}" class="btn-secondary">Посмотреть курсы</a>
                @guest
                    <a href="{{ route('register') }}" class="btn-primary">Создать аккаунт</a>
                @else
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('orders.create') }}" class="btn-primary">
                        {{ auth()->user()->isAdmin() ? 'Открыть админку' : 'Создать заявку' }}
                    </a>
                @endguest
            </div>
        </div>
    </section>
@endsection
