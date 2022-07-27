<?php

namespace App\Http\Livewire\User\Profile;

use App\Models\Location;
use App\Models\ManufacturingUnit;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class UpdateAddressForm extends Component
{
    public $registered_address;
    public $manufacturing_unit;

    public function mount()
    {
        $this->fetchData();
    }

    public function render()
    {
        return view('livewire.user.profile.update-address-form');
    }

    public function rules()
    {
        return [
            'registered_address.address' => ['required', 'string', 'max:255'],
            'registered_address.pincode' => [
                'required', 'regex:/^[1-9][0-9]{5}$/',
                function($attribute, $value, $fail) {
                    if (is_null(Location::fetch($value)))
                        $fail('Pincode not available');
                }
            ],
            'manufacturing_unit.address' => ['nullable', 'string', 'max:255'],
            'manufacturing_unit.pincode' => [
                'nullable', 'regex:/^[1-9][0-9]{5}$/',
                function($attribute, $value, $fail) {
                    if (is_null(Location::fetch($value)))
                        $fail('Pincode not available');
                }
            ],
        ];
    }

    public function fetchData()
    {
        $this->registered_address = auth()->user()->hasOne(ManufacturingUnit::class)->oldestOfMany()->first();
        $this->manufacturing_unit = auth()->user()->manufacturing_unit;
        if ($this->registered_address->is($this->manufacturing_unit))
            $this->manufacturing_unit = new ManufacturingUnit();
    }

    public function save()
    {
        $this->validate();

        $this->registered_address->save();
        if ($this->manufacturing_unit->exists) {
            if ($this->manufacturing_unit->address) {
                if ($this->manufacturing_unit->pincode == auth()->user()->manufacturing_unit->pincode)
                    $this->manufacturing_unit->save();
                else
                    auth()->user()->manufacturing_units()->save(new ManufacturingUnit([
                        'address' => $this->manufacturing_unit->address,
                        'pincode' => $this->manufacturing_unit->pincode
                    ]));
            }
            else
                $this->manufacturing_unit->delete();
        }
        else if ($this->manufacturing_unit->address) {
            auth()->user()->manufacturing_units()->save($this->manufacturing_unit);
        }

        $this->emit('saved');
        $this->fetchData();
    }
}
