@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
    <section class="grid gap-6 xl:grid-cols-[0.95fr_1.45fr]">
        <div class="space-y-6">
            <div class="panel p-8">
                <span class="section-kicker">Личный кабинет</span>
                <h1 class="mt-4 text-3xl font-extrabold text-brand-navy">Здравствуйте, {{ auth()->user()->name }}</h1>
                <p class="mt-3 leading-7 text-brand-slate">Здесь отображаются ваши заявки, текущие статусы и ссылка на сформированный договор.</p>
                <div class="mt-6 flex gap-3">
                    <a href="{{ route('orders.create') }}" class="btn-primary">Создать новую заявку</a>
                    <a href="{{ route('courses.index') }}" class="btn-secondary">Посмотреть курсы</a>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="panel p-6">
                    <div class="text-xs uppercase tracking-[0.2em] text-brand-slate">Всего заявок</div>
                    <div class="mt-3 font-display text-4xl font-extrabold text-brand-navy">{{ $orderCount }}</div>
                </div>
                <div class="panel p-6">
                    <div class="text-xs uppercase tracking-[0.2em] text-brand-slate">Обработано</div>
                    <div class="mt-3 font-display text-4xl font-extrabold text-emerald-700">{{ $processedCount }}</div>
                </div>
            </div>
        </div>

        <div class="panel p-8">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <span class="section-kicker">Мои заявки</span>
                    <h2 class="mt-4 text-2xl font-bold text-brand-navy">Последние обращения</h2>
                </div>
                <a href="{{ route('orders.index') }}" class="btn-secondary">Все заявки</a>
            </div>

            @if ($orders->isEmpty())
                <div class="mt-6 muted-panel p-6 text-brand-slate">
                    У вас пока нет заявок. Выберите курс и создайте первую заявку для автоматического формирования договора.
                </div>
            @else
                <div class="mt-6 table-shell overflow-x-auto">
                    <table>
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Курс</th>
                                <th>Дата</th>
                                <th>Статус</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->course?->title }}</td>
                                    <td>{{ $order->formatted_created_at }}</td>
                                    <td>
                                        <x-status-badge :status="$order->status" :label="$order->status_label" />
                                    </td>
                                    <td>
                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ route('orders.show', $order) }}" class="btn-ghost">Открыть</a>
                                            <a href="{{ route('orders.download-contract', $order) }}" class="btn-secondary">Скачать договор</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </section>
@endsection
