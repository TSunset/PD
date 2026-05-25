<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CsvExportService
{
    public function generateForOrder(Order $order): string
    {
        $directory = storage_path('app/csv');

        if (! File::exists($directory)) {
            File::makeDirectory($directory, 0775, true);
        }

        $relativePath = 'csv/student_order_'.$order->id.'.csv';
        $absolutePath = storage_path('app/'.$relativePath);

        $handle = fopen($absolutePath, 'w');

        fwrite($handle, "\xEF\xBB\xBF");
        fputcsv($handle, [
            'order_id',
            'full_name',
            'email',
            'phone',
            'organization',
            'inn',
            'position',
            'course_title',
            'course_price',
            'status',
            'created_at',
        ], ';');

        fputcsv($handle, $this->orderToRow($order), ';');
        fclose($handle);

        return $relativePath;
    }

    public function streamAllOrders(): StreamedResponse
    {
        $orders = Order::query()
            ->with('course')
            ->latest()
            ->get();

        return response()->streamDownload(function () use ($orders) {
            $handle = fopen('php://output', 'w');

            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, [
                'ID заявки',
                'Дата',
                'ФИО',
                'Email',
                'Телефон',
                'Организация',
                'ИНН',
                'Должность',
                'Курс',
                'Цена',
                'Статус',
            ], ';');

            $orders->each(function (Order $order) use ($handle) {
                fputcsv($handle, [
                    $order->id,
                    $order->formatted_created_at,
                    $order->full_name,
                    $order->email,
                    $order->phone,
                    $order->organization,
                    $order->inn,
                    $order->position,
                    $order->course?->title,
                    $order->course?->price,
                    $order->status_label,
                ], ';');
            });

            fclose($handle);
        }, 'orders_export.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * @return array<int, mixed>
     */
    protected function orderToRow(Order $order): array
    {
        return [
            $order->id,
            $order->full_name,
            $order->email,
            $order->phone,
            $order->organization,
            $order->inn,
            $order->position,
            $order->course?->title,
            $order->course?->price,
            $order->status_label,
            $order->created_at?->toDateTimeString(),
        ];
    }
}
