<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProjectsExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;

    public function headings(): array
    {
        return [
            'ID',
            'Project',
            'Customer Name',
            'Customer Phone',
            'Customer GST',
            'Material Price',
            'Valid Bids',
            'Purchased Bids',
            'Selected Bid',
            'Supplier Name',
            'Supplier Phone',
            'Txn ID',
            'Base Amount',
            'GST',
            'Final Amount',
            'Pay Mode',
            'Paid At',
            'Publish At',
            'Close At',
            'Created At',
        ];
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->title,
            $item->user->name,
            $item->user->phone,
            $item->user->gst_number,
            $item->raw_material_price,
            $item->valid_bids_count,
            optional($item->transaction)->bids,
            $item->selected_bid_value,
            $item->selected_bid ? optional($item->selected_bid->user)->name : '',
            $item->selected_bid ? optional($item->selected_bid->user)->phone : '',
            $item->txn_id,
            optional($item->transaction)->base_amount,
            optional($item->transaction)->gst_amount,
            optional($item->transaction)->final_amount,
            optional($item->transaction)->mode,
            optional($item->transaction)->paid_at,
            $item->publish_at,
            $item->close_at,
            $item->created_at
        ];
    }

    public function query()
    {
        return $this->custom_query ?: Project::query();
    }

    public function customQuery($query)
    {
        $this->custom_query = $query;
        return $this;
    }
}
