@extends('layouts.app')

@section('title', 'Заявка №'.$order->id)

@section('content')
    <section class="space-y-6">
        <div class="panel p-8">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <span class="section-kicker">Карточка заявки</span>
                    <h1 class="mt-4 text-3xl font-extrabold text-brand-navy">Заявка №{{ $order->id }}</h1>
                    <p class="mt-3 text-brand-slate">Дата создания: {{ $order->formatted_created_at }}</p>
                </div>
                <x-status-badge :status="$order->status" :label="$order->status_label" />
            </div>
        </div>

        <div class="panel p-8">
            <h2 class="text-2xl font-bold text-brand-navy">Блок 1. Данные заявки</h2>
            <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                <div class="muted-panel p-5"><div class="text-xs uppercase tracking-[0.2em] text-brand-slate">Номер заявки</div><div class="mt-2 font-semibold text-brand-navy">{{ $order->id }}</div></div>
                <div class="muted-panel p-5"><div class="text-xs uppercase tracking-[0.2em] text-brand-slate">Дата создания</div><div class="mt-2 font-semibold text-brand-navy">{{ $order->formatted_created_at }}</div></div>
                <div class="muted-panel p-5"><div class="text-xs uppercase tracking-[0.2em] text-brand-slate">Статус</div><div class="mt-2 font-semibold text-brand-navy">{{ $order->status_label }}</div></div>
                <div class="muted-panel p-5"><div class="text-xs uppercase tracking-[0.2em] text-brand-slate">ФИО</div><div class="mt-2 font-semibold text-brand-navy">{{ $order->full_name }}</div></div>
                <div class="muted-panel p-5"><div class="text-xs uppercase tracking-[0.2em] text-brand-slate">Email</div><div class="mt-2 font-semibold text-brand-navy">{{ $order->email }}</div></div>
                <div class="muted-panel p-5"><div class="text-xs uppercase tracking-[0.2em] text-brand-slate">Телефон</div><div class="mt-2 font-semibold text-brand-navy">{{ $order->phone ?: 'Не указан' }}</div></div>
                <div class="muted-panel p-5"><div class="text-xs uppercase tracking-[0.2em] text-brand-slate">Организация</div><div class="mt-2 font-semibold text-brand-navy">{{ $order->organization ?: 'Не указана' }}</div></div>
                <div class="muted-panel p-5"><div class="text-xs uppercase tracking-[0.2em] text-brand-slate">ИНН</div><div class="mt-2 font-semibold text-brand-navy">{{ $order->inn ?: 'Не указан' }}</div></div>
                <div class="muted-panel p-5"><div class="text-xs uppercase tracking-[0.2em] text-brand-slate">Должность</div><div class="mt-2 font-semibold text-brand-navy">{{ $order->position ?: 'Не указана' }}</div></div>
                <div class="muted-panel p-5 md:col-span-2 xl:col-span-2"><div class="text-xs uppercase tracking-[0.2em] text-brand-slate">Курс</div><div class="mt-2 font-semibold text-brand-navy">{{ $order->course?->title }}</div></div>
                <div class="muted-panel p-5"><div class="text-xs uppercase tracking-[0.2em] text-brand-slate">Цена</div><div class="mt-2 font-semibold text-brand-navy">{{ $order->course?->formatted_price }}</div></div>
            </div>
            <div class="mt-4 muted-panel p-5">
                <div class="text-xs uppercase tracking-[0.2em] text-brand-slate">Комментарий</div>
                <div class="mt-2 text-brand-navy">{{ $order->comment ?: 'Комментарий не добавлен.' }}</div>
            </div>
        </div>

        <div class="panel p-8">
            <h2 class="text-2xl font-bold text-brand-navy">Блок 2. Файл 1 — PDF-договор</h2>
            <div class="mt-6 flex flex-col gap-4 rounded-2xl border border-slate-200 bg-brand-panel p-5 md:flex-row md:items-center md:justify-between">
                <div>
                    <div class="font-semibold text-brand-navy">{{ basename($order->contract_pdf_path) }}</div>
                    <div class="mt-1 text-sm text-brand-slate">Дата генерации: {{ $order->formatted_created_at }}</div>
                </div>
                <a href="{{ route('admin.orders.download-contract', $order) }}" class="btn-primary">Скачать PDF-договор</a>
            </div>
        </div>

        <div class="panel p-8">
            <h2 class="text-2xl font-bold text-brand-navy">Блок 3. Файл 2 — CSV с данными студента</h2>
            <div class="mt-6 flex flex-col gap-4 rounded-2xl border border-slate-200 bg-brand-panel p-5 md:flex-row md:items-center md:justify-between">
                <div>
                    <div class="font-semibold text-brand-navy">{{ basename($order->student_csv_path) }}</div>
                    <div class="mt-1 text-sm text-brand-slate">Дата генерации: {{ $order->formatted_created_at }}</div>
                </div>
                <a href="{{ route('admin.orders.download-csv', $order) }}" class="btn-primary">Скачать CSV</a>
            </div>
        </div>

        <div class="panel p-8">
            <h2 class="text-2xl font-bold text-brand-navy">Блок 4. Управление заявкой</h2>
            <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="mt-6 flex flex-col gap-4 md:flex-row md:items-end">
                @csrf
                <div class="w-full md:max-w-md">
                    <label for="status" class="mb-2 block text-sm font-semibold text-brand-navy">Статус заявки</label>
                    <select id="status" name="status" class="select-field">
                        @foreach ($statusOptions as $value => $label)
                            <option value="{{ $value }}" @selected($order->status->value === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-primary">Сохранить статус</button>
            </form>
        </div>
    </section>
@endsection
