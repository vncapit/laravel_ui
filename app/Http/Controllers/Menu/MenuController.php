<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        $this->validate($request, [
            'id' => 'required|int|exists:menus,id',
            'pid' => 'required|int',
            'name' => 'required|string',
            'path' => 'required|string',
            'icon' => 'required|string',
        ]);

        $menu = Menu::find($request->id);
        $menu->pid = $request->pid;
        $menu->name = $request->name;
        $menu->path = $request->path;
        $menu->icon = $request->icon;
        return $menu->save();
    }

    public function addMenu(Request $request)
    {
        $this->validate($request, [
            'pid' => 'nullable|exists:menus,id',
            'name' => 'required|string',
            'path' => 'required|string',
            'icon' => 'required|string',
        ]);

        try {
            \Log::info('a', [$request]);
            $menu = new Menu();
            $menu->pid = $request->pid ? $request->pid : 0;
            $menu->name = $request->name;
            $menu->path = $request->path;
            $menu->icon = $request->icon;
            return $menu->save();
        }
        catch (\Exception $exception) {
            \Log::info('err', [$exception]);
        }
    }


}
