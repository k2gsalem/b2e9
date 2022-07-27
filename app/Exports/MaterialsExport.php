<?php

namespace App\Exports;

use App\Models\Material;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MaterialsExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;

    public function headings(): array
    {
        return [
            'title',
            'price',
            'density'
        ];
    }

    /**
     * @var Material $record
     */
    public function map($record): array
    {
        return [
            $record->title,
            $record->price,
            $record->density,
        ];
    }

    public function query()
    {
        return Material::query();
        return $this->custom_query ?: Material::query();
    }

    public function customQuery($query)
    {
        $this->custom_query = $query;
        return $this;
    }
}
