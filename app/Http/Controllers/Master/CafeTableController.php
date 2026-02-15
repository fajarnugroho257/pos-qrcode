<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\CafeTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Milon\Barcode\Facades\DNS2DFacade as DNS2D;


class CafeTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $restaurant = auth()->user()->activeRestaurant();
        $cafeTables = CafeTable::where('restaurant_id', $restaurant->id)
                    ->when($request->search, function ($q) use ($request) {
                        $q->where(DB::raw('CONCAT(table_number, IFNULL(location, "") )'), 'like', '%' . $request->search . '%');
                    })
                    ->orderBy(DB::raw('CAST(table_number AS UNSIGNED)'))
                    ->paginate(20)->withQueryString();;
        return view('base.cafe_tables.index', [
            'title' => 'Data Meja',
            'desc' => 'Daftar Data Meja restoran',
            'cafeTables' => $cafeTables,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('base.cafe_tables.add', [
            'title' => 'Tambah Data Meja',
            'desc' => 'Tambah Data Meja restoran',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'table_number' => 'required|string|max:10',
            'capacity' => 'required|numeric',
            'location' => 'nullable|string',
            'is_active' => 'required|numeric',
        ]);
        // restoran
        $restaurant = auth()->user()->activeRestaurant();
        $restaurantId = $restaurant->id;
        // cek data
        $status = CafeTable::where('table_number', $request->table_number)
                    ->where('restaurant_id', $restaurantId)->count();
        if ($status >= 1) {
            return redirect()->route('cafeTablesCreate')->with('error', "Nomor meja sudah tersedia..")->withInput();
        }
        $validated['restaurant_id'] = $restaurantId;
        // create
        $table = CafeTable::create($validated);
        if($table){
            // generate qrcode
            $qr_image = $this->generateQRWithLogo($restaurantId, $table->id, $request->table_number);
            $table->update(['qr_image' => $qr_image]);
            // return
            return redirect()->route('cafeTablesCreate')->with('success', "Data meja berhasil disimpan");
        } else {
            return redirect()->route('cafeTablesCreate')->with('error', "Nomor meja sudah tersedia..")->withInput();
        }
    }

    public function generateQRWithLogo($id, $tabkleId, $tableNumber)
    {
        $text = url("order?restaurant=" . $id . "&table-id=" . $tabkleId);
        // 1. Generate QR Code (Base64) - Gunakan ukuran agak besar (misal: 15, 15)
        $image64 = DNS2D::getBarcodePNG($text, 'QRCODE', 15, 15);
        $qrResource = imagecreatefromstring(base64_decode($image64));

        // 2. Ambil file logo dari folder public
        $logoPath = public_path('images/logo.png'); // Ganti sesuai path logo Anda
        $logoResource = imagecreatefromstring(file_get_contents($logoPath));

        // 3. Dapatkan dimensi (lebar & tinggi)
        $qrWidth = imagesx($qrResource);
        $qrHeight = imagesy($qrResource);
        $logoWidth = imagesx($logoResource);
        $logoHeight = imagesy($logoResource);

        // 4. Hitung ukuran logo yang akan ditempel (misal: 20% dari ukuran QR)
        $newLogoWidth = $qrWidth / 5;
        $newLogoHeight = $logoHeight * ($newLogoWidth / $logoWidth);

        // 5. Hitung posisi tengah
        $targetX = ($qrWidth - $newLogoWidth) / 2;
        $targetY = ($qrHeight - $newLogoHeight) / 2;

        // 6. Tempelkan logo ke atas QR Code
        imagecopyresampled(
            $qrResource, $logoResource, 
            $targetX, $targetY, 0, 0, 
            $newLogoWidth, $newLogoHeight, $logoWidth, $logoHeight
        );

        // // 7. Simpan hasilnya ke folder Public Storage
        // $fileName = 'qr-table-' . $tableNumber . '.png';
        // $savePath = storage_path('app/public/qrcodes/'. $id.'/' . $fileName);
        
        // // Pastikan folder ada
        // if (!file_exists(storage_path('app/public/qrcodes/' . $id ))) {
        //     mkdir(storage_path('app/public/qrcodes/' . $id), 0755, true);
        // }

        // // Storage::disk('public')->put('1/qr-table-2.png', $image);

        // imagepng($qrResource, $savePath);

        // // 8. Bersihkan memory
        // imagedestroy($qrResource);
        // imagedestroy($logoResource);

        // return $id.'/' . $fileName;

        // 7. Simpan menggunakan Output Buffering agar bisa pakai Storage Laravel
        $fileName = 'qr-table-' . $tableNumber . '.png';
        $relativepath = 'qrcodes/' . $id . '/' . $fileName;

        // Kita tangkap output gambar ke variable
        ob_start();
        imagepng($qrResource);
        $imageBinary = ob_get_contents();
        ob_end_clean();

        // Gunakan Storage::disk('public') agar otomatis dibuatkan folder & terdeteksi VSCode
        Storage::disk('public')->put($relativepath, $imageBinary);

        // 8. Bersihkan memory
        imagedestroy($qrResource);
        imagedestroy($logoResource);

        // Return path yang benar untuk diakses asset()
        return $relativepath;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // restoran
        $restaurant = auth()->user()->activeRestaurant();
        $restaurantId = $restaurant->id;
        $detail = CafeTable::where(['id' => $id, 'restaurant_id' => $restaurantId])->first();
        if (empty($detail)) {
            return redirect()->route('cafeTables')->with('error', "Data meja tidak ditemukan..!");
        }
        // 
        return view('base.cafe_tables.show', [
            'title' => 'Detail Data Meja',
            'desc' => 'Detail Data Meja restoran',
            'detail' => $detail,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $restaurant = auth()->user()->activeRestaurant();
        $restaurantId = $restaurant->id;
        $detail = CafeTable::where(['id' => $id, 'restaurant_id' => $restaurantId])->first();
        if (empty($detail)) {
            return redirect()->route('cafeTables')->with('error', "Data meja tidak ditemukan..!");
        }
        return view('base.cafe_tables.edit', [
            'title' => 'Ubah Data Meja',
            'desc' => 'Ubah Data Meja restoran',
            'detail' => $detail,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'table_number' => 'required|string|max:10',
            'capacity' => 'required|numeric',
            'location' => 'nullable|string',
            'is_active' => 'required|numeric',
        ]);
        // 
        $restaurant = auth()->user()->activeRestaurant();
        $restaurantId = $restaurant->id;
        $detail = CafeTable::where(['id' => $id, 'restaurant_id' => $restaurantId])->first();
        // jika beda
        if ($detail->table_number != $request->table_number) {
            // cek DB
            $existData = CafeTable::where(['restaurant_id' => $restaurantId, 'table_number' => $request->table_number ])->count();
            if ($existData >= 1) {
                return redirect()->route('cafeTablesEdit', $id)->with('error', "Nomor meja sudah ada.")->withInput();
            }
        }
        if($detail->update($validated)){
            return redirect()->route('cafeTablesEdit', $id)->with('success', "Data meja berhasil diubah");
        } else {
            return redirect()->route('cafeTablesEdit', $id)->with('error', "Data meja gagal diubah");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $restaurant = auth()->user()->activeRestaurant();
        $restaurantId = $restaurant->id;
        $detail = CafeTable::where(['id' => $id, 'restaurant_id' => $restaurantId])->first();
        
        if (empty($detail)) {
            return redirect()->route('cafeTables')->with('error', "Data meja tidak ditemukan..!");
        }

        if ($detail->qr_image && Storage::disk('public')->exists($detail->qr_image)) {
            Storage::disk('public')->delete($detail->qr_image);
        }
        $detail->delete();
        return redirect()->route('cafeTables')->with('success', 'Meja berhasil dihapus');
    }

    public function download(string $id)
    {
        $restaurant = auth()->user()->activeRestaurant();
        $restaurantId = $restaurant->id;
        $detail = CafeTable::where(['id' => $id, 'restaurant_id' => $restaurantId])->first();
        
        if (empty($detail)) {
            return redirect()->route('cafeTables')->with('error', "Data meja tidak ditemukan..!");
        }
        // dd($detail);
        if (Storage::disk('public')->exists($detail->qr_image)) {
            $replace = "qrcodes/". $restaurantId ."/";
            return Storage::disk('public')->download($detail->qr_image, str_replace($replace, '', $detail->qr_image));
        }

        return redirect()->back()->with('error', 'File tidak ditemukan.');
        
    }

}
