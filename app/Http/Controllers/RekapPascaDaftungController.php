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
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();
    
        $targetsRaw = DB::table('rekap_pascabayar_daftung')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->get();
    
        $targets = [];
        foreach ($targetsRaw as $target) {
            $targets[$target->unit_ulp_pascabayar] = [
                'carry_over' => $target->target_carry_over,
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
        $query = DB::table('rekap_pascabayar_daftung');

        // Filter berdasarkan rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween(DB::raw('DATE(created_at)'), [
                $request->start_date,
                $request->end_date
            ]);
        }

        $data = [
            'data' => $query->get()
        ];

        return view('up3', $data);
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'unit_ulp_pascabayar' => 'required|string|max:255',
            'target_carry_over' => 'nullable|string|max:255',
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
            'target_carry_over' => 'nullable|string|max:255',
            'target_harian' => 'nullable|string|max:255',
            'realisasi' => 'nullable|string|max:255',
        ]);
    
        $monitoring = RekapPascaDaftungModel::findOrFail($id);
        $monitoring->target_carry_over = $request->target_carry_over;
        $monitoring->target_harian = $request->target_harian;
        $monitoring->realisasi = $request->realisasi;
        $monitoring->save();
    
        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }
    public function update(Request $request)
    {
        $request->validate([
            'unit_ulp_pascabayar' => 'nullable|required|string|max:255',
            'realisasi' => 'nullable|string|max:255',
            'persen_pencapaian' => 'nullable|string|max:255',
            'unit_ulp_daftung' => 'nullable|string|max:255',
            'daftung_pagi' => 'nullable|string|max:255',
            'cetak_pk_pagi' => 'nullable|string|max:255',
            'cetak_pk_siang' => 'nullable|string|max:255',
            'jumlah_peremajaan' => 'nullable|string|max:255',
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
            'realisasi' => $request->realisasi,
            'persen_pencapaian' => $request->persen_pencapaian,
            'unit_ulp_daftung' => $request->unit_ulp_daftung,
            'daftung_pagi' => $request->daftung_pagi,
            'cetak_pk_pagi' => $request->cetak_pk_pagi,
            'cetak_pk_siang' => $request->cetak_pk_siang,
            'jumlah_peremajaan' => $request->jumlah_peremajaan,
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
        $data = RekapPascaDaftungModel::where('targer_carry_over', $targer)->get();
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
