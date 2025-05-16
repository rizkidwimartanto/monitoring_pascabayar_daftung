<?php

namespace App\Http\Controllers;

use App\Models\RekapPascaDaftungModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RekapPascaDaftungController extends Controller
{

    public function index()
    {
        $tanggalSekarang = Carbon::now()->toDateString();

        $targetsRaw = DB::table('rekap_pascabayar_daftung')
            ->whereDate('created_at', $tanggalSekarang)
            ->get();

        $targets = [];
        foreach ($targetsRaw as $target) {
            $targets[$target->unit_ulp_pascabayar] = [
                'bulanan' => $target->target_bulanan,
                'mingguan' => $target->target_mingguan,
                'harian' => $target->target_harian,
            ];
        }

        return view('home', compact('targets'));
    }



    public function getRekapData($unit)
    {
        $today = Carbon::today()->toDateString();

        $data = DB::table('rekap_pascabayar_daftung')
            ->where('unit_ulp_pascabayar', $unit)
            ->whereDate('created_at', $today)
            ->first();

        return response()->json($data);
    }

    public function administrator(Request $request)
    {
        $unitList = ['ULP Demak', 'ULP Tegowanu', 'ULP Purwodadi', 'ULP Wirosari'];

        if (($request->start_date) && ($request->end_date)) {
            $data = DB::table('rekap_pascabayar_daftung')->select(
                'unit_ulp_pascabayar',
                DB::raw('SUM(realisasi) as total_realisasi'),
                DB::raw('MAX(target_bulanan) as target_bulanan'),
                DB::raw('MAX(target_mingguan) as target_mingguan'),
                DB::raw('MAX(target_harian) as target_harian'),
            )->whereIn('unit_ulp_pascabayar', $unitList)
                ->whereBetween(DB::raw('DATE(created_at)'), [$request->start_date, $request->end_date])
                ->groupBy('unit_ulp_pascabayar')
                ->get();
            $useGroup = true; // penanda untuk view
        } else{
            $data = DB::table('rekap_pascabayar_daftung')->get();
            $useGroup = false;
        }

        return view('up3', [
            'data' => $data,
            'useGroup' => $useGroup
        ]);
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'unit_ulp_pascabayar' => 'required|string|max:255',
            'target_bulanan' => 'nullable|string|max:255',
            'target_mingguan' => 'nullable|string|max:255',
            'target_harian' => 'nullable|string|max:255',
            'realisasi' => 'nullable|string|max:255',
            // 'persen_pencapaian' => 'nullable|string|max:255',
            // 'unit_ulp_daftung' => 'nullable|string|max:255',
            'daftung_pagi' => 'nullable|string|max:255',
            'cetak_pk_pagi' => 'nullable|string|max:255',
            'cetak_pk_siang' => 'nullable|string|max:255',
            'jumlah_peremajaan' => 'nullable|string|max:255',
        ]);

        // Create a new record
        RekapPascaDaftungModel::create($request->all());

        return redirect()->route('rekap-pascadaftung.administrator')->with('success', 'Data berhasil ditambahkan.');
    }

    public function show($id)
    {
        // Show a specific record
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'target_bulanan' => 'nullable|string|max:255',
            'target_mingguan' => 'nullable|string|max:255',
            'target_harian' => 'nullable|string|max:255',
            'realisasi' => 'nullable|string|max:255',
        ]);

        $monitoring = RekapPascaDaftungModel::findOrFail($id);
        $monitoring->target_bulanan = $request->target_bulanan;
        $monitoring->target_mingguan = $request->target_mingguan;
        $monitoring->target_harian = $request->target_harian;
        $monitoring->realisasi = $request->realisasi;
        $monitoring->save();

        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }
    public function update(Request $request)
    {
        $request->validate([
            'unit_ulp_pascabayar' => 'nullable|required|string|max:255',
            'tanggal_realisasi' => 'nullable|string|max:255',
            'realisasi' => 'nullable|string|max:255',
            'persen_pencapaian' => 'nullable|string|max:255',
            'unit_ulp_daftung' => 'nullable|string|max:255',
            'daftung_pagi' => 'nullable|string|max:255',
            'cetak_pk_pagi' => 'nullable|string|max:255',
            'cetak_pk_siang' => 'nullable|string|max:255',
            'jumlah_peremajaan' => 'nullable|string|max:255',
            'updated_at' => 'nullable|string|max:255',
        ]);

        $unit = $request->unit_ulp_pascabayar;
        $today = Carbon::today()->toDateString();

        // Ambil data berdasarkan unit dan tanggal hari ini
        $rekap = \App\Models\RekapPascaDaftungModel::where('unit_ulp_pascabayar', $unit)
            ->whereDate('created_at', $today)
            ->first();

        if (!$rekap) {
            return back()->with('error', 'Data tidak ditemukan untuk unit dan tanggal hari ini.');
        }

        // Update data
        $rekap->update([
            'tanggal_realisasi' => $request->tanggal_realisasi,
            'realisasi' => $request->realisasi,
            'persen_pencapaian' => $request->persen_pencapaian,
            'unit_ulp_daftung' => $request->unit_ulp_daftung,
            'daftung_pagi' => $request->daftung_pagi,
            'cetak_pk_pagi' => $request->cetak_pk_pagi,
            'cetak_pk_siang' => $request->cetak_pk_siang,
            'jumlah_peremajaan' => $request->jumlah_peremajaan,
            'updated_at' => $request->updated_at,
        ]);

        return redirect()->route('rekap-pascadaftung.index')->with('success', 'Data berhasil diperbarui.');
    }


    public function destroy($id)
    {
        // Delete the record
    }
    public function getData()
    {
        // Fetch data from the database
        $data = RekapPascaDaftungModel::all();
        return response()->json($data);
    }
    public function getDataById($id)
    {
        // Fetch data by ID
        $data = RekapPascaDaftungModel::find($id);
        return response()->json($data);
    }
    public function getDataByUnit($unit)
    {
        // Fetch data by unit
        $data = RekapPascaDaftungModel::where('unit_ulp', $unit)->get();
        return response()->json($data);
    }
    public function getDataByDateRange($startDate, $endDate)
    {
        // Fetch data by date range
        $data = RekapPascaDaftungModel::whereBetween('created_at', [$startDate, $endDate])->get();
        return response()->json($data);
    }
    public function getDataByTarget($target)
    {
        // Fetch data by target
        $data = RekapPascaDaftungModel::where('target_harian', $target)->get();
        return response()->json($data);
    }
    public function getDataByRealisasi($realisasi)
    {
        // Fetch data by realisasi
        $data = RekapPascaDaftungModel::where('realisasi', $realisasi)->get();
        return response()->json($data);
    }
    public function getDataByPersenPencapaian($persen)
    {
        // Fetch data by persen pencapaian
        $data = RekapPascaDaftungModel::where('persen_pencapaian', $persen)->get();
        return response()->json($data);
    }
    public function getDataByTargerCarryOver($targer)
    {
        // Fetch data by targer carry over
        $data = RekapPascaDaftungModel::where('targer_bulanan', $targer)->get();
        return response()->json($data);
    }
    public function getDataByUnitAndDate($unit, $startDate, $endDate)
    {
        // Fetch data by unit and date range
        $data = RekapPascaDaftungModel::where('unit_ulp', $unit)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
        return response()->json($data);
    }
    public function getDataByUnitAndTarget($unit, $target)
    {
        // Fetch data by unit and target
        $data = RekapPascaDaftungModel::where('unit_ulp', $unit)
            ->where('target_harian', $target)
            ->get();
        return response()->json($data);
    }
}
