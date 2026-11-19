<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\Controller;
use App\Menu;
use File;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::orderBy('created_at', 'DESC')->paginate(9);
        return view('dashboard.menu', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $hasCategory = Schema::hasColumn('menu', 'category');
        $menu = new Menu;
        $menu->name = $request->name;
        $menu->price = str_replace(".", "", $request->price);
        $menu->description = $request->description;
        $menu->min_order = $request->min_order ?: 1;

        if ($hasCategory) {
            $menu->category = $request->get('category', 'makanan');
        }

        if ($request->hasFile('pict') && $request->file('pict')->isValid()) {
            $extension = $request->pict->extension();
            $filename = md5(time()) . '.' . $extension;
            $path = public_path('assets/pictures/menu');
            $request->pict->move($path, $filename);
            $menu->pict = $filename;
        }

        $menu->save();
        return redirect()->route('food-menu.index')->with('success', 'Menu baru berhasil ditambahkan ke daftar menu.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu = Menu::find($id);
        return view('dashboard.menu-edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $hasCategory = Schema::hasColumn('menu', 'category');
        $menu = Menu::find($id);
        $menu->name = $request->name;
        $menu->price = str_replace(".", "", $request->price);
        $menu->description = $request->description;
        $menu->min_order = $request->min_order ?: 1;

        if ($hasCategory) {
            $menu->category = $request->get('category', 'makanan');
        }

        if ($request->hasFile('pict') && $request->file('pict')->isValid()) {
            $extension = $request->pict->extension();
            $filename = md5(time()) . '.' . $extension;
            $path = public_path('assets/pictures/menu');
            $request->pict->move($path, $filename);
            $menu->pict = $filename;
        }

        $menu->save();
        return redirect()->route('food-menu.index')->with('success', 'Data menu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $menu = Menu::find($id);
            $menu->delete();
            $path = public_path('assets/pictures/menu/'.$menu->pict);
            File::delete($path);
            return redirect()->route('food-menu.index')->with('success', 'Menu has been removed from menu list.');   
        } catch (Exception $e) {
            return redirect()->route('food-menu.index')->with('failed', 'Operation terminated.');   
        }
    }
}
