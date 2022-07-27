<?php

namespace App\Http\Livewire\Customer\Projects;

use App\Models\Material;
use App\Models\Process;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $materials;
    public $project;
    public $publish_date;
    public $publish_time;
    public $closing_date;
    public $closing_time;
    public $eligibleSuppliers = 0;
    public $eligibleSupplierss = [];
    public $attachments = [];
    public $mime_types = [
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'image/vnd.dwg',
        'text/plain',
        'image/jpeg',
        'application/pdf',
        'image/png',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'application/x-rar',
        'image/tiff',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/zip',
//        'application/octet-stream'
    ];

    public $operationTypeIds = [];
    public $operationTypes;
    public $operationTypesFilter = '';

    public $manufacturingUnits;
    public $manufacturingUnitsFilter = '';

    public $instantPublish = false;

    public function rules()
    {
        return [
            'project.title' => ['required', 'regex:/^[_A-z0-9]*((-|\s)*[_A-z0-9])*$/', 'max:255'],
            'project.part_name' => ['required', 'string', 'max:255'],
            'project.drawing_number' => ['required', 'string', 'max:255'],
            'project.delivery_date' => ['required', 'date', 'after:'.now()->format('Y-m-d')],
            'project.manufacturing_unit_id' => ['required', 'numeric', Rule::exists('manufacturing_units', 'id')->where('user_id', request()->user()->id)],
            'project.location_preference' => ['required', 'numeric', 'min:1'],
            'project.raw_material_price' => ['required', 'numeric', 'min:10'],
            'project.description' => ['required', 'string'],
            'publish_date' => [
                'required', 'date',
//                'after:'.now()->addDays("-1")->format('Y-m-d')
            ],
            'publish_time' => [
                'required_with_all:publish_date', 'string',
//                function($attribute, $value, $fail) {
//                    if (Carbon::parse(request()->get('publish_date').' '.$value) < now()) {
//                        $fail('The Publish Time must be greater than now');
//                    }
//                }
            ],
            'closing_date' => [
                'required_with_all:publish_date,publish_time', 'date',
            ],
            'closing_time' => [
                'required_with_all:publish_date,publish_time,closing_date', 'string',
                function($attribute, $value, $fail) {
                    if (Carbon::parse($this->closing_date.' '.$value) < Carbon::parse($this->publish_date.' '.$this->publish_time)->addHours(3)) {
                        $fail('The Closing Time must be greater than 3 hrs from publish time');
                    }
                }
            ],
            'attachments.*' => ['required', 'mimetypes:'.implode(",", $this->mime_types), 'max:10000'],
        ];
    }

    public function messages()
    {
        return [
            'attachments.*.mimetypes' => 'Unsupported file'
        ];
    }

    public function updated($field)
    {
        switch ($field) {
            case 'publish_date':
            case 'publish_time':
            case 'closing_date':
            case 'closing_time':
                $this->validateOnly('publish_date');
                $this->validateOnly('publish_time');
                $this->validateOnly('closing_date');
                $this->validateOnly('closing_time');
                break;
            case 'project.manufacturing_unit_id':
            case 'project.location_preference':
            case 'operationTypeIds':
                $this->eligibleSuppliers = 0;
                $this->validateOnly($field);
                $this->calculateEligibleSuppliers();
                break;
            case 'instantPublish':
                if ($this->instantPublish) {
                    $this->publish_date = date('Y-m-d');
                    $this->publish_time = date('H:i:s');
                }
                $this->validateOnly('publish_date');
                $this->validateOnly('publish_time');
                $this->validateOnly('closing_date');
                $this->validateOnly('closing_time');
                break;
            default:
                $this->validateOnly($field);
        }
    }

    public function updatedAttachments()
    {
//        $mimes = [];
//        foreach ($this->attachments as $attachment) {
//            $mimes[] = $attachment->getMimeType();
//        }
//        error_log(implode(", ", $mimes));
//        Log::info(implode(", ", $mimes));
        $this->validate([
            'attachments.*' => ['required', 'mimetypes:'.implode(",", $this->mime_types), 'max:10240'],
        ]);
    }

    public function mount()
    {
        $this->materials = Material::query()->orderBy('title')->get();
        $this->project = new Project([
            'manufacturing_unit_id' => auth()->user()->manufacturing_unit->id
        ]);
    }

    public function render(Request $request)
    {
        $this->operationTypes = Process::search($this->operationTypesFilter)
            ->select('id', 'title')
            ->orderBy('title')->get();
        /*foreach ($this->operationTypes as $type) {
            array_push($this->operationTypeIds, $type->id);
        }*/
        $this->manufacturingUnits = $request->user()->manufacturing_units()
            ->where('address', 'like', '%'.$this->manufacturingUnitsFilter.'%')
            ->select('id', 'address', 'pincode')
            ->orderBy('address')->get();
        $this->project->load('manufacturing_unit');

        return view('livewire.customer.projects.create');
    }

    public function selectOperationType($id)
    {
        $index = array_search($id, $this->operationTypeIds);
        if ($index > -1)
            array_splice($this->operationTypeIds, $index, 1);
        else
            array_push($this->operationTypeIds, $id);
        $this->updated('operationTypeIds');
    }

    public function calculateEligibleSuppliers()
    {
        $this->eligibleSuppliers = 0;
        $this->eligibleSupplierss = [];
        $location_preference = $this->project->location_preference;
        $mu = $this->project->manufacturing_unit;
        if ($mu && $location_preference && is_numeric($location_preference) && $location_preference > 0)
        {
            $operation_type_ids = $this->operationTypeIds;
            $this->eligibleSupplierss = User::query()
                ->select('id', 'name')
                ->whereKeyNot(request()->user()->id)
                ->whereIn('role', ['supplier', 'both'])
                ->where(function ($query) use ($operation_type_ids) {
                    $query->whereHas('processes', function ($q) use ($operation_type_ids) {
                        $q->whereIn('process_id', $operation_type_ids);
                    })
                    ->orWhereHas('machines', function ($q) use ($operation_type_ids) {
                        $q->whereIn('process_id', $operation_type_ids);
                    });
                })
                ->whereHas('manufacturing_unit', function ($query) use ($mu, $location_preference) {
                    $query->select('id')->distance($mu->toArray())
                        ->having('distance', '<', $location_preference);
                })
                ->pluck('name');
            $this->eligibleSuppliers = count($this->eligibleSupplierss);
        }
    }

    public function create(Request $request)
    {
        $this->validate();

        $project = $this->project;
        $project->publish_at = Carbon::parse($this->publish_date.' '.$this->publish_time);
        if ($this->instantPublish) {
            $project->publish_at = now();
            $project->instant_publish = true;
        }
        $project->close_at = Carbon::parse($this->closing_date.' '.$this->closing_time);
        collect($this->attachments)->each(function($image) use ($project) {
            $project->addMedia($image->getRealPath())
                ->usingFileName($image->getClientOriginalName())
                ->toMediaCollection('attachments');
        });
        $request->user()->projects()->save($project);

        foreach ($this->operationTypeIds as $item)
        {
            $project->processes()->attach($item);
        }

        return redirect()->route('customer.projects.details', $project->id);
    }

    public function instantPublish($instant = true)
    {

    }
}
