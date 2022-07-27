<?php

namespace App\Http\Livewire\Customer\Bids;

use App\Models\BidReview;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Profile extends Component
{
    public $bid;
    public $rating;
    public $feedback;

    protected $rules = [
        'rating' => 'required|numeric|max:5|min:1',
        'feedback' => 'required|string|max:2000'
    ];

    public function mount()
    {

    }

    public function render()
    {
        return view('livewire.customer.bids.profile');
    }

    public function submitReview()
    {
        $data = $this->validate();

        if ($this->bid->review) {
            $this->addError('feedback', 'Review already submitted');
        }
        $this->emitUp('submitReview', $data);
    }
}
