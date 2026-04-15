<x-app-layout>
    @php
    $bulan = [
        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
        5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
        9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
    ];
    @endphp
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan Kas Induk
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> 
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Kas Masuk
            </h2>
            <br>
            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Rekening</th>
                                @foreach($bulan as $b)
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ $b }}</th>
                                @endforeach
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($data as $row)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            <b>{{$row['nama']}}</b>
                                            <br>
                                            {{ $row['rekening'] }}
                                        </div>
                                    </td>
                                    @foreach($bulan as $i => $b)
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <span class="font-mono font-bold">
                                            Rp {{ number_format($row['masuk'][$i], 0, ',', '.') }}
                                        </span>
                                    </td>
                                    @endforeach
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <span class="font-mono font-bold">
                                            Rp {{ number_format($row['total_masuk'], 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="13" class="px-6 py-10 text-center text-gray-500 italic">
                                        Data transaksi tidak ditemukan untuk periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        Total
                                    </div>
                                </td>
                                @foreach($bulan as $i => $b)
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <span class="font-mono font-bold">
                                        Rp {{ number_format($grand['masuk'][$i], 0, ',', '.') }}
                                    </span>
                                </td>
                                @endforeach
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <span class="font-mono font-bold">
                                        Rp {{ number_format($grand['total_masuk'], 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <br><br><br>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Kas Keluar
            </h2>
            <br>
            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Rekening</th>
                                @foreach($bulan as $b)
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ $b }}</th>
                                @endforeach
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($data as $row)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            <b>{{$row['nama']}}</b>
                                            <br>
                                            {{ $row['rekening'] }}
                                        </div>
                                    </td>
                                    @foreach($bulan as $i => $b)
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <span class="font-mono font-bold">
                                            Rp {{ number_format($row['keluar'][$i], 0, ',', '.') }}
                                        </span>
                                    </td>
                                    @endforeach
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <span class="font-mono font-bold">
                                            Rp {{ number_format($row['total_keluar'], 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="13" class="px-6 py-10 text-center text-gray-500 italic">
                                        Data transaksi tidak ditemukan untuk periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        Total
                                    </div>
                                </td>
                                @foreach($bulan as $i => $b)
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <span class="font-mono font-bold">
                                        Rp {{ number_format($grand['keluar'][$i], 0, ',', '.') }}
                                    </span>
                                </td>
                                @endforeach
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <span class="font-mono font-bold">
                                        Rp {{ number_format($grand['total_keluar'], 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <br><br><br>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Saldo
            </h2>
            <br>
            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Rekening</th>
                                @foreach($bulan as $b)
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ $b }}</th>
                                @endforeach
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($data as $row)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            <b>{{$row['nama']}}</b>
                                            <br>
                                            {{ $row['rekening'] }}
                                        </div>
                                    </td>
                                    @foreach($bulan as $i => $b)
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <span class="font-mono font-bold">
                                            Rp {{ number_format($row['saldo'][$i], 0, ',', '.') }}
                                        </span>
                                    </td>
                                    @endforeach
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <span class="font-mono font-bold">
                                            Rp {{ number_format($row['total_saldo'], 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="13" class="px-6 py-10 text-center text-gray-500 italic">
                                        Data transaksi tidak ditemukan untuk periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        Total
                                    </div>
                                </td>
                                @foreach($bulan as $i => $b)
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <span class="font-mono font-bold">
                                        Rp {{ number_format($grand['saldo'][$i], 0, ',', '.') }}
                                    </span>
                                </td>
                                @endforeach
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <span class="font-mono font-bold">
                                        Rp {{ number_format($grand['total_saldo'], 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>