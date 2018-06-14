<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;

class CategoriesController extends Controller
{
    function __construct()
    {
        //if (!$request->ajax()) return redirect('/');
    }

    public function index(Request $request)
    {
        $option = $request->option;
        $keyword = $request->keyword;

        if($option!='' && $option!='') {
            $categories = Categories::where($option, 'like', '%'.$keyword.'%')->orderBy('id', 'desc')->paginate(3);
        } else {
            $categories = Categories::orderBy('id', 'desc')->paginate(3);
        }

        return [
            'pagination' => [
                'total'         => $categories->total(),
                'current_page'  => $categories->currentPage(),
                'per_page'      => $categories->perPage(),
                'last_page'     => $categories->lastPage(),
                'from'          => $categories->firstItem(),
                'to'            => $categories->lastItem(),
            ],
            'categories' => $categories
        ];
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
