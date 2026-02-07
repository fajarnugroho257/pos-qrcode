<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class DataUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['title'] = "Management User Pengguna Aplikasi";
        $data['desc'] = "Data User Pengguna Aplikasi";
        // 
        $query = User::query();
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }
        $rs_user = $query->paginate(50)->withQueryString();
        $data['rs_user'] = $rs_user;
        $data['rs_role'] = Role::all();
        return view('base.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = "Management User Pengguna Aplikasi";
        $data['desc'] = "Tambah User Pengguna Aplikasi";
        $data['rs_role'] = Role::all();
        return view('base.user.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6',
            'name' => 'required',
            'role_id' => 'required',
            'user_st' => 'required'
        ]);
        User::create([
            'name' => $request->name,
            'role_id' => $request->role_id,
            'username' => $request->username,
            'user_st' => $request->user_st,
            'password' => bcrypt($request->password),
        ]);
        //redirect
        return redirect()->route('dataUserAdd')->with('success', 'Data berhasil disimpan');
    }

    // function last_user_id() {
    //     // get last user id
    //     $last_user = User::select('user_id')->orderBy('user_id', 'DESC')->first();
    //     $last_number = substr($last_user->user_id, 1, 6) + 1;
    //     $zero = '';
    //     for ($i=strlen($last_number); $i <=3; $i++) {
    //         $zero .= '0';
    //     }
    //     $new_id = 'U'.$zero.$last_number;
    //     //
    //     return $new_id;
    // }
    
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
    public function edit(string $id)
    {
        $detail = User::find($id);
        if (empty($detail)) {
            return redirect()->route('dataUser')->with('error', 'Data tidak ditemukan');
        }
        $data['title'] = "Management User Pengguna Aplikasi";
        $data['desc'] = "Ubah User Pengguna Aplikasi";
        $data['rs_role'] = Role::all();
        $data['detail'] = $detail;
        return view('base.user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => 'required|unique:users,username,' . $id . ',id',
            'password' => 'nullable|min:6',
            'name' => 'required',
            'role_id' => 'required',
            'user_st' => 'required'
        ]);
        $detail = User::find($id);
        if (empty($detail)) {
            return redirect()->route('dataUser')->with('error', 'Data tidak ditemukan');
        }
        $detail->name = $request->name;
        $detail->username = $request->username;
        $detail->role_id = $request->role_id;
        $detail->user_st = $request->user_st;
        if (!empty($request->password)) {
            $detail->password = bcrypt($request->password);
        }
        if ($detail->save()) {
            return redirect()->route('dataUserEdit', $id)->with('success', 'Data berhasil diupdate');
        } else {
            return redirect()->route('dataUser')->with('error', 'Gagal update date');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $detail = User::find($id);
        if ($detail->delete()) {
            return redirect()->route('dataUser')->with('success', 'Data berhasil dihapus');
        }
    }
}
