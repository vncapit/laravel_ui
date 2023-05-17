<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function getMenu(Request $request)
    {
        $menus = Menu::all();
        return view('menu', ['menus' => $menus] );
    }

    public function deleteMenu(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|int|exists:menus,id',
        ]);

        $menu = Menu::find($request->id);
        return $menu->delete();
    }

    public function editMenu(Request $request)
    {

    }
}
