@props(['status', 'label'])

@php
    $value = $status instanceof \App\Enums\OrderStatus ? $status->value : (string) $status;

    $classes = match ($value) {
        'documents_ready' => 'status-documents-ready',
        'forwarded_to_manager' => 'status-forwarded',
        'in_progress' => 'status-progress',
        'processed' => 'status-processed',
        'rejected' => 'status-rejected',
        default => 'status-new',
    };
@endphp

<span {{ $attributes->class("status-dot inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {$classes}") }}>
    {{ $label }}
</span>
