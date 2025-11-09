<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container p-4 mx-auto">
        {{-- TAMPILAN PESAN SESSION --}}
        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-50 p-4 text-green-700">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="mb-4 rounded-lg bg-red-50 p-4 text-red-700">
                {{ session('error') }}
            </div>
        @endif
        {{-- END TAMPILAN PESAN SESSION --}}

        <div class="overflow-x-auto shadow-lg sm:rounded-lg">
            
            {{-- [EDIT] Tombol Tambah Produk, Export Excel, & Export PDF --}}
            <div class="mb-4 flex items-center space-x-2">
                <a href="{{ route('product-create') }}">
                    <button class="px-6 py-4 text-white bg-green-500 border
                    border-green-500 rounded-lg shadow-md hover:bg-green-600
                    focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-150 ease-in-out">
                        Add product data
                    </button>
                </a>

                {{-- Tombol Export Excel (Sudah ada) --}}
                <a href="{{ route('product-export-excel') }}">
                    <button class="px-6 py-4 text-white bg-blue-500 border
                    border-blue-500 rounded-lg shadow-md hover:bg-blue-600
                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-150 ease-in-out">
                        Export to Excel
                    </button>
                </a>
                
                {{-- [ BARU ] Tombol Export PDF (Laporan Stok) --}}
                <a href="{{ route('reports.stock-mutation.pdf') }}">
                    <button class="px-6 py-4 text-white bg-red-500 border
                    border-red-500 rounded-lg shadow-md hover:bg-red-600
                    focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-150 ease-in-out">
                        Export Stock PDF
                    </button>
                </a>
                {{-- [ AKHIR BARU ] --}}
            </div>

            {{-- Form Pencarian Produk --}}
            <form method="GET" action="{{ route('product-index') }}" class="mb-4 flex items-center">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari produk..."
                    class="w-1/4 rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                >
                <button
                    type="submit"
                    class="ml-2 rounded-lg bg-green-500 px-4 py-2 text-white shadow-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500"
                >
                    Cari
                </button>

                @if (request('search'))
                    <a
                        href="{{ route('product-index') }}"
                        class="ml-2 rounded-lg bg-gray-500 px-4 py-2 text-white shadow-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500"
                    >
                        Reset
                    </a>
                @endif
            </form>
            {{-- End Form Pencarian Produk --}}

            {{-- Tabel Data Produk --}}
            <table class="min-w-full border border-collapse border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        {{-- Helper function untuk membuat link sorting --}}
                        @php
                        function sortableHeader($column, $displayName, $currentSortBy, $currentSortDir) {
                            $newSortDir = ($currentSortBy == $column && $currentSortDir == 'asc') ? 'desc' : 'asc';
                            $icon = '';
                            if ($currentSortBy == $column) {
                                $icon = ($currentSortDir == 'asc') ? ' &uarr;' : ' &darr;'; // Panah atas atau bawah
                            }
                            $url = route('product-index', [
                                'search' => request('search'), // Pertahankan search query
                                'sort_by' => $column,
                                'sort_dir' => $newSortDir,
                                'page' => request('page') // Pertahankan halaman saat ini jika perlu
                            ]);
                            return '<a href="' . $url . '">' . $displayName . $icon . '</a>';
                        }
                        @endphp

                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border border-gray-200">
                            {!! sortableHeader('id', 'ID', $sortBy, $sortDir) !!}
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border border-gray-200">
                            {!! sortableHeader('product_name', 'Product Name', $sortBy, $sortDir) !!}
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border border-gray-200">
                            {!! sortableHeader('unit', 'Unit', $sortBy, $sortDir) !!}
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border border-gray-200">
                            {!! sortableHeader('type', 'Type', $sortBy, $sortDir) !!}
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border border-gray-200">
                            {!! sortableHeader('information', 'Information', $sortBy, $sortDir) !!}
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border border-gray-200">
                            {!! sortableHeader('qty', 'Qty', $sortBy, $sortDir) !!}
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border border-gray-200">
                            {!! sortableHeader('producer', 'Producer', $sortBy, $sortDir) !!}
                        </th>
                        {{-- [BARU] Header Kolom Supplier --}}
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border border-gray-200">
                            Supplier
                        </th>
                        {{-- [AKHIR BARU] --}}
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border border-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($data as $item)
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="px-4 py-2 border border-gray-200 text-sm text-gray-900">{{ $item->id }}</td>
                            <td class="px-4 py-2 border border-gray-200 text-sm text-gray-900 hover:text-blue-500 hover:underline transition duration-150 ease-in-out">
                                <a href="{{ route('product-detail', $item->id) }}" class="font-medium text-inherit block w-full">
                                    {{ $item->product_name }}
                                </a>
                            </td>
                            <td class="px-4 py-2 border border-gray-200 text-sm text-gray-900">{{ $item->unit }}</td>
                            <td class="px-4 py-2 border border-gray-200 text-sm text-gray-900">{{ $item->type }}</td>
                            <td class="px-4 py-2 border border-gray-200 text-sm text-gray-900">{{ $item->information }}</td>
                            <td class="px-4 py-2 border border-gray-200 text-sm text-gray-900">{{ $item->qty }}</td>
                            <td class="px-4 py-2 border border-gray-200 text-sm text-gray-900">{{ $item->producer }}</td>
                            
                            {{-- [BARU] Tampilkan Nama Supplier --}}
                            <td class="px-4 py-2 border border-gray-200 text-sm text-gray-900">
                                {{ $item->supplier->name ?? '(N/A)' }}
                            </td>
                            {{-- [AKHIR BARU] --}}
                            
                            <td class="px-4 py-2 border border-gray-200 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('product-edit', $item->id) }}" class="text-blue-600 hover:text-blue-800 mr-2">Edit</a>
                                <button class="text-red-600 hover:text-red-800" onclick="confirmDelete('{{ route('product-delete', $item->id) }}')">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            {{-- [MODIFIKASI] Colspan diubah dari 9 menjadi 10 --}}
                            <td colspan="10" class="px-4 py-6 text-center text-lg text-red-600 font-semibold">
                                No products found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- End Tabel Data Produk --}}

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $data->appends(['search' => request('search'), 'sort_by' => $sortBy, 'sort_dir' => $sortDir])->links() }}
            </div>
            {{-- End Pagination --}}

        </div>
    </div>

    <script>
        function confirmDelete(deleteUrl) {
            if (confirm('Yakin lu?')) {
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = deleteUrl;

                let csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);

                let methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</x-app-layout>