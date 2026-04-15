<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{$page_setting['listTitle']}}
            </h2>
            @if($page_setting['createButton'])
            <a href="{{route($page_setting['routePrefix'].'create')}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                + Tambah Data
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> 
            @if(session('success'))
                <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 border border-green-300">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-800 border border-red-300">
                    {{ session('error') }}
                </div>
            @endif
            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200">
                <div class="flex flex-col">
                    <div class="overflow-x-auto">
                        <table class="table-auto divide-y divide-gray-200 table-fixed">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-start text-xs font-semibold text-gray-500 uppercase" style="width: 1%">
                                        No
                                    </th>
                                    @foreach ($model->listColumns as $key => $label)
                                    <th class="px-6 py-4 text-start text-xs font-semibold whitespace-nowrap text-gray-500 uppercase tracking-wider">
                                        {{ is_array($label) ? $label['label'] : $label }}
                                    </th>
                                    @endforeach
                                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($data as $index => $d)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $index+1 }}
                                    </td>
                                    @foreach ($model->listColumns as $key => $label)
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ \App\Libraries\Utility::parseValue($d, $key, $label) }}
                                    </td>
                                    @endforeach
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @foreach ($page_setting['additionalActions'] as $action)
                                        <a href="{{\App\Libraries\Utility::parseLinkAction($action['url'], $d)}}" class="text-indigo-600 hover:text-indigo-900 mr-4">{{$action['label']}}</a>
                                        @endforeach
                                        <a href="{{route($page_setting['routePrefix'].'edit', $d->id)}}" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                                        <button class="text-red-600 hover:text-red-900" onclick="if(confirm('Apakah anda yakin akan menghapus data ini ?')){ formDelete{{$d->id}}.submit() }">Hapus</button>
                                        <form name="formDelete{{$d->id}}" action="{{route($page_setting['routePrefix'].'destroy', $d->id)}}" method="post">
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{count($model->listColumns)+2}}" class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 text-center"><i>Tidak ada data</i></div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>