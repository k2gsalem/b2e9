<?php

namespace App\Exports;

use App\Models\ProjectTransaction;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProjectTransactionsExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;

    public function headings(): array
    {
        return [
            'ID',
            'Txn ID',
            'Customer Name',
            'Customer Phone',
            'GST No',
            'Project',
            'Base Amount',
            'GST',
            'Final Amount',
            'Pay Mode',
            'Paid At',
            'Created At',
        ];
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->uuid,
            $item->project->user->name,
            $item->project->user->phone,
            $item->project->user->gst_number,
            $item->project->title,
            $item->base_amount,
            $item->gst_amount,
            $item->final_amount,
            $item->mode,
            $item->paid_at,
            $item->created_at
        ];
    }

    public function query()
    {
        return $this->custom_query ?: ProjectTransaction::query();
    }

    public function customQuery($query)
    {
        $this->custom_query = $query;
        return $this;
    }
}
