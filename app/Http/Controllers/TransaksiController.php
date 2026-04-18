<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Rekening;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends BaseCrudController
{
    protected $model = Transaksi::class;
    protected $routePrefix = 'transaksi.';

    public function pageSetting()
    {
        $parent = parent::pageSetting();

        $parent['listTitle'] = 'Data Transaksi';
        $parent['createButton'] = false;

        return $parent;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $model = $this->getModel();
        $data = $model->orderBy('tanggal','desc')->paginate(20);
        return view($this->viewPath.'index', compact('data','model'));
    }

    public function kmk()
    {
        $title = "Transaksi KMK";
        $tipe = "kmk";
        $fields = [
            'id_paket' => [
                'label' => 'Paket',
                'type' => 'select',
                'relation' => \App\Models\Paket::class,
                'display' => 'nama',
            ],
            'id_rekening' => [
                'label' => 'Rekening',
                'type' => 'select',
                'relation' => \App\Models\Rekening::class,
                'display' => 'nama',
            ],
            'target_rekening' => [
                'label' => 'Target Rekening',
                'type' => 'select',
                'relation' => \App\Models\Rekening::class,
                'display' => 'nama',
            ],
            'jumlah' => [
                'label' => 'Jumlah',
                'type' => 'number'
            ],
            'deskripsi' => [
                'label' => 'Deskripsi',
                'type' => 'textarea'
            ],
            'tanggal' => [
                'label' => 'Tanggal',
                'type' => 'date'
            ],
        ];

        return view('transaksi.form', compact('fields','title','tipe'));
    }
    
    public function transfer()
    {
        $title = "Transaksi Transfer";
        $tipe = "transfer";
        $fields = [
            'asal_rekening' => [
                'label' => 'Asal Rekening',
                'type' => 'select',
                'relation' => \App\Models\Rekening::class,
                'display' => 'nama',
            ],
            'tujuan_rekening' => [
                'label' => 'Tujuan Rekening',
                'type' => 'select',
                'relation' => \App\Models\Rekening::class,
                'display' => 'nama',
            ],
            'jumlah' => [
                'label' => 'Jumlah',
                'type' => 'number'
            ],
            'deskripsi' => [
                'label' => 'Deskripsi',
                'type' => 'textarea'
            ],
            'tanggal' => [
                'label' => 'Tanggal',
                'type' => 'date'
            ],
        ];

        return view('transaksi.form', compact('fields','title','tipe'));
    }
    
    public function modal()
    {
        $title = "Transaksi Modal";
        $tipe = "modal";
        $fields = [
            'id_paket' => [
                'label' => 'Paket',
                'type' => 'select',
                'relation' => \App\Models\Paket::class,
                'display' => 'nama',
            ],
            'rekening_modal' => [
                'label' => 'Asal Rekening',
                'type' => 'select',
                'relation' => \App\Models\Rekening::class,
                'display' => 'nama',
            ],
            'id_rekening' => [
                'label' => 'Tujuan Rekening',
                'type' => 'select',
                'relation' => \App\Models\Rekening::class,
                'display' => 'nama',
            ],
            'jumlah' => [
                'label' => 'Jumlah',
                'type' => 'number'
            ],
            'deskripsi' => [
                'label' => 'Deskripsi',
                'type' => 'textarea'
            ],
            'tanggal' => [
                'label' => 'Tanggal',
                'type' => 'date'
            ],
        ];

        return view('transaksi.form', compact('fields','title','tipe'));
    }
    
    public function pendapatan()
    {
        $title = "Transaksi Pendapatan";
        $tipe = "pendapatan";
        $fields = [
            'id_paket' => [
                'label' => 'Paket',
                'type' => 'select',
                'relation' => \App\Models\Paket::class,
                'display' => 'nama',
            ],
            'id_rekening' => [
                'label' => 'Rekening',
                'type' => 'select',
                'relation' => \App\Models\Rekening::class,
                'display' => 'nama',
            ],
            'target_rekening' => [
                'label' => 'Target Rekening',
                'type' => 'select',
                'relation' => \App\Models\Rekening::class,
                'display' => 'nama',
            ],
            'jumlah' => [
                'label' => 'Jumlah',
                'type' => 'number'
            ],
            'potongan_kmk' => [
                'label' => 'Potongan KMK',
                'type' => 'number'
            ],
            'deskripsi' => [
                'label' => 'Deskripsi',
                'type' => 'textarea'
            ],
            'tanggal' => [
                'label' => 'Tanggal',
                'type' => 'date'
            ],
        ];

        return view('transaksi.form', compact('fields','title','tipe'));
    }
    
    public function kewajiban()
    {
        $title = "Transaksi Kewajiban";
        $tipe = "kewajiban";
        $fields = [
            'id_paket' => [
                'label' => 'Paket',
                'type' => 'select',
                'relation' => \App\Models\Paket::class,
                'display' => 'nama',
            ],
            'id_rekening' => [
                'label' => 'Rekening',
                'type' => 'select',
                'relation' => \App\Models\Rekening::class,
                'display' => 'nama',
            ],
            'jumlah' => [
                'label' => 'Jumlah',
                'type' => 'number'
            ],
            'deskripsi' => [
                'label' => 'Deskripsi',
                'type' => 'textarea'
            ],
            'tanggal' => [
                'label' => 'Tanggal',
                'type' => 'date'
            ],
        ];

        return view('transaksi.form', compact('fields','title','tipe'));
    }

    public function save(Request $request)
    {
        $payload = $request->except('tipe','_token');
        $payload['kategori'] = $request->tipe;
        $payload['id_perusahaan'] = null;
        $additionalTransactions = [];

        $prefixKodeBatch = 'TRX-' . now()->format('Ymd') . '-';
        $lastTransaksi = Transaksi::where('kode_batch', 'LIKE', $prefixKodeBatch . '%')
            ->orderByDesc('kode_batch')
            ->first();

        $lastNumber = 0;
        if ($lastTransaksi) {
            $pecah = explode('-', $lastTransaksi->kode_batch);
            $lastNumber = (int) end($pecah);
        }

        $nextNumber = $lastNumber + 1;
        $payload['kode_batch'] = $prefixKodeBatch . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        
        if(isset($payload['id_paket']))
        {
            $paket = Paket::find($payload['id_paket']);
            $payload['id_perusahaan'] = $paket->id_perusahaan;
        }
        elseif(isset($payload['id_rekening']))
        {
            $rekening = Rekening::find($payload['id_rekening']);
            $payload['id_perusahaan'] = $rekening->id_perusahaan;
        }

        if($request->tipe == 'kmk')
        {
            $payload['tipe_transaksi'] = 'masuk';
            $target_rekening = $payload['target_rekening'];
            unset($payload['target_rekening']);

            $additionalTransactions = [
                [
                    ...$payload,
                    'jumlah' => $payload['jumlah'],
                    'tipe_transaksi' => 'keluar',
                    'kategori' => 'transfer'
                ],
                [
                    ...$payload,
                    'id_rekening' => $target_rekening,
                    'jumlah' => $payload['jumlah'],
                    'tipe_transaksi' => 'masuk',
                    'kategori' => 'transfer'
                ],
            ];

            
        }
        
        if($request->tipe == 'transfer')
        {
            $asal_rekening = $payload['asal_rekening'];
            $tujuan_rekening = $payload['tujuan_rekening'];

            $rekeningAsal = Rekening::find($asal_rekening);

            unset($payload['asal_rekening']);
            unset($payload['tujuan_rekening']);
            $payload['tipe_transaksi'] = 'keluar';
            $payload['id_rekening'] = $asal_rekening;
            $payload['id_perusahaan'] = $rekeningAsal->id_perusahaan;
            
            Transaksi::create($payload);

            $rekeningTujuan = Rekening::find($tujuan_rekening);
            
            $payload['id_perusahaan'] = $rekeningTujuan->id_perusahaan;
            $payload['tipe_transaksi'] = 'masuk';
            $payload['id_rekening'] = $tujuan_rekening;
        }

        if($request->tipe == 'modal')
        {
            $asal_rekening = $payload['rekening_modal'];
            $tujuan_rekening = $payload['id_rekening'];

            $rekeningAsal = Rekening::find($asal_rekening);

            unset($payload['rekening_modal']);
            $payload['tipe_transaksi'] = 'keluar';
            $payload['id_rekening'] = $asal_rekening;
            $payload['id_perusahaan'] = $rekeningAsal->id_perusahaan;
            
            Transaksi::create($payload);

            $rekeningTujuan = Rekening::find($tujuan_rekening);
            
            $payload['id_perusahaan'] = $rekeningTujuan->id_perusahaan;
            $payload['tipe_transaksi'] = 'masuk';
            $payload['id_rekening'] = $tujuan_rekening;
        }

        
        if($request->tipe == 'pendapatan')
        {
            $payload['tipe_transaksi'] = 'masuk';
            if($payload['potongan_kmk'])
            {
                $jumlah_potongan = $payload['potongan_kmk'];
                $target_rekening = $payload['target_rekening'];
                unset($payload['target_rekening']);
                unset($payload['potongan_kmk']);

                $additionalTransactions = [
                    [
                        ...$payload,
                        'jumlah' => $jumlah_potongan,
                        'tipe_transaksi' => 'keluar',
                        'kategori' => 'kmk'
                    ],
                    [
                        ...$payload,
                        'id_rekening' => $payload['id_rekening'],
                        'jumlah' => $payload['jumlah'] - $jumlah_potongan,
                        'tipe_transaksi' => 'keluar',
                        'kategori' => 'transfer'
                    ],
                    [
                        ...$payload,
                        'id_rekening' => $target_rekening,
                        'jumlah' => $payload['jumlah'] - $jumlah_potongan,
                        'tipe_transaksi' => 'masuk',
                        'kategori' => 'transfer'
                    ]
                ];
                
            }
        }

        if($request->tipe == 'kewajiban')
        {   
            Transaksi::create([
                ...$payload,
                'kategori' => 'modal',
                'tipe_transaksi' => 'keluar'
            ]);

            $payload['tipe_transaksi'] = 'masuk';
        }

        Transaksi::create($payload);

        if($additionalTransactions)
        {
            foreach($additionalTransactions as $data)
            {
                Transaksi::create($data);
            }
        }

        return redirect()->route('transaksi.index')->with('success', 'Data berhasil disimpan');
    }
}
