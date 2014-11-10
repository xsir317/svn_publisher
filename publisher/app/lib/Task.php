<?php
use Illuminate\Support\Facades\Facade;

class Task extends Facade {

    protected static function getFacadeAccessor() { return 'task'; }
}

