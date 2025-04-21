<?php

namespace App\Http\Controllers;

use App\Models\PengeluaranModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PengeluaranController extends Controller
{
    public function index()
{
    $breadcrumb = (object) [
        'title' => 'Daftar Pengeluaran',
        'list' => ['Home', 'Pengeluaran']
    ];

    $page = (object) [
        'title' => 'Daftar Pengeluaran dalam sistem'
    ];

    $activeMenu = 'pengeluaran';

    $kategoriList = PengeluaranModel::select('kategori')->distinct()->pluck('kategori');
    
    return view('pengeluaran.index', [
        'breadcrumb' => $breadcrumb,
        'page' => $page,
        'activeMenu' => $activeMenu,
        'kategoriList' => $kategoriList
    ]);
}

    public function list(Request $request)
    {
        $pengeluaran = PengeluaranModel::select('id', 'nama', 'jumlah', 'tujuan', 'tanggal', 'kategori');

        if ($request->tujuan) {
            $pengeluaran->where('tujuan', $request->tujuan);
        }

        return DataTables::of($pengeluaran)
            ->addIndexColumn()
            ->addColumn('aksi', function ($pengeluaran) {
                $btn  = '<a href="' . url('/pengeluaran/' . $pengeluaran->id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<button onclick="modalAction(\'' . url('/pengeluaran/' . $pengeluaran->id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/pengeluaran/' . $pengeluaran->id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';

                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Pengeluaran',
            'list' => ['Home', 'Pengeluaran', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah pengeluaran baru'
        ];

        $activeMenu = 'pengeluaran';

        return view('pengeluaran.create', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah' => 'required|numeric',
            'tujuan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'kategori' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        PengeluaranModel::create($request->all());

        return redirect('/pengeluaran')->with('success', 'Data pengeluaran berhasil disimpan');
    }

    public function show(string $id)
    {
        $pengeluaran = PengeluaranModel::find($id);

        if (!$pengeluaran) {
            return redirect('/pengeluaran')->with('error', 'Data pengeluaran tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Detail Pengeluaran',
            'list' => ['Home', 'Pengeluaran', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail pengeluaran'
        ];

        $activeMenu = 'pengeluaran';

        return view('pengeluaran.show', compact('breadcrumb', 'page', 'pengeluaran', 'activeMenu'));
    }

    public function edit(string $id)
    {
        $pengeluaran = PengeluaranModel::find($id);

        if (!$pengeluaran) {
            return redirect('/pengeluaran')->with('error', 'Data pengeluaran tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Edit Pengeluaran',
            'list' => ['Home', 'Pengeluaran', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit pengeluaran'
        ];

        $activeMenu = 'pengeluaran';

        return view('pengeluaran.edit', compact('breadcrumb', 'page', 'pengeluaran', 'activeMenu'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah' => 'required|numeric',
            'tujuan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'kategori' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        $pengeluaran = PengeluaranModel::find($id);

        if (!$pengeluaran) {
            return redirect('/pengeluaran')->with('error', 'Data pengeluaran tidak ditemukan');
        }

        $pengeluaran->update($request->all());

        return redirect('/pengeluaran')->with('success', 'Data pengeluaran berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $pengeluaran = PengeluaranModel::find($id);

        if (!$pengeluaran) {
            return redirect('/pengeluaran')->with('error', 'Data pengeluaran tidak ditemukan');
        }

        $pengeluaran->delete();

        return redirect('/pengeluaran')->with('success', 'Data pengeluaran berhasil dihapus');
    }

    public function create_ajax()
    {
        return view('pengeluaran.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama' => 'required|string|max:255',
                'jumlah' => 'required|numeric',
                'tujuan' => 'required|string|max:255',
                'tanggal' => 'required|date',
                'kategori' => 'nullable|string|max:255',
                'deskripsi' => 'nullable|string'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            PengeluaranModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data pengeluaran berhasil disimpan'
            ]);
        }

        return redirect('/');
    }

    public function show_ajax($id)
    {
        $pengeluaran = PengeluaranModel::find($id);
        return view('pengeluaran.detail_ajax', compact('pengeluaran'));
    }

    public function edit_ajax(string $id)
    {
        $pengeluaran = PengeluaranModel::find($id);

        return view('pengeluaran.edit_ajax', ['pengeluaran' => $pengeluaran]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama' => 'required|string|max:255',
                'jumlah' => 'required|numeric',
                'tujuan' => 'required|string|max:255',
                'tanggal' => 'required|date',
                'kategori' => 'nullable|string|max:255',
                'deskripsi' => 'nullable|string'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $pengeluaran = PengeluaranModel::find($id);
            if ($pengeluaran) {
                $pengeluaran->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data pengeluaran berhasil diperbarui'
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $pengeluaran = PengeluaranModel::find($id);

        return view('pengeluaran.confirm_ajax', compact('pengeluaran'));
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $pengeluaran = PengeluaranModel::find($id);
            if ($pengeluaran) {
                $pengeluaran->delete();
                return response()->json([
                    'status'  => true,
                    'message' => 'Data pengeluaran berhasil dihapus'
                ]);
            }

            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        return redirect('/');
    }
}
