<?php


namespace App\Traits;


trait LivewireAlert
{
    use \Jantinnerezo\LivewireAlert\LivewireAlert;

    public function success(string $message = '', array $options = [])
    {
        $this->alert('success', $message, $options);
    }

    public function info(string $message = '', array $options = [])
    {
        $this->alert('info', $message, $options);
    }

    public function warning(string $message = '', array $options = [])
    {
        $this->alert('warning', $message, $options);
    }

    public function error(string $message = '', array $options = [])
    {
        $this->alert('error', $message, $options);
    }

    public function question(string $message = '', array $options = [])
    {
        $this->alert('question', $message, $options);
    }
}
