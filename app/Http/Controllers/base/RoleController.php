<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['title'] = 'Management Role Aplikasi';
        $data['desc'] = 'Data Role Aplikasi';
        //
        $query = Role::query();
        if ($request->filled('search')) {
            $query->where('role_name', 'LIKE', "%{$request->search}%");
        }
        $data['rs_role'] = $query->paginate(10)->withQueryString();

        return view('base.role.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = 'Management Role Aplikasi';
        $data['desc'] = 'Tambah Role Aplikasi';

        return view('base.role.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|min:3',
        ]);
        $role_id = $this->last_role_id();
        if ($role_id) {
            Role::create([
                'role_id' => $role_id,
                'role_name' => $request->role_name,
            ]);
        }

        // redirect
        return redirect()->route('rolePenggunaAdd')->with('success', 'Data berhasil disimpan');
    }

    public function last_role_id()
    {
        // get last data
        $last_data = Role::select('role_id')->orderBy('role_id', 'DESC')->first();
        $last_number = substr($last_data->role_id, 1, 6) + 1;
        $zero = '';
        for ($i = strlen($last_number); $i <= 3; $i++) {
            $zero .= '0';
        }
        $new_id = 'R' . $zero . $last_number;

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
    public function edit(string $role_id)
    {
        // detail data
        $detail = Role::where('role_id', $role_id)->first();
        if (empty($detail)) {
            return redirect()->route('rolePengguna')->with('error', 'Data tidak ditemukan');
        }
        $data['detail'] = $detail;
        $data['title'] = 'Management Role Aplikasi';
        $data['desc'] = 'Ubah Role Aplikasi';

        // dd($data);
        return view('base.role.edit', $data);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $role_id)
    {
        // detail data
        $detail = Role::where('role_id', $role_id)->first();
        if (empty($detail)) {
            return redirect()->route('rolePengguna')->with('error', 'Data tidak ditemukan');
        }
        Role::where('role_id', $request->role_id)->update([
            'role_name' => $request->role_name,
        ]);

        return redirect()->route('rolePenggunaEdit', [$role_id])->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $role_id)
    {
        // detail data
        $detail = Role::where('role_id', $role_id)->first();
        if (empty($detail)) {
            return redirect()->route('rolePengguna')->with('error', 'Data tidak ditemukan');
        }
        if ($detail->delete()) {
            return redirect()->route('rolePengguna')->with('success', 'Data berhasil dihapus');
        }
    }
}
