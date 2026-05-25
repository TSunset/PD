@extends('layouts.app')

@section('title', 'Заявка №'.$order->id)

@section('content')
    <section class="panel p-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <span class="section-kicker">Заявка пользователя</span>
                <h1 class="mt-4 text-3xl font-extrabold text-brand-navy">Заявка №{{ $order->id }}</h1>
                <p class="mt-3 text-brand-slate">Дата создания: {{ $order->formatted_created_at }}</p>
            </div>
            <x-status-badge :status="$order->status" :label="$order->status_label" />
        </div>

        <div class="mt-8 grid gap-4 md:grid-cols-2">
            <div class="muted-panel p-5"><div class="text-xs uppercase tracking-[0.2em] text-brand-slate">Курс</div><div class="mt-2 font-semibold text-brand-navy">{{ $order->course?->title }}</div></div>
            <div class="muted-panel p-5"><div class="text-xs uppercase tracking-[0.2em] text-brand-slate">Стоимость</div><div class="mt-2 font-semibold text-brand-navy">{{ $order->course?->formatted_price }}</div></div>
            <div class="muted-panel p-5"><div class="text-xs uppercase tracking-[0.2em] text-brand-slate">ФИО</div><div class="mt-2 font-semibold text-brand-navy">{{ $order->full_name }}</div></div>
            <div class="muted-panel p-5"><div class="text-xs uppercase tracking-[0.2em] text-brand-slate">Email</div><div class="mt-2 font-semibold text-brand-navy">{{ $order->email }}</div></div>
            <div class="muted-panel p-5"><div class="text-xs uppercase tracking-[0.2em] text-brand-slate">Телефон</div><div class="mt-2 font-semibold text-brand-navy">{{ $order->phone ?: 'Не указан' }}</div></div>
            <div class="muted-panel p-5"><div class="text-xs uppercase tracking-[0.2em] text-brand-slate">Организация</div><div class="mt-2 font-semibold text-brand-navy">{{ $order->organization ?: 'Не указана' }}</div></div>
            <div class="muted-panel p-5"><div class="text-xs uppercase tracking-[0.2em] text-brand-slate">ИНН</div><div class="mt-2 font-semibold text-brand-navy">{{ $order->inn ?: 'Не указан' }}</div></div>
            <div class="muted-panel p-5"><div class="text-xs uppercase tracking-[0.2em] text-brand-slate">Должность</div><div class="mt-2 font-semibold text-brand-navy">{{ $order->position ?: 'Не указана' }}</div></div>
        </div>

        <div class="mt-8 muted-panel p-5">
            <div class="text-xs uppercase tracking-[0.2em] text-brand-slate">Комментарий</div>
            <div class="mt-2 text-brand-navy">{{ $order->comment ?: 'Комментарий не добавлен.' }}</div>
        </div>

        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('orders.download-contract', $order) }}" class="btn-primary">Скачать договор</a>
            <a href="{{ route('orders.index') }}" class="btn-secondary">К списку заявок</a>
        </div>
    </section>
@endsection
