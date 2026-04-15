<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .whitespace-nowrap { white-space: nowrap; }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function () {

            const selects = document.querySelectorAll('.dynamic-select');

            selects.forEach(select => {

                const dependsOn = select.dataset.dependsOn;

                if (!dependsOn) return;

                const parent = document.querySelector(`[name="${dependsOn}"]`);

                parent.addEventListener('change', function () {

                    const value = this.value;

                    fetch(`/api/options?model=${select.dataset.relation}&depends_value=${value}&foreign_key=${select.dataset.foreignKey}`)
                        .then(res => res.json())
                        .then(data => {

                            select.innerHTML = '<option value="">Pilih</option>';

                            data.forEach(item => {
                                select.innerHTML += `<option value="${item.id}">${item.nama}</option>`;
                            });

                        });

                });

            });

        });
        </script>
    </body>
</html>
