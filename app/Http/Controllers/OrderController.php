<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Course;
use App\Models\Order;
use App\Services\ContractService;
use App\Services\CsvExportService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function dashboard(): View
    {
        $orders = $this->userOrders();

        return view('dashboard', [
            'orders' => $orders,
            'orderCount' => $orders->count(),
            'processedCount' => $orders->filter(
                fn (Order $order) => $order->status === OrderStatus::PROCESSED
            )->count(),
        ]);
    }

    public function index(): View
    {
        $orders = auth()->user()
            ->orders()
            ->with('course')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function create(): View
    {
        $courses = Course::query()
            ->where('is_active', true)
            ->orderBy('title')
            ->get();

        return view('orders.create', [
            'courses' => $courses,
            'selectedCourseId' => request()->integer('course'),
            'user' => auth()->user(),
        ]);
    }

    public function store(
        StoreOrderRequest $request,
        ContractService $contractService,
        CsvExportService $csvExportService
    ): RedirectResponse {
        $data = $request->validated();
        $user = $request->user();

        $order = DB::transaction(function () use ($data, $user, $contractService, $csvExportService) {
            /** @var \App\Models\Order $order */
            $order = Order::create([
                'user_id' => $user->id,
                'course_id' => $data['course_id'],
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'organization' => $data['organization'] ?? null,
                'inn' => $data['inn'] ?? null,
                'position' => $data['position'] ?? null,
                'comment' => $data['comment'] ?? null,
                'status' => OrderStatus::DOCUMENTS_READY->value,
                'agreement_accepted' => true,
            ]);

            $order->load('course');

            $contractPath = $contractService->generate($order);
            $csvPath = $csvExportService->generateForOrder($order);

            $order->update([
                'contract_pdf_path' => $contractPath,
                'student_csv_path' => $csvPath,
            ]);

            return $order->fresh(['course']);
        });

        return redirect()->route('orders.success', $order);
    }

    public function show(Order $order): View
    {
        $this->ensureOwnership($order);
        $order->load('course');

        return view('orders.show', compact('order'));
    }

    public function success(Order $order): View
    {
        $this->ensureOwnership($order);
        $order->load('course');

        return view('orders.success', compact('order'));
    }

    protected function ensureOwnership(Order $order): void
    {
        abort_unless($order->user_id === auth()->id(), 403);
    }

    protected function userOrders(): Collection
    {
        return auth()->user()
            ->orders()
            ->with('course')
            ->latest()
            ->get();
    }
}
