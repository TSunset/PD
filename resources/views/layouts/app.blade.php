<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Корпоративный университет ИНФИНИТУМ')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="border-b border-slate-200/80 bg-white/90 backdrop-blur">
        <div class="page-shell flex flex-col gap-4 py-5 lg:flex-row lg:items-center lg:justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3 text-brand-navy">
                <span class="brand-mark">И</span>
                <div>
                    <div class="font-display text-lg font-extrabold tracking-wide">ИНФИНИТУМ</div>
                    <div class="text-xs uppercase tracking-[0.28em] text-brand-slate">Корпоративный университет</div>
                </div>
            </a>

            <nav class="flex flex-wrap items-center gap-2 text-sm font-medium text-brand-slate">
                <a href="{{ route('home') }}" class="rounded-full px-4 py-2 hover:bg-brand-ice hover:text-brand-navy">Главная</a>
                <a href="{{ route('courses.index') }}" class="rounded-full px-4 py-2 hover:bg-brand-ice hover:text-brand-navy">Курсы</a>

                @guest
                    <a href="{{ route('login') }}" class="rounded-full px-4 py-2 hover:bg-brand-ice hover:text-brand-navy">Войти</a>
                    <a href="{{ route('register') }}" class="btn-primary">Регистрация</a>
                @endguest

                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="rounded-full px-4 py-2 hover:bg-brand-ice hover:text-brand-navy">Админ-панель</a>
                        <a href="{{ route('admin.orders.index') }}" class="rounded-full px-4 py-2 hover:bg-brand-ice hover:text-brand-navy">Заявки</a>
                        <a href="{{ route('admin.orders.export') }}" class="rounded-full px-4 py-2 hover:bg-brand-ice hover:text-brand-navy">Скачать общий CSV</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="rounded-full px-4 py-2 hover:bg-brand-ice hover:text-brand-navy">Личный кабинет</a>
                        <a href="{{ route('orders.index') }}" class="rounded-full px-4 py-2 hover:bg-brand-ice hover:text-brand-navy">Мои заявки</a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-secondary">Выйти</button>
                    </form>
                @endauth
            </nav>
        </div>
    </div>

    <main class="py-10 lg:py-14">
        <div class="page-shell">
            @if (session('status'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-900">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-900">
                    <div class="font-semibold">Проверьте введённые данные.</div>
                    <ul class="mt-2 list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</body>
</html>
