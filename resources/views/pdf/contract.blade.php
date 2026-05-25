<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Договор № {{ $order->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827;
            line-height: 1.55;
            margin: 32px;
        }
        .header {
            border-bottom: 2px solid #0d2d50;
            padding-bottom: 14px;
            margin-bottom: 24px;
        }
        .company {
            font-size: 18px;
            font-weight: 700;
            color: #0d2d50;
        }
        .subtitle {
            font-size: 11px;
            color: #4b5563;
            margin-top: 4px;
        }
        h1 {
            font-size: 18px;
            margin: 0 0 14px;
            color: #0d2d50;
        }
        h2 {
            font-size: 14px;
            margin: 20px 0 10px;
            color: #0d2d50;
        }
        .meta {
            margin-bottom: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th,
        td {
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background: #eff6ff;
            width: 32%;
        }
        .signatures {
            margin-top: 42px;
        }
        .signature-line {
            display: inline-block;
            width: 42%;
            border-top: 1px solid #111827;
            margin-top: 48px;
            padding-top: 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company">АО «Специализированный депозитарий «ИНФИНИТУМ»</div>
        <div class="subtitle">Демонстрационный MVP корпоративного университета</div>
    </div>

    <h1>Договор на оказание услуг онлайн-обучения № {{ $order->id }}</h1>
    <div class="meta">Дата формирования: {{ now()->format('d.m.Y') }}</div>

    <h2>1. Стороны</h2>
    <p>
        Исполнитель: АО «Специализированный депозитарий «ИНФИНИТУМ» в рамках демонстрационного MVP корпоративного университета.<br>
        Заказчик/слушатель: {{ $order->full_name }}.<br>
        Email: {{ $order->email }}.<br>
        Телефон: {{ $order->phone ?: 'Не указан' }}.<br>
        Организация: {{ $order->organization ?: 'Не указана' }}.<br>
        Должность: {{ $order->position ?: 'Не указана' }}.
    </p>

    <h2>2. Предмет договора</h2>
    <p>Исполнитель предоставляет доступ к онлайн-курсу: «{{ $order->course?->title }}».</p>

    <h2>3. Данные заявки</h2>
    <table>
        <tr><th>Номер договора</th><td>{{ $order->id }}</td></tr>
        <tr><th>Дата формирования</th><td>{{ now()->format('d.m.Y') }}</td></tr>
        <tr><th>ФИО</th><td>{{ $order->full_name }}</td></tr>
        <tr><th>Email</th><td>{{ $order->email }}</td></tr>
        <tr><th>Телефон</th><td>{{ $order->phone ?: 'Не указан' }}</td></tr>
        <tr><th>Организация</th><td>{{ $order->organization ?: 'Не указана' }}</td></tr>
        <tr><th>ИНН</th><td>{{ $order->inn ?: 'Не указан' }}</td></tr>
        <tr><th>Должность</th><td>{{ $order->position ?: 'Не указана' }}</td></tr>
        <tr><th>Курс</th><td>{{ $order->course?->title }}</td></tr>
        <tr><th>Стоимость</th><td>{{ number_format($order->course?->price ?? 0, 0, ',', ' ') }} рублей</td></tr>
    </table>

    <h2>4. Стоимость</h2>
    <p>Стоимость курса составляет {{ number_format($order->course?->price ?? 0, 0, ',', ' ') }} рублей.</p>

    <h2>5. Порядок оказания услуг</h2>
    <p>Обучение проводится в дистанционном формате. Информация о доступе к курсу передаётся после обработки заявки администратором.</p>

    <h2>6. Обработка данных</h2>
    <p>Пользователь подтверждает согласие на обработку данных, указанных в заявке, для целей оформления обучения и подготовки документов.</p>

    <h2>7. Заключительные положения</h2>
    <p>Документ сформирован автоматически на основании данных, введённых пользователем на сайте.</p>

    <div class="signatures">
        <div class="signature-line">Исполнитель</div>
        <div class="signature-line" style="float: right;">Слушатель</div>
    </div>
</body>
</html>
