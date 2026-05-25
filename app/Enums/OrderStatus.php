<?php

namespace App\Enums;

enum OrderStatus: string
{
    case NEW = 'new';
    case DOCUMENTS_READY = 'documents_ready';
    case FORWARDED_TO_MANAGER = 'forwarded_to_manager';
    case IN_PROGRESS = 'in_progress';
    case PROCESSED = 'processed';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::NEW => 'Новая',
            self::DOCUMENTS_READY => 'Документы сформированы',
            self::FORWARDED_TO_MANAGER => 'Передано менеджеру',
            self::IN_PROGRESS => 'В обработке',
            self::PROCESSED => 'Обработано',
            self::REJECTED => 'Отклонено',
        };
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $status) => [$status->value => $status->label()])
            ->all();
    }
}
