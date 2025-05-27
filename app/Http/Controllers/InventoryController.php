<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function inventoryList()
    {
        return view('inventory.stock');
    }
}
