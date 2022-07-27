<?php

namespace App\Exports;

use App\Models\Subscription;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SubscriptionsExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;

    /**
     * @var Subscription $record
     */
    public function map($record): array
    {
        return [
            $record->id,
            $record->user->name,
            $record->user->phone,
            $record->user->email,
            $record->user->gst_number,
            $record->plan->code,
            optional($record->transaction)->amount,
            optional($record->transaction)->gst_amount,
            optional($record->transaction)->final_amount,
            optional($record->transaction)->uuid,
            $record->fresh_bids,
            $record->additional_bids,
            $record->starts_at,
            $record->ends_at
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Supplier',
            'Phone',
            'Email',
            'GST No',
            'Plan',
            'Amount',
            'GST',
            'Final Amount',
            'Txn ID',
            'Fresh Bids',
            'Editable Bids',
            'Starts At',
            'Ends At',
        ];
    }

    public function query()
    {
        return $this->custom_query ?: Subscription::query();
    }

    public function customQuery($query)
    {
        $this->custom_query = $query;
        return $this;
    }
}
