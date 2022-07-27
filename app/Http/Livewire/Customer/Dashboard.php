<?php

namespace App\Http\Livewire\Customer;

use App\Models\Project;
use App\Models\ProjectTransaction;
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

    public function render(Request $request)
    {
        $items = $this->fetchItems();

        $total_rfq = Project::query()->whereBelongsTo($request->user())->count();
        $live_rfq = Project::query()->whereBelongsTo($request->user())
            ->whereHas('transaction', function (Builder $query) {
                $query->whereNotNull('paid_at');
            })
            ->where('publish_at', '<=', now()->format('Y-m-d H:i:s'))
            ->where('close_at', '>=', now()->format('Y-m-d H:i:s'))
            ->count();

        $user = $this->user;
        $show_intro = false;
        if (empty($user->customer_intro)) {
            $user->customer_intro = true;
            $user->save();
            $show_intro = true;
        }
        return view('livewire.customer.dashboard', compact('items', 'total_rfq', 'live_rfq', 'user', 'show_intro'));
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

    public function getUserProperty()
    {
        return auth()->user();
    }

    public function fetchItems()
    {
        $query = Project::search($this->search)->whereBelongsTo(request()->user());

        if ($this->filter['start_date'])
            $query->where('publish_at', '>=', $this->filter['start_date']);
        if ($this->filter['end_date'])
            $query->where('publish_at', '<', Carbon::parse($this->filter['end_date'])->addDay());

        $query->orderByDesc('id');
        return $query->paginate($this->perPage, ['*'], $this->pageName);
    }

    public function itemDetails($id)
    {
        return redirect()->route('customer.projects.details', ['project' => $id]);
    }

    public function showIntro() {
        $user = auth()->user();
        $user->customer_intro = 0;
        $user->saveQuietly();

        return redirect()->route('customer.dashboard');
    }
}
