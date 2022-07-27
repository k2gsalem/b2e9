<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class UsersExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;

    /**
     * @var User $item
     */
    public function map($item): array
    {
        return [
            $item->id,
            $item->name,
            $item->role,
            $item->phone,
            $item->email,
            optional($item->manufacturing_unit)->pincode,
            $item->organization_type,
            $item->gst_number,
            $item->referral_code,
            optional($item->referrer)->referral_code,
            $item->created_at
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Role',
            'Phone',
            'Email',
            'Pincode',
            'Type',
            'GST Number',
            'Referral Code',
            'Referred By',
            'Joined At',
        ];
    }

    public function query()
    {
        $query = User::query();

        if ($this->role) {
            switch ($this->role) {
                case 'Customer':
                    $query->whereIn('role', ['Customer', 'Both']);
                    break;
                case 'Supplier':
                    $query->whereIn('role', ['Supplier', 'Both']);
                    break;
                case 'Both':
                    $query->whereIn('role', ['Both']);
                    break;
            }
        }
        if (!is_null($this->active))
            $query->where('active', $this->active);

        if ($this->start_date)
            $query->whereDate('created_at', '>=', $this->start_date);
        if ($this->end_date)
            $query->whereDate('created_at', '<=', $this->end_date);
        $query->search($this->search)->orderByDesc('id');

        return $query;
    }

    public function search($val)
    {
        $this->search = $val;
        return $this;
    }

    public function startDate($val)
    {
        $this->start_date = $val;
        return $this;
    }

    public function endDate($val)
    {
        $this->end_date = $val;
        return $this;
    }

    public function role($val)
    {
        $this->role = $val;
        return $this;
    }

    public function active($val)
    {
        $this->active = $val;
        return $this;
    }
}
