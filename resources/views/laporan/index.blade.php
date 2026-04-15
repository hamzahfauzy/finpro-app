<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> 
            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Laporan Posisi Keuangan</h2>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mt-1">Periode: 2026</p>
                    </div>
                    <div class="text-right">
                        <span class="text-xs text-gray-400">Total Akun:</span>
                        <span class="block font-semibold text-gray-700">{{ $data->count() }} Rekening</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Rekening</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Saldo Akhir</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($data as $row)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            <b>{{$row->nama}}</b>
                                            <br>
                                            {{ $row->nama_rekening }} - {{ $row->nomor_rekening }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <span class="font-mono font-bold {{ $row->saldo < 0 ? 'text-red-600' : 'text-gray-800' }}">
                                            Rp {{ number_format($row->saldo, 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-10 text-center text-gray-500 italic">
                                        Data transaksi tidak ditemukan untuk periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($data->count() > 0)
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td class="px-6 py-4 text-sm font-bold text-gray-900 text-right uppercase">Total Kas Terkonsolidasi</td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="text-base font-bold text-indigo-600">
                                            Rp {{ number_format($data->sum('saldo'), 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>