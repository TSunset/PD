@extends('layouts.app')

@section('title', 'Онлайн-обучение для специалистов финансового рынка')

@section('content')
    <section class="hero-grid items-stretch">
        <div class="panel p-8 lg:p-10">
            <span class="section-kicker">Автоматизация заявок на обучение</span>
            <h1 class="mt-6 text-4xl font-extrabold leading-tight text-brand-navy lg:text-5xl">
                Онлайн-обучение для специалистов финансового рынка
            </h1>
            <p class="mt-5 max-w-2xl text-lg leading-8 text-brand-slate">
                MVP корпоративного университета для быстрого оформления заявок, автоматической подготовки договора
                и централизованной работы с документами в личном кабинете.
            </p>

            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('courses.index') }}" class="btn-primary">Выбрать курс</a>
                @guest
                    <a href="{{ route('register') }}" class="btn-secondary">Зарегистрироваться</a>
                    <a href="{{ route('login') }}" class="btn-ghost">Войти</a>
                @else
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="btn-secondary">Перейти в кабинет</a>
                @endguest
            </div>
        </div>

        <div class="space-y-4">
            <div class="panel p-6">
                <div class="text-sm font-semibold uppercase tracking-[0.22em] text-brand-sky">Что делает система</div>
                <div class="mt-4 grid gap-3">
                    <div class="muted-panel p-4">
                        <div class="font-semibold text-brand-navy">Оформление заявки</div>
                        <p class="mt-1 text-sm text-brand-slate">Пользователь выбирает курс, заполняет анкету и отправляет заявку через личный кабинет.</p>
                    </div>
                    <div class="muted-panel p-4">
                        <div class="font-semibold text-brand-navy">Автоматическая подготовка договора</div>
                        <p class="mt-1 text-sm text-brand-slate">После отправки система формирует PDF-договор и отдельный CSV по студенту.</p>
                    </div>
                    <div class="muted-panel p-4">
                        <div class="font-semibold text-brand-navy">Контроль администратора</div>
                        <p class="mt-1 text-sm text-brand-slate">Администратор видит заявку, скачивает документы и меняет статус без ручного переноса данных.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-10 grid gap-6 lg:grid-cols-5">
        <div class="panel p-6 lg:col-span-2">
            <span class="section-kicker">Преимущества</span>
            <ul class="mt-5 space-y-4 text-brand-slate">
                <li class="muted-panel p-4">Меньше ручной работы при оформлении онлайн-обучения.</li>
                <li class="muted-panel p-4">Автоматическое формирование договора и CSV с данными студента.</li>
                <li class="muted-panel p-4">Единый личный кабинет для пользователя и администратора.</li>
                <li class="muted-panel p-4">Снижение ошибок при переносе данных и подготовке документов.</li>
                <li class="muted-panel p-4">Быстрый доступ администратора к заявкам и готовым файлам.</li>
            </ul>
        </div>

        <div class="panel p-6 lg:col-span-3">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <span class="section-kicker">Популярные программы</span>
                    <h2 class="mt-4 text-2xl font-bold text-brand-navy">Курсы для финансовой инфраструктуры и ПИФ</h2>
                </div>
                <a href="{{ route('courses.index') }}" class="btn-secondary">Все курсы</a>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-3">
                @foreach ($featuredCourses as $course)
                    <article class="muted-panel flex h-full flex-col p-5">
                        <div class="text-sm font-semibold uppercase tracking-[0.18em] text-brand-sky">{{ $course->duration }}</div>
                        <h3 class="mt-3 text-lg font-bold text-brand-navy">{{ $course->title }}</h3>
                        <p class="mt-3 text-sm leading-6 text-brand-slate">{{ $course->description }}</p>
                        <div class="mt-5 flex items-center justify-between">
                            <span class="font-display text-xl font-extrabold text-brand-navy">{{ $course->formatted_price }}</span>
                            <a href="{{ auth()->check() ? (auth()->user()->isAdmin() ? route('admin.dashboard') : route('orders.create', ['course' => $course->id])) : route('login') }}" class="btn-ghost">
                                Оформить
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="contract-terms" class="mt-10 panel p-8">
        <span class="section-kicker">Условия договора</span>
        <h2 class="mt-4 text-2xl font-bold text-brand-navy">Краткие условия демонстрационного договора</h2>
        <div class="mt-5 grid gap-4 text-sm leading-7 text-brand-slate lg:grid-cols-2">
            <p>Исполнитель предоставляет доступ к выбранному онлайн-курсу после обработки заявки администратором. Документ формируется автоматически на основании данных, введённых пользователем на сайте.</p>
            <p>Пользователь подтверждает согласие на обработку персональных данных для целей оформления обучения, подготовки договора и передачи информации менеджеру для дальнейшей ручной обработки.</p>
        </div>
    </section>
@endsection
