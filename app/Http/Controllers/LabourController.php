<?php

namespace App\Http\Controllers;

use App\Models\Labour;
use Illuminate\Http\Request;

class LabourController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('name');

        $labours = Labour::where('name', 'like', "%$query%")
            ->limit(10)
            ->get(['id', 'name', 'mobile']);

        return response()->json($labours);
    }
}
