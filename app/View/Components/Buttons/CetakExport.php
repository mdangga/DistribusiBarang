<?php

namespace App\View\Components\Buttons;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CetakExport extends Component
{
    public $cetak;
    public $export;

    public function __construct($cetak, $export)
    {
        $this->cetak = $cetak;
        $this->export = $export;
    }

    public function render()
    {
        return view('components.buttons.cetak-export');
    }
}