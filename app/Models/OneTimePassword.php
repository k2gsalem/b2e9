<?php

namespace App\Models;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class OneTimePassword extends BaseModel
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'phone',
        'email',
        'code',
    ];

    protected $casts = [
        'sent_count' => 'integer',
        'verified_at' => 'datetime'
    ];

    public function routeNotificationForSms()
    {
        return $this->phone;
    }

    public function generate(int $digits = 4)
    {
        $i = 0;
        $code = "";
        while ($i < $digits) {
            $code .= mt_rand(0, 9);
            $i++;
        }
        return str_pad($code, $digits, '0', STR_PAD_LEFT);
    }

    public function send()
    {
        $this->notify(new \App\Notifications\OneTimePassword);
        $this->sent_count++;
        $this->save();
        return true;
    }

    public function verify(string $code)
    {
        if (is_null($this->verified_at) && $this->code == $code)
        {
            $this->verified_at = now();
            $this->save();
            return true;
        }
        return false;
    }
}
