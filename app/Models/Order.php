<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'full_name',
        'email',
        'phone',
        'organization',
        'inn',
        'position',
        'comment',
        'status',
        'contract_pdf_path',
        'student_csv_path',
        'agreement_accepted',
    ];

    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
            'agreement_accepted' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status->label();
    }

    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at?->format('d.m.Y H:i') ?? '-';
    }
}
