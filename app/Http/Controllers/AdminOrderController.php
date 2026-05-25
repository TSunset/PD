<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Models\Course;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminOrderController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            'total' => Order::count(),
            'new' => Order::where('status', OrderStatus::NEW->value)->count(),
            'ready' => Order::where('status', OrderStatus::DOCUMENTS_READY->value)->count(),
            'processed' => Order::where('status', OrderStatus::PROCESSED->value)->count(),
        ];

        $latestOrders = Order::query()
            ->with('course')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'latestOrders' => $latestOrders,
        ]);
    }

    public function index(): View
    {
        $status = request('status');
        $courseId = request('course');
        $search = trim((string) request('search'));

        $orders = Order::query()
            ->with('course')
            ->when($status, fn (Builder $query) => $query->where('status', $status))
            ->when($courseId, fn (Builder $query) => $query->where('course_id', $courseId))
            ->when($search, function (Builder $query) use ($search) {
                $query->where(function (Builder $nested) use ($search) {
                    $nested
                        ->where('full_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('organization', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $courses = Course::query()
            ->where('is_active', true)
            ->orderBy('title')
            ->get();

        return view('admin.orders.index', [
            'orders' => $orders,
            'courses' => $courses,
            'statusOptions' => OrderStatus::options(),
        ]);
    }

    public function show(Order $order): View
    {
        $order->load('course', 'user');

        return view('admin.orders.show', [
            'order' => $order,
            'statusOptions' => OrderStatus::options(),
        ]);
    }

    public function updateStatus(UpdateOrderStatusRequest $request, Order $order): RedirectResponse
    {
        $order->update([
            'status' => $request->validated('status'),
        ]);

        return back()->with('status', 'Статус заявки обновлён.');
    }
}
