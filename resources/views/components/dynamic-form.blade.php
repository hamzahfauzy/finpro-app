@foreach($fields as $key => $field)
    <div>
        <label class="block font-medium text-sm text-gray-700">
            {{ $field['label'] }}
        </label>

        @switch($field['type'])

            {{-- TEXT / NUMBER / DATE --}}
            @case('text')
            @case('number')
            @case('date')
                <input 
                    type="{{ $field['type'] }}"
                    name="{{ $key }}"
                    value="{{ old($key, $data?->$key) }}"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                >
            @break

            {{-- TEXTAREA --}}
            @case('textarea')
                <textarea 
                    name="{{ $key }}"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                >{{ old($key, $data?->$key) }}</textarea>
            @break

            {{-- SELECT --}}
            @case('select')
                <select 
                    name="{{ $key }}"
                    data-relation="{{ $field['relation'] ?? '' }}"
                    data-depends-on="{{ $field['depends_on'] ?? '' }}"
                    data-foreign-key="{{ $field['foreign_key'] ?? '' }}"
                    class="dynamic-select mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                >

                    <option value="">- Pilih -</option>

                    {{-- RELATION --}}
                    @if(isset($field['relation']))

                        @php
                            $isDependent = isset($field['depends_on']);
                        @endphp

                        {{-- 🔹 PARENT (tidak tergantung) --}}
                        @if(!$isDependent)
                            @php
                                $model = $field['relation'];
                                $items = $model::all();
                            @endphp

                            @foreach($items as $item)
                                <option 
                                    value="{{ $item->id }}"
                                    {{ old($key, $data?->$key) == $item->id ? 'selected' : '' }}
                                >
                                    {{ $item->{$field['display']} }}
                                </option>
                            @endforeach
                        @endif

                        {{-- 🔹 CHILD (dependent) --}}
                        {{-- kosong dulu, nanti diisi via JS --}}
                        @if($isDependent && old($field['depends_on'], $data?->{$field['depends_on']}))
                            @php
                                $model = $field['relation'];
                                $foreignKey = $field['foreign_key'];

                                $parentValue = old($field['depends_on'], $data?->{$field['depends_on']});

                                $items = $model::where($foreignKey, $parentValue)->get();
                            @endphp

                            @foreach($items as $item)
                                <option 
                                    value="{{ $item->id }}"
                                    {{ old($key, $data?->$key) == $item->id ? 'selected' : '' }}
                                >
                                    {{ $item->{$field['display']} }}
                                </option>
                            @endforeach
                        @endif
                    @endif

                    {{-- STATIC OPTIONS --}}
                    @if(isset($field['options']))
                        @foreach($field['options'] as $val => $label)
                            <option 
                                value="{{ $val }}"
                                {{ old($key, $data?->$key) == $val ? 'selected' : '' }}
                            >
                                {{ $label }}
                            </option>
                        @endforeach
                    @endif

                </select>
            @break

        @endswitch

        {{-- ERROR --}}
        @error($key)
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
@endforeach