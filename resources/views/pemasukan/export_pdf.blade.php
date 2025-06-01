<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 6px 20px 5px 20px;
            line-height: 15px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        td, th {
            padding: 4px 3px;
            border: 1px solid #000;
        }
        
        th {
            text-align: center;
            background-color: #f2f2f2;
        }
        
        .d-block {
            display: block;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .header {
            margin-bottom: 20px;
        }
        
        .logo {
            width: 80px;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="header">
        <table>
            <tr>
                <td width="15%" class="text-center">
                    <img src="{{ asset('polinema-bw.png') }}" class="logo">
                </td>
                <td width="85%">
                    <span class="text-center d-block" style="font-size:11pt;font-weight:bold;margin-bottom:5px;">
                        LAPORAN PEMASUKAN MILIK HANIFAH CANTIK
                    </span>
                    <span class="text-center d-block" style="font-size:13pt;font-weight:bold;margin-bottom:5px;">
                        PALEMBANG
                    </span>
                    <span class="text-center d-block" style="font-size:10pt;">
                        Jl. Soekarno-Hatta No. 9 Malang 65141
                    </span>
                    <span class="text-center d-block" style="font-size:10pt;">
                        Telepon (0341) 404424 Pes. 101-105, 0341-404420, Fax. (0341) 404420
                    </span>
                    <span class="text-center d-block" style="font-size:10pt;">
                        Laman: www.polinema.ac.id
                    </span>
                </td>
            </tr>
        </table>
    </div>

    <h3 class="text-center">LAPORAN PEMASUKAN</h3>
    
    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="25%">Nama</th>
                <th width="20%" class="text-right">Jumlah</th>
                <th width="25%">Asal</th>
                <th width="25%">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pemasukan as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->nama }}</td>
                <td class="text-right">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                <td>{{ $item->asal }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>