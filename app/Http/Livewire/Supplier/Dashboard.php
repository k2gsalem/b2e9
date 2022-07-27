<?php

namespace App\Http\Livewire\Supplier;

use App\Models\Bid;
use App\Models\Location;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;
    protected $perPage = 10;
    protected $pageName = 'page';

    public $search = '';
    public $filter = [
        'start_date' => '',
        'end_date' => ''
    ];

    public function mount()
    {

    }

    public function render(Request $request)
    {
        $user = $request->user();
        $items = $this->fetchItems();

        $show_intro = false;
        if (empty($user->supplier_intro)) {
            $user->supplier_intro = true;
            $user->save();
            $show_intro = true;
        }

        $user->project_earned = $user->bids()->approved()->count();
        $user->total_bid_value = $user->bids()->whereNotNull('approved_at')->sum('amount');
        return view('livewire.supplier.dashboard', compact('items', 'user', 'show_intro'));
    }

    public function rules()
    {
        return [
            'search' => ['nullable', 'string', 'max:50'],
            'filter.start_date' => ['nullable', 'date'],
            'filter.end_date' => [
                'nullable',
                'date',
                function($attribute, $value, $fail) {
                    if ($this->filter['start_date'] && Carbon::parse($value) < Carbon::parse($this->filter['start_date'])) {
                        $fail('Invalid end date');
                    }
                }
            ]
        ];
    }

    public function updating($field)
    {
        if (in_array($field, ['search', 'filter.start_date', 'filter.end_date'])) {
            $this->resetPage($this->pageName);
        }
    }

    public function updated($field)
    {
        if (in_array($field, ['filter.start_date', 'filter.end_date'])) {
            foreach (['filter.start_date', 'filter.end_date'] as $f)
                $this->validateOnly($f);
        }
        else
            $this->validateOnly($field);
    }

    public function fetchItems()
    {
        $query = auth()->user()->eligible_projects()
            ->search($this->search);
        if ($this->filter['start_date'])
            $query->where('close_at', '>=', $this->filter['start_date']);
        if ($this->filter['end_date'])
            $query->where('close_at', '<=', $this->filter['end_date']);

        $query->orderByDesc('publish_at');
        return $query->paginate($this->perPage, ['*'], $this->pageName);
    }

    public function itemDetails($id)
    {
        return redirect()->route('supplier.projects.details', ['project' => $id]);
    }

    public function showIntro() {
        $user = auth()->user();
        $user->supplier_intro = 0;
        $user->saveQuietly();

        return redirect()->route('supplier.dashboard');
    }
}
