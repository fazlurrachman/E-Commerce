@extends('layouts/app')

@section('content')
    <h4 class="header-title" style="text-align: left;margin:10px;">Rekomendasi Produk</h4>

    <div class="container">
        <div class="row">
            @php
                $usedProducts = []; // Array untuk melacak produk yang telah ditampilkan
            @endphp

            @foreach ($dataMinConfidence as $is)
                @php
                    $dataProduk = $is->dataProduk($is->kd_barang_a);
                    
                    // Cek apakah produk telah ditampilkan sebelumnya
                    if (!in_array($dataProduk->id, $usedProducts)) {
                        $usedProducts[] = $dataProduk->id; // Tambahkan ID produk ke dalam array
                    } else {
                        continue; // Lewati iterasi jika produk sudah ditampilkan
                    }
                    
                    $firstGallery = $dataProduk->galleries->first();
                @endphp

                <div class="col-lg-3 col-md-4 col-sm-6 py-3">
                    <div class="card mb-4 shadow h-100">
                        @if ($firstGallery)
                            <img src="/storage/{{ $firstGallery->photos }}" class="card-img-top" alt="{{ $dataProduk->name }}"
                                width="200" height="350">
                        @endif

                        <div class="card-body">
                            <center>
                                <h5 class="card-title mb-lg-4">
                                    <strong>{{ $dataProduk->name }}</strong>
                                </h5>
                            </center>
                            <p class="card-text text-wrap mb-lg-1"><strong>Harga :
                                </strong>Rp.{{ number_format($dataProduk->price) }}</p>

                        </div>
                        <br>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
