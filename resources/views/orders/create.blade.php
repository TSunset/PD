@extends('layouts.app')

@section('title', 'Создание заявки')

@section('content')
    <section class="grid gap-6 xl:grid-cols-[1.4fr_0.8fr]">
        <div class="panel p-8">
            <span class="section-kicker">Новая заявка</span>
            <h1 class="mt-4 text-3xl font-extrabold text-brand-navy">Оформление онлайн-обучения</h1>
            <p class="mt-3 text-brand-slate">Заполните анкету. После отправки система автоматически сформирует PDF-договор и CSV-файл по заявке.</p>

            <form action="{{ route('orders.store') }}" method="POST" class="mt-8 grid gap-5">
                @csrf
                <input type="text" name="website" value="{{ old('website') }}" class="hidden" tabindex="-1" autocomplete="off">

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="full_name" class="mb-2 block text-sm font-semibold text-brand-navy">ФИО</label>
                        <input id="full_name" name="full_name" type="text" class="input-field" value="{{ old('full_name', $user->name) }}" required>
                    </div>
                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-brand-navy">Email</label>
                        <input id="email" name="email" type="email" class="input-field" value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="phone" class="mb-2 block text-sm font-semibold text-brand-navy">Телефон</label>
                        <input id="phone" name="phone" type="text" class="input-field" value="{{ old('phone', $user->phone) }}">
                    </div>
                    <div>
                        <label for="course_id" class="mb-2 block text-sm font-semibold text-brand-navy">Выбранный курс</label>
                        <select id="course_id" name="course_id" class="select-field" required>
                            <option value="">Выберите курс</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}" @selected(old('course_id', $selectedCourseId) == $course->id)>
                                    {{ $course->title }} — {{ $course->formatted_price }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="organization" class="mb-2 block text-sm font-semibold text-brand-navy">Название организации</label>
                        <input id="organization" name="organization" type="text" class="input-field" value="{{ old('organization') }}">
                    </div>
                    <div>
                        <label for="inn" class="mb-2 block text-sm font-semibold text-brand-navy">ИНН организации</label>
                        <input id="inn" name="inn" type="text" class="input-field" value="{{ old('inn') }}">
                    </div>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="position" class="mb-2 block text-sm font-semibold text-brand-navy">Должность</label>
                        <input id="position" name="position" type="text" class="input-field" value="{{ old('position') }}">
                    </div>
                    <div>
                        <label for="comment" class="mb-2 block text-sm font-semibold text-brand-navy">Комментарий</label>
                        <textarea id="comment" name="comment" rows="4" class="textarea-field">{{ old('comment') }}</textarea>
                    </div>
                </div>

                <div class="muted-panel p-5 text-sm leading-7 text-brand-slate">
                    <a href="#agreement-terms" class="font-semibold text-brand-sky underline underline-offset-4">Открыть условия договора</a>
                    <div id="agreement-terms" class="mt-3">
                        Исполнитель предоставляет доступ к выбранному курсу после обработки заявки. Договор формируется автоматически на основе введённых данных и используется для дальнейшей ручной обработки менеджером.
                    </div>
                </div>

                <label class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-4 text-sm text-brand-slate">
                    <input type="checkbox" name="agreement_accepted" value="1" class="mt-1 h-4 w-4 rounded border-slate-300" @checked(old('agreement_accepted'))>
                    <span>Согласен с условиями договора и обработкой данных для оформления обучения.</span>
                </label>

                <div class="flex flex-wrap gap-3">
                    <button type="submit" class="btn-primary">Сформировать заявку и договор</button>
                    <a href="{{ route('dashboard') }}" class="btn-secondary">Вернуться в кабинет</a>
                </div>
            </form>
        </div>

        <aside class="space-y-6">
            <div class="panel p-6">
                <div class="text-sm font-semibold uppercase tracking-[0.22em] text-brand-sky">Что произойдёт после отправки</div>
                <ol class="mt-4 space-y-3 text-sm leading-7 text-brand-slate">
                    <li>1. Данные будут провалидированы на сервере.</li>
                    <li>2. Система создаст запись в таблице заявок.</li>
                    <li>3. Сформируются PDF-договор и CSV по студенту.</li>
                    <li>4. Документы станут доступны вам и администратору.</li>
                </ol>
            </div>
        </aside>
    </section>
@endsection
