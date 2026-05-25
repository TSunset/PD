<?php

namespace App\Services;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

class ContractService
{
    public function generate(Order $order): string
    {
        $directory = storage_path('app/contracts');

        if (! File::exists($directory)) {
            File::makeDirectory($directory, 0775, true);
        }

        $relativePath = 'contracts/contract_order_'.$order->id.'.pdf';
        $absolutePath = storage_path('app/'.$relativePath);

        Pdf::loadView('pdf.contract', ['order' => $order])
            ->setPaper('a4')
            ->save($absolutePath);

        return $relativePath;
    }
}
