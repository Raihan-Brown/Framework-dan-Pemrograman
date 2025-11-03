<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Rekap Mutasi Stock</title>
    <style>
        body { 
            font-family: 'Helvetica', sans-serif; 
            font-size: 10px;
        }
        .header-text { 
            text-align: center; 
            margin-bottom: 20px; 
            line-height: 1.3;
        }
        .company { 
            font-size: 16px; 
            font-weight: bold; 
        }
        .report-title { 
            font-size: 14px; 
            font-weight: bold; 
        }
        .period { 
            font-size: 11px; 
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse;
        }
        th, td { 
            border: 1px solid #000; 
            padding: 4px; 
            text-align: left;
            vertical-align: top;
        }
        th { 
            background-color: #f0f0f0; 
            font-weight: bold;
            text-align: center;
        }
        .text-right { 
            text-align: right; 
        }
        
        .signature-table {
            margin-top: 40px;
            border: none;
        }
        .signature-table td {
            border: none;
            text-align: center;
            width: 33.33%;
            padding-top: 50px;
        }
    </style>
</head>
<body>

    {{-- Bagian Header Judul --}}
    <div class="header-text">
        <div class="company">Rekap tungtungsahur Company</div>
        <div class="report-title">Rekap Mutasi Stock Bulanan</div>
        {{-- Variabel $startDate dan $endDate ini datang dari Controller --}}
        <div class="period">Periode: {{ $startDate }} s/d {{ $endDate }}</div>
    </div>

    {{-- Bagian Tabel Utama --}}
    <table>
        <thead>
            <tr>
                <th rowspan="2">Item</th>
                <th rowspan="2">Kode Item</th>
                <th rowspan="2">Nama Item</th>
                <th rowspan="2">Stock Awal</th>
                <th colspan="5">Barang Masuk</th>
                <th colspan="5">Barang Keluar</th>
                <th rowspan="2">Penyesuaian Stock</th>
                <th rowspan="2">Stock Akhir</th>
                <th rowspan="2">Selisih</th>
            </tr>
            <tr>
                <th>Terima</th>
                <th>Beli</th>
                <th>Retur Jual</th>
                <th>Mutasi Masuk</th>
                <th>Total</th>
                <th>Kirim</th>
                <th>Sales</th>
                <th>Retur Beli</th>
                <th>Mutasi Keluar</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            {{-- 
              [UBAH] Loop-nya pakai @forelse ($products ...)
            --}}
            @forelse ($products as $item)
                @php
                    $satuan = $item->unit; // Ambil satuan dari database
                @endphp
                <tr>
                    {{-- Data dari Database --}}
                    <td>{{ $item->type }}</td>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->product_name }}</td>
                    
                    {{-- 
                      Data ini TIDAK ADA di database 'products'. 
                      Jadi kita akalin isinya '0'.
                    --}}
                    <td class="text-right">0 {{ $satuan }}</td>
                    <td class="text-right">0 {{ $satuan }}</td>
                    <td class="text-right">0 {{ $satuan }}</td>
                    <td class="text-right">0 {{ $satuan }}</td>
                    <td class="text-right">0 {{ $satuan }}</td>
                    <td class="text-right">0 {{ $satuan }}</td>
                    <td class="text-right">0 {{ $satuan }}</td>
                    <td class="text-right">0 {{ $satuan }}</td>
                    <td class="text-right">0 {{ $satuan }}</td>
                    <td class="text-right">0 {{ $satuan }}</td>
                    <td class="text-right">0 {{ $satuan }}</td>
                    <td class="text-right">0 {{ $satuan }}</td>
                    
                    {{-- Data Stok Akhir (qty) dari Database --}}
                    <td class="text-right">{{ $item->qty }} {{ $satuan }}</td>
                    
                    {{-- Data 'Selisih' kita akalin juga --}}
                    <td class="text-right">0 {{ $satuan }}</td>
                </tr>
            @empty
                {{-- Jika data $products kosong --}}
                <tr>
                    <td colspan="16" style="text-align: center;">Tidak ada data produk di database.</td>
                </tr>
            
            {{-- 
              [FIX] Penutupnya HARUS @endforelse, BUKAN @endforeach
            --}}
            @endforelse
        </tbody>
    </table>

    {{-- Keterangan di Bawah Tabel --}}
    <p style="font-size: 9px; margin-top: 15px;">
        *) Termasuk di dalamnya adalah transaksi stock masuk, stock keluar dan set saldo awal stock
    </p>

    {{-- Bagian Tanda Tangan --}}
    <table class="signature-table">
        <tr>
            <td>Dilaksanakan Oleh,</td>
            <td>Diketahui Oleh,</td>
            <td></td>
        </tr>
        <tr>
            <td>(Logistik)</td>
            <td>(Kepala Depo)</td>
            <td>(Fin & ACC)</td>
        </tr>
    </table>

</body>
</html>