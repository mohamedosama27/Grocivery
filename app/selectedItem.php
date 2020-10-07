<?php

namespace App;


class selectedItem
{ 
    public $item;
    public $Quantity = 0;
    public function __construct($id)
    {
        $this->item =\App\item::find($id);
        $this->Quantity = 0.5;
    }
}
