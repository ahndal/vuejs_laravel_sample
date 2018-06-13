<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Categories::all();
        return $categories;
    }
    
    public function store(Request $request)
    {
        $categories                 = new Categories();
        $categories->name           = $request->name;
        $categories->description    = $request->description;
        $categories->status         = '1';
        $categories->save();
    }
    
    public function update(Request $request)
    {
        $categories                 = Categories::findOrFail($request->id);
        $categories->name           = $request->name;
        $categories->description    = $request->description;
        $categories->status         = '1';
        $categories->save();
    }
    
    public function desactivar(Request $request)
    {
        $categories                 = Categories::findOrFail($request->id);
        $categories->status         = '0';
        $categories->save();
    }
    
    public function activar(Request $request)
    {
        $categories                 = Categories::findOrFail($request->id);
        $categories->status         = '1';
        $categories->save();
    }
}
