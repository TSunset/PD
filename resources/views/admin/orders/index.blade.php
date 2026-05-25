@extends('layouts.app')

@section('title', 'Заявки')

@section('content')
    <section class="panel p-8">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <span class="section-kicker">Реестр заявок</span>
                <h1 class="mt-4 text-3xl font-extrabold text-brand-navy">Все заявки</h1>
            </div>
            <a href="{{ route('admin.orders.export') }}" class="btn-primary">Скачать общий CSV</a>
        </div>

        <form method="GET" action="{{ route('admin.orders.index') }}" class="mt-8 grid gap-4 rounded-2xl border border-slate-200 bg-brand-panel p-5 lg:grid-cols-[1fr_0.8fr_1.2fr_auto]">
            <div>
                <label for="status" class="mb-2 block text-sm font-semibold text-brand-navy">Статус</label>
                <select id="status" name="status" class="select-field">
                    <option value="">Все статусы</option>
                    @foreach ($statusOptions as $value => $label)
                        <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="course" class="mb-2 block text-sm font-semibold text-brand-navy">Курс</label>
                <select id="course" name="course" class="select-field">
                    <option value="">Все курсы</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" @selected((string) request('course') === (string) $course->id)>{{ $course->title }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="search" class="mb-2 block text-sm font-semibold text-brand-navy">Поиск</label>
                <input id="search" name="search" type="text" class="input-field" value="{{ request('search') }}" placeholder="ФИО, email или организация">
            </div>
            <div class="flex items-end gap-3">
                <button type="submit" class="btn-primary w-full">Фильтровать</button>
                <a href="{{ route('admin.orders.index') }}" class="btn-secondary w-full">Сбросить</a>
            </div>
        </form>

        <div class="mt-8 table-shell overflow-x-auto">
            <table>
                <thead>
                    <tr>
                        <th>ID заявки</th>
                        <th>Дата</th>
                        <th>ФИО</th>
                        <th>Email</th>
                        <th>Телефон</th>
                        <th>Организация</th>
                        <th>Курс</th>
                        <th>Цена</th>
                        <th>Статус</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->formatted_created_at }}</td>
                            <td>{{ $order->full_name }}</td>
                            <td>{{ $order->email }}</td>
                            <td>{{ $order->phone ?: '—' }}</td>
                            <td>{{ $order->organization ?: '—' }}</td>
                            <td>{{ $order->course?->title }}</td>
                            <td>{{ $order->course?->formatted_price }}</td>
                            <td><x-status-badge :status="$order->status" :label="$order->status_label" /></td>
                            <td><a href="{{ route('admin.orders.show', $order) }}" class="btn-ghost">Открыть заявку</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-brand-slate">Подходящих заявок не найдено.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </section>
@endsection
