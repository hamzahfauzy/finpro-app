<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __(request()->routeIs('*.create') ? 'Tambah Data Baru' : 'Edit Data') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{route($page_setting['routePrefix']. (request()->routeIs('*.create') ? 'store' : 'update'), request()->routeIs('*.edit') ? $data?->id : null)}}" method="POST" class="p-6">
                    @csrf
                    @if(request()->routeIs('*.edit'))
                    @method('PUT')
                    @endif
                    <div class="grid grid-cols-1 gap-2">

                        @include('components.dynamic-form', [
                            'fields' => $model->fields,
                            'data' => $data ?? null
                        ])

                    </div>

                    <div class="flex items-center justify-end mt-6 border-t pt-4 gap-2">
                        <x-secondary-link-button href="{{route($page_setting['routePrefix'].'index')}}">Batal</x-secondary-link-button>
                        <x-primary-button>Simpan Data</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>