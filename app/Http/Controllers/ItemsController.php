<?php

namespace App\Http\Controllers;

use App\Models\Items;
use Illuminate\Http\Request;
use App\Exports\ItemsExport;
use Maatwebsite\Excel\Facades\Excel;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Items = Items::all();
        return view('items.index', compact('Items')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $Item = new Items;
        $request->validate([
         'name'=> 'required',
         'price'=> 'required'
        ]);
        
        $Item->name = $request->name; 
        $Item->price = $request->price;
        $Item->save();
        return redirect()->to('item')->with('Item created successfully'); 
    }

    /**
     * Export the specified resource.
     */
    public function exportToExcel()
    {
        $fileName = 'items.xlsx';
        return Excel::download(new ItemsExport, $fileName);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Items $items)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Items $item)
    {
        return view('items.edit', compact('item'));
    }    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Items $item)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
        ]);
    
        $item->name = $request->name;
        $item->price = $request->price;
        $item->save();
    
        return redirect()->route('item.index')->with('success', 'Item updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Items $item)
    {
        $item->delete();
        return redirect()->route('item.index')->with('Item deleted successfully');
    }
}
