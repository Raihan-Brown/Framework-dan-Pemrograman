<table>
    <thead>
        {{-- Baris Judul Utama --}}
        <tr>
            {{-- Colspan="8" karena tabel produkmu punya 8 kolom (ID s/d Aksi) --}}
            <td colspan="8" style="font-weight: bold; font-size: 16px; text-align: center;">
                PT. Jurnal Karya
            </td>
        </tr>

        {{-- Baris Subjudul --}}
        <tr>
            <td colspan="8" style="font-weight: bold; text-align: center;">
                Laporan Penjualan Sederhana
            </td>
        </tr>
        
        {{-- Baris Periode --}}
        <tr>
            <td colspan="8" style="text-align: center;">
                Periode Januari 2022
            </td>
        </tr>

        {{-- Baris Kosong untuk Spasi --}}
        <tr>
            <td colspan="8"></td>
        </tr>

        {{-- Baris Header Tabel (sesuai index-product.blade.php) --}}
        <tr style="background-color: #f0f0f0;">
            <th style="font-weight: bold;">ID</th>
            <th style="font-weight: bold;">Product Name</th>
            <th style="font-weight: bold;">Unit</th>
            <th style="font-weight: bold;">Type</th>
            <th style="font-weight: bold;">Information</th>
            <th style="font-weight: bold;">Qty</th>
            <th style="font-weight: bold;">Producer</th>
            <th style="font-weight: bold;">(Aksi tidak diekspor)</th>
        </tr>
    </thead>
    
    {{-- Baris Data --}}
    <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->unit }}</td>
                <td>{{ $product->type }}</td>
                <td>{{ $product->information }}</td>
                <td>{{ $product->qty }}</td>
                <td>{{ $product->producer }}</td>
                <td></td> {{-- Kolom aksi dikosongkan --}}
            </tr>
        @endforeach
    </tbody>
</table>
