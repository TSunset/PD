@extends('layouts.app')

@section('title', 'Админ-панель')

@section('content')
    <section class="space-y-6">
        <div class="panel p-8">
            <span class="section-kicker">Администрирование</span>
            <h1 class="mt-4 text-3xl font-extrabold text-brand-navy">Панель администратора</h1>
            <p class="mt-3 text-brand-slate">Централизованный просмотр заявок, скачивание документов и управление статусами обработки.</p>
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('admin.orders.index') }}" class="btn-primary">Перейти к заявкам</a>
                <a href="{{ route('admin.orders.export') }}" class="btn-secondary">Скачать общий CSV</a>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-4">
            <div class="panel p-6"><div class="text-xs uppercase tracking-[0.2em] text-brand-slate">Всего заявок</div><div class="mt-3 font-display text-4xl font-extrabold text-brand-navy">{{ $stats['total'] }}</div></div>
            <div class="panel p-6"><div class="text-xs uppercase tracking-[0.2em] text-brand-slate">Новые</div><div class="mt-3 font-display text-4xl font-extrabold text-slate-700">{{ $stats['new'] }}</div></div>
            <div class="panel p-6"><div class="text-xs uppercase tracking-[0.2em] text-brand-slate">Документы готовы</div><div class="mt-3 font-display text-4xl font-extrabold text-sky-700">{{ $stats['ready'] }}</div></div>
            <div class="panel p-6"><div class="text-xs uppercase tracking-[0.2em] text-brand-slate">Обработано</div><div class="mt-3 font-display text-4xl font-extrabold text-emerald-700">{{ $stats['processed'] }}</div></div>
        </div>

        <div class="panel p-8">
            <div class="flex items-center justify-between">
                <div>
                    <span class="section-kicker">Последние заявки</span>
                    <h2 class="mt-4 text-2xl font-bold text-brand-navy">Оперативный обзор</h2>
                </div>
            </div>

            <div class="mt-6 table-shell overflow-x-auto">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ФИО</th>
                            <th>Курс</th>
                            <th>Дата</th>
                            <th>Статус</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($latestOrders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->full_name }}</td>
                                <td>{{ $order->course?->title }}</td>
                                <td>{{ $order->formatted_created_at }}</td>
                                <td><x-status-badge :status="$order->status" :label="$order->status_label" /></td>
                                <td><a href="{{ route('admin.orders.show', $order) }}" class="btn-ghost">Открыть заявку</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-brand-slate">Заявок пока нет.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
