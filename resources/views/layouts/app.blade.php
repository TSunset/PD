<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Корпоративный университет ИНФИНИТУМ')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="site-header">
        <div class="page-shell py-4">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-4">
                    <img src="{{ asset('images/infinitum-logo.png') }}" alt="ИНФИНИТУМ" class="w-[18rem] max-w-full lg:w-[24rem]">
                    <div class="hidden border-l border-brand-line pl-4 lg:block">
                        <div class="topbar-note">Корпоративный университет</div>
                        <div class="mt-1 text-sm text-brand-gray">Онлайн-обучение для специалистов финансового рынка</div>
                    </div>
                </a>

                <div class="flex flex-col items-start gap-4 lg:items-end">
                    <div class="topbar-note">Автоматизация заявок и документооборота</div>
                    <div class="flex flex-col items-start gap-3 lg:items-end">
                        <nav class="flex flex-wrap items-center gap-1 lg:justify-end">
                            <a href="{{ route('home') }}" class="nav-link">Главная</a>
                            <a href="{{ route('courses.index') }}" class="nav-link">Курсы</a>

                            @guest
                                <a href="{{ route('login') }}" class="nav-link">Войти</a>
                                <a href="{{ route('register') }}" class="btn-primary">Регистрация</a>
                            @endguest

                            @auth
                                @if (auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="nav-link">Админ-панель</a>
                                    <a href="{{ route('admin.orders.index') }}" class="nav-link">Заявки</a>
                                    <a href="{{ route('admin.orders.export') }}" class="nav-link">Общий CSV</a>
                                @else
                                    <a href="{{ route('dashboard') }}" class="nav-link">Личный кабинет</a>
                                    <a href="{{ route('orders.index') }}" class="nav-link">Мои заявки</a>
                                @endif
                            @endauth
                        </nav>

                        @auth
                            <form action="{{ route('logout') }}" method="POST" class="shrink-0">
                                @csrf
                                <button type="submit" class="btn-secondary">Выйти</button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </header>

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
