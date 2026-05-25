<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ContractController extends Controller
{
    public function downloadUserContract(Order $order): BinaryFileResponse
    {
        abort_unless($order->user_id === auth()->id(), 403);

        return $this->download($order);
    }

    public function downloadAdminContract(Order $order): BinaryFileResponse
    {
        abort_unless(auth()->user()?->isAdmin(), 403);

        return $this->download($order);
    }

    protected function download(Order $order): BinaryFileResponse
    {
        abort_unless($order->contract_pdf_path, 404);

        $path = storage_path('app/'.$order->contract_pdf_path);

        abort_unless(file_exists($path), 404);

        return response()->download($path, basename($path), [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
