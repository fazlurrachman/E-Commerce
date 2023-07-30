@extends('layouts.admin')

@section('title')
    Transaction
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Transaction</h2>
                <p class="dashboard-subtitle">List of Transaction!</p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form  class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Tanggal Start</label>
                                            <input type="date" class="form-control" name="tanggal" id="tanggal_start">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Tanggal End</label>
                                            <input type="date" class="form-control" name="tanggal" id="tanggal_end">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Status</label>
                                            <select name="status" class="form-control" id="status">
                                                <option value="">Pilih</option>
                                                <option value="pending" {{ request()->status == "PENDING" ? "selected" : ""}}>Pending</option>
                                                <option value="success" {{ request()->status == "SUCCESS" ? "selected" : ""}}>Success</option>
                                                <option value="shipping" {{ request()->status == "SHIPPING" ? "selected" : ""}}>Shipping</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                            <button type="button" id="cari" class="btn btn-primary">Cari</button>
                                    </div>
                                </form>
                                <div class="table-responsive">
                                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama</th>
                                                <th>Harga</th>
                                                <th>Status</th>
                                                <th>Dibuat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script>
        // AJAX DataTable
        var datatable = $('#crudTable').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '{!! url()->current() !!}',
                data: function (i) {
                                  i.tanggal_start = $('#tanggal_start').val();  
                                  i.tanggal_end = $('#tanggal_end').val();  
                                  i.status = $('#status').val();  
                                   
                                },
            },
            columns: [{
                data: 'id',
                name: 'id'
            }, {
                data: 'user.name',
                name: 'user.name'
            }, {
                data: 'total_price',
                name: 'total_price'
            }, {
                data: 'transaction_status',
                name: 'transaction_status'
            }, {
                data: 'created_at',
                name: 'created_at'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                width: '15%'
            }, ]
        });

        $('#cari').on('click',function(){
            $('#crudTable').DataTable().draw(true);

        })
    </script>
@endpush
