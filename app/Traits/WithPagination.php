<?php


namespace App\Traits;


trait WithPagination
{
    use \Livewire\WithPagination;

    public $pageName = 'page';
    public $perPage = 10;
}
