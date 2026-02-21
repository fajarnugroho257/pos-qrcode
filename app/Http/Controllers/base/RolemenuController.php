<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Role;
use App\Models\Role_menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class RolemenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['title'] = 'Management Role Menu Aplikasi';
        $data['desc'] = 'Data Role Menu Aplikasi';
        //
        $query = Role::query();
        if ($request->filled('search')) {
            $query->where('role_name', 'LIKE', "%{$request->search}%");
        }
        $data['rs_role'] = $query->paginate(10)->withQueryString();

        return view('base.role_menu.index', $data);
    }

    public function listDataRoleMenu($role_id)
    {
        $detail = Role::where('role_id', $role_id)->first();
        if (empty($detail)) {
            return redirect()->route('roleMenu')->with('error', 'Data tidak ditemukan');
        }
        $data['title'] = 'Management Role Menu Aplikasi';
        $data['desc'] = 'Data Role Menu Aplikasi';
        $data['detail'] = $detail;
        // all menu
        $rs_menu = Menu::leftJoin('app_role_menu as b', function ($join) use ($role_id) {
            $join->on('app_menu.menu_id', '=', 'b.menu_id')->where('b.role_id', $role_id);
        })
            ->select('app_menu.menu_id', 'app_menu.menu_name', 'b.role_menu_id')
            ->get();
        $data['rs_menu'] = $rs_menu;

        return view('base.role_menu.list', $data);
    }

    public function tambahRoleMenu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required',
            'status' => 'required',
            'menu_id' => 'required',
        ]);

        // check if validation fails
        if ($validator->fails()) {
            // return response()->json($validator->errors(), 422);
            return Response::json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),

            ], 400);
        }
        // check
        $detail = Role::where('role_id', $request->role_id)->first();
        if (empty($detail)) {
            return redirect()->route('roleMenu')->with('error', 'Data tidak ditemukan');
        }
        // ubah role menu
        $status = $request->status;
        if ($status == 'tambah') {
            Role_menu::create([
                'role_menu_id' => $request->role_id . $request->menu_id,
                'menu_id' => $request->menu_id,
                'role_id' => $request->role_id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Disimpan!',
            ]);
        } else {
            $detail = Role_menu::where('menu_id', $request->menu_id)->where('role_id', $request->role_id)->first();
            if (empty($detail)) {
                return redirect()->route('roleMenu')->with('error', 'Data tidak ditemukan');
            }
            $detail->delete();

            //
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil dihapus!',
            ]);
        }

    }
}
