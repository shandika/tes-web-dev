<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use DataTables;
use DB;

class ProgramController extends Controller
{
    public function index()
    {
        $data = Program::get();
        if (request()->ajax()) {
            return datatables()->of($data)
                ->addColumn('aksi', function ($data) {
                    $button = " <button class='lihat btn  btn-danger' id='" . $data->id . "' >Lihat</button>";
                    $button .= " <button class='edit btn  btn-danger' id='" . $data->id . "' >Edit</button>";
                    $button .= " <button class='hapus btn  btn-danger' id='" . $data->id . "' >Hapus</button>";
                    return $button;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
        $sumber = DB::table('programs')
            ->select('sumber_dana')
            ->groupBy('sumber_dana')
            ->orderBy('sumber_dana', 'ASC')
            ->get();
        $keterangan = DB::table('programs')
            ->select('keterangan')
            ->groupBy('keterangan')
            ->orderBy('keterangan', 'ASC')
            ->get();
        return view('home', compact('sumber', 'keterangan'));
    }

    public function store(Request $request)
    {
        $data = new Program();
        $data->sumber_dana = $request->sumber_dana;
        $data->program = $request->program;
        $data->keterangan = $request->keterangan;
        $simpan = $data->save();
        if ($simpan) {
            return response()->json(['data' => $data]);
        } else {
            return response()->json(['data' => $data]);
        }
    }

    public function views(Request $request)
    {
        $id = $request->id;
        $data = Program::find($id);
        return response()->json(['data' => $data]);
    }

    public function edits(Request $request)
    {
        $id = $request->id;
        $data = Program::find($id);
        return response()->json(['data' => $data]);
    }

    public function updates(Request $request)
    {
        $id = $request->id;
        $datas = [
            'sumber_dana' => $request->sumber_dana,
            'program' => $request->program,
            'keterangan' => $request->keterangan
        ];
        $data = Program::find($id);
        $simpan = $data->update($datas);
        if ($simpan) {
            return response()->json(['text' => 'berhasil diubah'], 200);
        } else {
            return response()->json(['text' => 'Gagal diubah'], 422);
        }
    }

    public function hapus(Request $request)
    {
        $id = $request->id;
        $data = Program::find($id);
        $data->delete();
        return response()->json(['text' => 'berhasil dihapus'], 200);
    }

    public function cari(Request $request)
    {
        if(request()->ajax())
        {
        if(!empty($request->filter_sumber))
        {
        $data = DB::table('programs')
            ->select('id', 'sumber_dana', 'program', 'keterangan')
            ->where('sumber_dana', $request->filter_sumber)
            ->where('keterangan', $request->filter_keterangan)
            ->get();
        }
        else
        {
            $data = Program::get();
        }
            return datatables()->of($data)
            ->addColumn('aksi', function ($data) {
                $button = " <button class='lihat btn  btn-danger' id='" . $data->id . "' >Lihat</button>";
                $button .= " <button class='edit btn  btn-danger' id='" . $data->id . "' >Edit</button>";
                $button .= " <button class='hapus btn  btn-danger' id='" . $data->id . "' >Hapus</button>";
                return $button;
            })
            ->rawColumns(['aksi'])
            ->make(true);
        }
        $sumber = DB::table('programs')
            ->select('sumber_dana')
            ->groupBy('sumber_dana')
            ->orderBy('sumber_dana', 'ASC')
            ->get();
        $keterangan = DB::table('programs')
            ->select('keterangan')
            ->groupBy('keterangan')
            ->orderBy('keterangan', 'ASC')
            ->get();
        return view('home', compact('sumber', 'keterangan'));
    }
}
