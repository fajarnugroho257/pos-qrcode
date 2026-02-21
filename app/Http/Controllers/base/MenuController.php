<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['title'] = 'Management Menu Aplikasi';
        $data['desc'] = 'Data Menu Aplikasi';
        $search = $request->query('search');
        $data['rs_menu'] = Menu::with('children')->where('menu_name', 'LIKE', "%{$search}%")->where('menu_parent', '0')->orderBy('menu_level')->get();

        return view('base.menu.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // select option
        $allMenus = Menu::with('children')->where('menu_parent', '0')->get();
        $rs_option[] = ['id' => '0', 'name' => 'Root'];
        foreach ($allMenus as $menu) {
            $rs_option[] = ['id' => $menu->menu_id, 'name' => $menu->menu_name];
            $this->formatOptions($menu->children, 1, $rs_option);
        }
        $data['rs_option'] = $rs_option;
        //
        $data['title'] = 'Management Menu Aplikasi';
        $data['desc'] = 'Tambah Menu Aplikasi';

        return view('base.menu.add_menu', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'menu_name' => 'required',
            'menu_icon' => 'required',
            'menu_url' => 'required',
            'menu_st' => 'required',
            'menu_parent' => 'required',
        ]);
        $level = 1; // Default jika root
        if ($request->menu_parent !== '0') {
            $parent = Menu::find($request->menu_parent);
            $level = $parent->menu_level + 1;
        }
        $menu_id = $this->last_menu_id();
        if ($menu_id) {
            Menu::create([
                'menu_id' => $menu_id,
                'menu_name' => $request->menu_name,
                'menu_icon' => $request->menu_icon,
                'menu_url' => $request->menu_url,
                'menu_st' => $request->menu_st,
                'menu_level' => $level,
                'menu_parent' => $request->menu_parent,
            ]);
        }

        // redirect
        return redirect()->route('menuAppAdd')->with('success', 'Data berhasil disimpan');
    }

    public function last_menu_id()
    {
        // get last data
        $last_data = Menu::select('menu_id')->orderBy('menu_id', 'DESC')->first();
        $last_number = substr($last_data->menu_id, 1, 6) + 1;
        $zero = '';
        for ($i = strlen($last_number); $i <= 3; $i++) {
            $zero .= '0';
        }
        $new_id = 'M' . $zero . $last_number;

        //
        return $new_id;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $menu_id)
    {
        $detail = Menu::where('menu_id', $menu_id)->first();
        if (empty($detail)) {
            return redirect()->route('menuApp')->with('error', 'Data tidak ditemukan');
        }
        $data['detail'] = $detail;
        // select option
        $allMenus = Menu::with('children')->where('menu_parent', '0')->get();
        $rs_option[] = ['id' => '0', 'name' => 'Root'];
        foreach ($allMenus as $menu) {
            $rs_option[] = ['id' => $menu->menu_id, 'name' => $menu->menu_name];
            $this->formatOptions($menu->children, 1, $rs_option);
        }
        $data['rs_option'] = $rs_option;
        //
        $data['title'] = 'Management Menu Aplikasi';
        $data['desc'] = 'Ubah Menu Aplikasi';

        // dd($data);
        return view('base.menu.edit', $data);
    }

    private function formatOptions($children, $level, &$options)
    {
        foreach ($children as $child) {
            // Menambahkan simbol "--" sebagai penanda level/kedalaman
            $prefix = str_repeat('-- ', $level);
            $options[] = ['id' => $child->menu_id, 'name' => $prefix . $child->menu_name];
            // $options[$child->menu_id] = $prefix . $child->menu_name;

            if ($child->children->isNotEmpty()) {
                $this->formatOptions($child->children, $level + 1, $options);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $menu_id)
    {
        $request->validate([
            'menu_name' => 'required',
            'menu_icon' => 'required',
            'menu_url' => 'required',
            'menu_st' => 'required',
            'menu_parent' => 'required',
        ]);
        // detail
        $detail = Menu::where('menu_id', $menu_id)->first();
        if (empty($detail)) {
            return redirect()->route('menuApp')->with('error', 'Data tidak ditemukan');
        }
        $level = 1; // Default jika root
        if ($request->menu_parent !== '0') {
            $parent = Menu::find($request->menu_parent);
            $level = $parent->menu_level + 1;
        }
        Menu::where('menu_id', $request->menu_id)->update([
            'menu_name' => $request->menu_name,
            'menu_icon' => $request->menu_icon,
            'menu_st' => $request->menu_st,
            'menu_level' => $level,
            'menu_url' => $request->menu_url,
            'menu_parent' => $request->menu_parent == '0' ? '0' : $request->menu_parent,
        ]);

        return redirect()->route('menuAppEdit', [$menu_id])->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $menu_id)
    {
        $detail = Menu::where('menu_id', $menu_id)->first();
        if (empty($detail)) {
            return redirect()->route('menuApp')->with('error', 'Data tidak ditemukan');
        }
        if ($detail->delete()) {
            return redirect()->route('menuApp')->with('success', 'Data berhasil dihapus');
        }
    }
}
