<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::latest()->paginate(10);
        return view('warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        return view('warehouses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:warehouses',
            'name' => 'required',
        ]);

        Warehouse::create($request->all());

        return redirect()
            ->route('warehouses.index')
            ->with('success', 'Warehouse created');
    }
}
