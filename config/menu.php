<?php

return [
    [
        'label' => 'Perusahaan',
        'route' => 'perusahaan.index',
        'routePrefix' => 'perusahaan.'
    ],
    [
        'label' => 'Rekening',
        'route' => 'rekening.index',
        'routePrefix' => 'rekening.'
    ],
    [
        'label' => 'Kategori',
        'route' => 'kategori.index',
        'routePrefix' => 'kategori.'
    ],
    [
        'label' => 'Paket',
        'route' => 'paket.index',
        'routePrefix' => 'paket'
    ],
    // [
    //     'label' => 'Modal',
    //     'route' => 'modal.index',
    //     'routePrefix' => 'modal.'
    // ],
    [
        'label' => 'Transaksi',
        'route' => 'transaksi.index',
        'routePrefix' => 'transaksi.',
        'children' => [
            [
                'label' => 'List',
                'route' => 'transaksi.index',
                'routePrefix' => 'transaksi.'
            ],
            [
                'label' => 'KMK',
                'route' => 'transaksi.kmk',
                'routePrefix' => 'transaksi.'
            ],
            [
                'label' => 'Transfer',
                'route' => 'transaksi.transfer',
                'routePrefix' => 'transaksi.'
            ],
            [
                'label' => 'Modal',
                'route' => 'transaksi.modal',
                'routePrefix' => 'transaksi.'
            ],
            [
                'label' => 'Pendapatan',
                'route' => 'transaksi.pendapatan',
                'routePrefix' => 'transaksi.'
            ],
            [
                'label' => 'Kewajiban',
                'route' => 'transaksi.kewajiban',
                'routePrefix' => 'transaksi.'
            ],
        ]
    ],
    [
        'label' => 'Laporan',
        'route' => 'laporan.index',
        'routePrefix' => 'laporan.',
        'children' => [
            // [
            //     'label' => 'Ledger',
            //     'route' => 'laporan.buku-besar',
            //     'routePrefix' => 'laporan.',
            // ],
            [
                'label' => 'Posisi Keuangan',
                'route' => 'laporan.index',
                'routePrefix' => 'laporan.',
            ],
            // [
            //     'label' => 'Saldo Perusahaan',
            //     'route' => 'laporan.saldo-perusahaan',
            //     'routePrefix' => 'laporan.',
            // ],
            // [
            //     'label' => 'Saldo Kegiatan',
            //     'route' => 'laporan.saldo-kegiatan',
            //     'routePrefix' => 'laporan.',
            // ],
            // [
            //     'label' => 'Laporan Kegiatan',
            //     'route' => 'laporan.laporan-kegiatan',
            //     'routePrefix' => 'laporan.',
            // ],
        ]
    ],

];