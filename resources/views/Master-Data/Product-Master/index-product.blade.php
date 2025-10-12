<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container p-4 mx-auto">
        <div class="overflow-x-auto shadow-lg sm:rounded-lg">
            {{-- Tombol Tambah Produk --}}
            <div class="mb-4">
                <a href="{{ route('product-create') }}">
                    <button class="px-6 py-4 text-white bg-green-500 border
                    border-green-500 rounded-lg shadow-md hover:bg-green-600
                    focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-150 ease-in-out">
                        Add product data
                    </button>
                </a>
            </div>

            {{-- Tabel Data Produk --}}
            <table class="min-w-full border border-collapse border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border border-gray-200">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border border-gray-200">Product Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border border-gray-200">Unit</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border border-gray-200">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border border-gray-200">Information</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border border-gray-200">Qty</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border border-gray-200">Producer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider border border-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    {{-- Loop data produk --}}
                    @foreach ($data as $item)
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="px-4 py-2 border border-gray-200 text-sm text-gray-900">{{-- Menggunakan ID loop atau data jika tersedia --}}</td>
                            <td class="px-4 py-2 border border-gray-200 text-sm text-gray-900">{{ $item->product_name }}</td>
                            <td class="px-4 py-2 border border-gray-200 text-sm text-gray-900">{{ $item->unit }}</td>
                            <td class="px-4 py-2 border border-gray-200 text-sm text-gray-900">{{ $item->type }}</td>
                            <td class="px-4 py-2 border border-gray-200 text-sm text-gray-900">{{ $item->information }}</td>
                            <td class="px-4 py-2 border border-gray-200 text-sm text-gray-900">{{ $item->qty }}</td>
                            <td class="px-4 py-2 border border-gray-200 text-sm text-gray-900">{{ $item->producer }}</td>
                            <td class="px-4 py-2 border border-gray-200 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('product-edit', $item->id) }}"
                                    class="text-blue-600 hover:text-blue-800 transition duration-150 ease-in-out mr-2">
                                    Edit
                                </a>
                                <button class="text-red-600 hover:text-red-800 transition duration-150 ease-in-out"
                                    onclick="confirmDelete('{{ $item->id }}', '{{ route('product-delete', $item->id) }}')">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Script JavaScript untuk Konfirmasi Hapus --}}
    <script>
        function confirmDelete(id, deleteUrl) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                // Jika user mengonfirmasi, buat form dan kirimkan permintaan DELETE
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = deleteUrl;

                // Tambahkan CSRF token
                let csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                // Pastikan token CSRF di-resolve di sisi Blade/PHP
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);

                // Tambahkan method spoofing untuk DELETE
                let methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);

                // Tambahkan form ke body dan submit
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</x-app-layout>