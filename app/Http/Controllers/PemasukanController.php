<?php

namespace App\Http\Controllers;

use App\Models\PemasukanModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PDF as PdF; // Pastikan Anda sudah menginstal laravel-dompdf atau laravel-snappy


class PemasukanController extends Controller
{
    /**
     * Menampilkan daftar pemasukan
     */
    public function index()
{
    $breadcrumb = (object) [
        'title' => 'Daftar Pemasukan',
        'list' => ['Home', 'Pemasukan']
    ];

    $page = (object) [
        'title' => 'Daftar pemasukan dalam sistem'
    ];
    $activeMenu = 'pemasukan'; 

    $asalList = PemasukanModel::select('asal')->distinct()->pluck('asal');
    $pemasukanList = PemasukanModel::all();
    return view('pemasukan.index', [
        'breadcrumb' => $breadcrumb,
        'page' => $page,
        'activeMenu' => $activeMenu,
        'asalList' => $asalList 
    ]);
}

    public function list(Request $request)
    {
        $pemasukan = PemasukanModel::select('id', 'nama', 'jumlah', 'asal', 'tanggal');
        if ($request->asal) {
            $pemasukan->where('asal', $request->asal);
        }
        return DataTables::of($pemasukan)
            ->addIndexColumn()
            ->addColumn('aksi', function ($pemasukan) {
                $btn  = '<a href="'. url('/pemasukan/' . $pemasukan->id) .'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<button onclick="modalAction(\''. url('/pemasukan/' . $pemasukan->id .'/edit_ajax') 
                .'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''. url('/pemasukan/' . $pemasukan->id .'/delete_ajax') 
                .'\')" class="btn btn-danger btn-sm">Hapus</button> ';
            
                return $btn;
            })
            
            ->rawColumns(['aksi'])
            ->make(true);
    }

    /**
     * Menampilkan form untuk menambah pemasukan
     */
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Pemasukan',
            'list' => ['Home', 'Pemasukan', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah pemasukan baru'
        ];

        $activeMenu = 'pemasukan';

        return view('pemasukan.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    /**
     * Menyimpan pemasukan baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah' => 'required|numeric',
            'asal' => 'required|string|max:255',
            'tanggal' => 'required|date'
        ]);

        // Menghitung saldo baru
        $totalSebelumnya = PemasukanModel::sum('jumlah');
        $saldoBaru = $totalSebelumnya + $request->jumlah;

        PemasukanModel::create([
            'nama' => $request->nama,
            'jumlah' => $request->jumlah,
            'asal' => $request->asal,
            'tanggal' => $request->tanggal,
        ]);

        return redirect('/pemasukan')->with('success', 'Data pemasukan berhasil disimpan');
    }

    /**
     * Menampilkan detail pemasukan
     */
    public function show(string $id)
    {
        $pemasukan = PemasukanModel::find($id);

        if (!$pemasukan) {
            return redirect('/pemasukan')->with('error', 'Data pemasukan tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Detail Pemasukan',
            'list' => ['Home', 'Pemasukan', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail pemasukan'
        ];

        $activeMenu = 'pemasukan';

        return view('pemasukan.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'pemasukan' => $pemasukan,
            'activeMenu' => $activeMenu
        ]);
    }

    /**
     * Menampilkan form untuk mengedit pemasukan
     */
    public function edit(string $id)
    {
        $pemasukan = PemasukanModel::find($id);

        if (!$pemasukan) {
            return redirect('/pemasukan')->with('error', 'Data pemasukan tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Edit Pemasukan',
            'list' => ['Home', 'Pemasukan', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Pemasukan'
        ];

        $activeMenu = 'pemasukan';

        return view('pemasukan.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'pemasukan' => $pemasukan,
            'activeMenu' => $activeMenu
        ]);
    }

    /**
     * Memperbarui data pemasukan
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah' => 'required|numeric',
            'asal' => 'required|string|max:255',
            'tanggal' => 'required|date'
        ]);

        $pemasukan = PemasukanModel::find($id);

        if (!$pemasukan) {
            return redirect('/pemasukan')->with('error', 'Data pemasukan tidak ditemukan');
        }

        $pemasukan->update([
            'nama' => $request->nama,
            'jumlah' => $request->jumlah,
            'asal' => $request->asal,
            'tanggal' => $request->tanggal
        ]);

        return redirect('/pemasukan')->with('success', 'Data pemasukan berhasil diperbarui');
    }

    /**
     * Menghapus data pemasukan
     */
    public function destroy(string $id)
    {
        $pemasukan = PemasukanModel::find($id);

        if (!$pemasukan) {
            return redirect('/pemasukan')->with('error', 'Data pemasukan tidak ditemukan');
        }

        $pemasukan->delete();

        return redirect('/pemasukan')->with('success', 'Data pemasukan berhasil dihapus');
    }

    // AJAX Create
    public function create_ajax()
    {
        return view('pemasukan.create_ajax');
    }

    // AJAX Store
    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama' => 'required|string|max:255',
                'jumlah' => 'required|numeric',
                'asal' => 'required|string|max:255',
                'tanggal' => 'required|date'
            ];
            \Log::info('Data akan disimpan:', [
                'nama' => $request->nama,
                'jumlah' => $request->jumlah,
                'asal' => $request->asal,
                'tanggal' => $request->tanggal,
            ]);
            
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
            PemasukanModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data pemasukan berhasil disimpan'
            ]);
        }
        return redirect('/');
        
    }
    // PemasukanController.php
    public function show_ajax($id)
    {
        $pemasukan = PemasukanModel::find($id);
        return view('pemasukan.detail_ajax', compact('pemasukan'));
    }

    // Menampilkan halaman form edit pemasukan dengan AJAX
    public function edit_ajax(string $id)
    {
        $pemasukan = PemasukanModel::find($id);

        if (!$pemasukan) {
            return view('pemasukan.edit_ajax', ['pemasukan' => null]);
        }

        return view('pemasukan.edit_ajax', ['pemasukan' => $pemasukan]);
    }

    // AJAX Update
    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama' => 'required|string|max:255',
                'jumlah' => 'required|numeric',
                'asal' => 'required|string|max:255',
                'tanggal' => 'required|date'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $pemasukan = PemasukanModel::find($id);
            if ($pemasukan) {
                $pemasukan->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data pemasukan berhasil diperbarui'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
    public function confirm_ajax(string $id)
        {
        
            $pemasukan = PemasukanModel::find($id);

            return view('pemasukan.confirm_ajax', ['pemasukan' => $pemasukan]);
        }

    // AJAX Delete
    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $pemasukan = PemasukanModel::find($id);
            if ($pemasukan) {
                $pemasukan->delete();
                return response()->json([
                    'status'  => true,
                    'message' => 'Data pemasukan berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
 public function import()
    {
        return view('pemasukan.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_pemasukan' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_pemasukan');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);

            $insert = [];
            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        $insert[] = [
                            'nama' => $value['A'],
                            'jumlah' => $value['B'],
                            'asal' => $value['C'],
                            'tanggal' => $value['D'],
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    PemasukanModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }

        return redirect('/');
    }
public function export_excel(){
        $pemasukan = pemasukanModel::select('nama', 'jumlah', 'asal', 'tanggal')
            ->orderBy('nama')
            ->get();
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama pemasukan');
        $sheet->setCellValue('C1', 'Jumlah');
        $sheet->setCellValue('D1', 'Asal');
        $sheet->setCellValue('E1', 'Tanggal');


        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
        $no= 1;
        $baris = 2;

        foreach ($pemasukan as $key => $value) {
            $sheet->setCellValue('A' .$baris, $no);
            $sheet->setCellValue('B' .$baris, $value->nama);
            $sheet->setCellValue('C' .$baris, $value->jumlah);
            $sheet->setCellValue('D' .$baris, $value->asal);
            $sheet->setCellValue('E' .$baris, $value->tanggal);
           
            $baris++;
            $no++;
        }
        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        $sheet->setTitle('Data pemasukan');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $fileName = 'Data pemasukan' . date('Y-m-d-H:i:s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Chache-Control: chace, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }
public function export_pdf()
    {
        $pemasukan = PemasukanModel::select('nama', 'jumlah', 'asal', 'tanggal')
            ->orderBy('nama')
            ->get();

        $pdf = PdF::loadView('pemasukan.export_pdf', ['pemasukan' => $pemasukan]);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data pemasukan' . date('Y-m-d-H:i:s') . '.pdf');
    }
}


