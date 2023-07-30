@extends('layouts.admin')

@section('title')
    Store Dashboard
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">{{ auth()->user()->roles }} Dashboard</h2>
                <p class="dashboard-subtitle">Administrator Panel!</p>
            </div>
            <div class="dashboard-content">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="dashboard-card-title">{{ strtoupper("Pendapatan Bulan ini") }}</div>
                                <div class="dashboard-card-subtitle">{{ moneyFormat($pendapatan_bulan) }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="dashboard-card-title">{{ strtoupper("Pendatan Tahun ini") }}</div>
                                <div class="dashboard-card-subtitle"> {{ moneyFormat($pendapatan_tahun) }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="dashboard-card-title">{{ strtoupper("Semua Pendapatan") }}</div>
                                <div class="dashboard-card-subtitle">{{ moneyFormat($pendapatan_global) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4" onclick="location.href='{{route('transaction.index')}}?status=SUCCESS';">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="dashboard-card-title">{{ strtoupper("SUCCESS") }}</div>
                                <div class="dashboard-card-subtitle">{{ $transaction_success }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" onclick="location.href='{{route('transaction.index')}}?status=PENDING';">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="dashboard-card-title">{{ strtoupper("PENDING") }}</div>
                                <div class="dashboard-card-subtitle">{{ $transaction_pending }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" onclick="location.href='{{route('transaction.index')}}?status=SHIPPING';">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="dashboard-card-title">{{ strtoupper("SHIPPING") }}</div>
                                <div class="dashboard-card-subtitle">{{ $transaction_shipping }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card mb-2">
                            <div class="card-body ">
                                <div class="dashboard-card-title text-center mb-3">{{ strtoupper("Product Best Seller") }}</div>
                                <table class="table">
                                    <thead>
                                      <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Produk</th>
                                        <th scope="col">Jumlah</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transaction_best as $item)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->count_product . " PCS" }}</td>
                                           
                                          </tr>
                                
                                    
                                @endforeach
                                      
                                      
                                    </tbody>
                                  </table>
                                
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                {!! $chart->container() !!}
                            </div>
                        </div>
                    </div>
                    
                </div>
                {{-- <div class="row mt-3">
                    <div class="col-12 mt-2">
                        <h5 class="mb-3">Recent Transactions</h5>
                        <a class="card card-list d-block" href="/dashboard-transactions-details.html">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-1">
                                        <img src="/images/dashboard-icon-product-1.png" alt="" />
                                    </div>
                                    <div class="col-md-4">Shirup Marzzan</div>
                                    <div class="col-md-3">Angga Risky</div>
                                    <div class="col-md-3">12 Januari, 2023</div>
                                    <div class="col-md-1 d-none d-md-block">
                                        <img src="/images/dashboard-arrow-right.svg" alt="" />
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a class="card card-list d-block" href="/dashboard-transactions-details.html">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-1">
                                        <img src="/images/dashboard-icon-product-2.png" alt="" />
                                    </div>
                                    <div class="col-md-4">LeBrone X</div>
                                    <div class="col-md-3">Masayoshi</div>
                                    <div class="col-md-3">11 January, 2020</div>
                                    <div class="col-md-1 d-none d-md-block">
                                        <img src="/images/dashboard-arrow-right.svg" alt="" />
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a class="card card-list d-block" href="/dashboard-transactions-details.html">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-1">
                                        <img src="/images/dashboard-icon-product-3.png" alt="" />
                                    </div>
                                    <div class="col-md-4">Soffa Lembutte</div>
                                    <div class="col-md-3">Shayna</div>
                                    <div class="col-md-3">11 January, 2020</div>
                                    <div class="col-md-1 d-none d-md-block">
                                        <img src="/images/dashboard-arrow-right.svg" alt="" />
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
@push('addon-script')
<script src="{{ $chart->cdn() }}"></script>

{{ $chart->script() }}
</body>
@endpush