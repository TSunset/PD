<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\CsvExportService;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CsvExportController extends Controller
{
    public function downloadOrderCsv(Order $order): BinaryFileResponse
    {
        abort_unless(auth()->user()?->isAdmin(), 403);
        abort_unless($order->student_csv_path, 404);

        $path = storage_path('app/'.$order->student_csv_path);

        abort_unless(file_exists($path), 404);

        return response()->download($path, basename($path), [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function exportAll(CsvExportService $csvExportService): StreamedResponse
    {
        abort_unless(auth()->user()?->isAdmin(), 403);

        return $csvExportService->streamAllOrders();
    }
}
