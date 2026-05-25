@extends('layouts.app')

@section('title', 'Заявка создана')

@section('content')
    <section class="mx-auto max-w-3xl panel p-8">
        <span class="section-kicker">Успешно</span>
        <h1 class="mt-4 text-3xl font-extrabold text-brand-navy">Заявка успешно создана</h1>
        <p class="mt-4 text-lg leading-8 text-brand-slate">
            Заявка успешно создана. Договор сформирован автоматически. Администратор получил доступ к документам в личном кабинете.
        </p>

        <div class="mt-8 muted-panel p-5 text-sm text-brand-slate">
            <div><span class="font-semibold text-brand-navy">Номер заявки:</span> {{ $order->id }}</div>
            <div class="mt-2"><span class="font-semibold text-brand-navy">Курс:</span> {{ $order->course?->title }}</div>
            <div class="mt-2"><span class="font-semibold text-brand-navy">Статус:</span> {{ $order->status_label }}</div>
        </div>

        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('orders.download-contract', $order) }}" class="btn-primary">Скачать договор</a>
            <a href="{{ route('dashboard') }}" class="btn-secondary">Вернуться в личный кабинет</a>
        </div>
    </section>
@endsection
