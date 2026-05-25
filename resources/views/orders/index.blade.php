@extends('layouts.app')

@section('title', 'Мои заявки')

@section('content')
    <section class="panel p-8">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <span class="section-kicker">История заявок</span>
                <h1 class="mt-4 text-3xl font-extrabold text-brand-navy">Мои заявки</h1>
            </div>
            <a href="{{ route('orders.create') }}" class="btn-primary">Создать новую заявку</a>
        </div>

        <div class="mt-8 table-shell overflow-x-auto">
            <table>
                <thead>
                    <tr>
                        <th>Номер</th>
                        <th>Курс</th>
                        <th>Дата создания</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->course?->title }}</td>
                            <td>{{ $order->formatted_created_at }}</td>
                            <td><x-status-badge :status="$order->status" :label="$order->status_label" /></td>
                            <td>
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('orders.show', $order) }}" class="btn-ghost">Открыть</a>
                                    <a href="{{ route('orders.download-contract', $order) }}" class="btn-secondary">Скачать договор</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-brand-slate">Заявок пока нет.</td>
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
