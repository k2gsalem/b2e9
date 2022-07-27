<?php

namespace App\Http\Livewire\Auth;

use App\Models\Location;
use App\Models\ManufacturingUnit;
use App\Models\Process;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;
use Livewire\Component;

class RegistrationForm extends Component
{
    public $role = 'both';
    public $name;
    public $phone;
    public $email;
    public $contact_name;
    public $organization_type;
    public $incorporation_date;
    public $alternate_phone;
    public $gst_number;
    public $sales_turnover;
    public $employees_count;
    public $address1;
    public $pincode1;
    public $address2;
    public $pincode2;
    public $referral_code;
    public $organizationTypes = ['LLB', 'PVT LTD', 'Partnership', 'Proprietorship'];
    public $orgTypesFilterText = '';
    public $machineIds = [];
    public $machines;
    public $machinesFilterText = '';
    public $processIds = [];
    public $processes;
    public $processesFilterText = '';

    protected $messages = [
        'pincode1.exists' => 'This pincode not available',
        'pincode2.exists' => 'This pincode not available'
    ];

    protected function rules()
    {
        return [
            'role' => ['required', 'string', 'max:255'],
            'name' => ['required', 'regex:/^[a-zA-Z ]*$/', 'max:255'],
            'phone' => ['required', 'regex:/^[6-9][0-9]{9}$/', 'unique:users,phone'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'contact_name' => ['required', 'regex:/^[a-zA-Z ]*$/', 'max:255'],
            'organization_type' => ['required', 'string', 'max:255'],
            'incorporation_date' => ['required', 'date', 'before_or_equal:'.now()->format('Y-m-d')],
            'alternate_phone' => ['required', 'regex:/^[6-9][0-9]{9}$/', 'max:255'],
            'gst_number' => ['required', 'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/'],
            'sales_turnover' => ['required', 'numeric'],
            'employees_count' => ['required', 'numeric', 'min:1'],

            'address1' => ['required', 'string', 'max:255'],
            'pincode1' => [
                'required', 'regex:/^[1-9][0-9]{5}$/',
                function($attribute, $value, $fail) {
                    if (is_null(Location::fetch($value)))
                        $fail('Pincode not available');
                }
            ],
            'address2' => ['nullable', 'string', 'max:255'],
            'pincode2' => [
                'nullable', 'regex:/^[1-9][0-9]{5}$/',
                function($attribute, $value, $fail) {
                    if (is_null(Location::fetch($value)))
                        $fail('Pincode not available');
                }
            ],
            'machineIds' => ['required_unless:role,customer', 'array'],
//            'processIds' => ['required_unless:role,customer', 'array'],

            'referral_code' => ['nullable', 'string', 'max:255', Rule::exists('users', 'referral_code')],
        ];
    }

    /*protected function getMessages()
    {
        return [
          'gst_number.regex' => 'Invalid GST'
        ];
    }*/

    public function mount(Request $request)
    {
        $this->fill($request->old());
        $this->referral_code = $request->get('referral_code');
    }

    public function render()
    {
        $this->machines = Process::search($this->machinesFilterText)
            ->select('id', 'title')
            ->orderBy('title')->get();
        $this->processes = Process::search($this->processesFilterText)
            ->select('id', 'title')
            ->orderBy('title')->get();

        return view('livewire.auth.registration-form');
    }

    public function updated($field)
    {
        if (in_array($field, [])) {

        }
        else
            $this->validateOnly($field);
    }

    public function updatedUserRole($value)
    {
        if ($value == 'customer') {
            $this->processIds = [];
            $this->machineIds = [];
        }
    }

    public function selectMachine($id)
    {
        $index = array_search($id, $this->machineIds);
        if ($index > -1)
            array_splice($this->machineIds, $index, 1);
        else
            array_push($this->machineIds, $id);
    }

    public function selectProcess($id)
    {
        $index = array_search($id, $this->processIds);
        if ($index > -1)
            array_splice($this->processIds, $index, 1);
        else
            array_push($this->processIds, $id);
    }
}
