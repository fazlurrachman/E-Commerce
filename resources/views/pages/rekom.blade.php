@extends('layouts.app')

@section('title')
    Store Rekomendasi
@endsection

@section('content')
    <div class="col-lg-12" id="#mainApp">
        <div class="card">
            <div class="card-body" id="divUtama">
                <h4 class="header-title">Daftar Rekomendasi</h4>
                <div class="table-responsive">
                    <table class="table mb-0 table-hover" id="tblLaporan">
                        <thead>
                            <tr>
                                <th>
                                    <center>No</center>
                                </th>
                                <th>
                                    <center>Direkomendasikan Oleh</center>
                                </th>
                                <th>
                                    <center>Waktu Dibuat</center>
                                </th>
                                <th>
                                    <center>Jumlah Produk Direkomendasi</center>
                                </th>
                                <th>
                                    <center>Aksi</center>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataPengujian as $pengujian)
                                <tr>
                                    <td>
                                        <center>{{ $loop->iteration }}</center>
                                    </td>
                                    <td>
                                        <center>{{ $pengujian->nama_penguji }}</center>
                                    </td>
                                    <td>
                                        <center>{{ $pengujian->created_at->diffForHumans() }}</center>
                                    </td>
                                    <td>
                                        <center>
                                            {{ $pengujian->totalPolaProduk($pengujian->kd_pengujian, $pengujian->min_confidence) }}
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <a href="javascript:void(0)" onclick="keDetail('{{ $pengujian->kd_pengujian }}')"
                                                class="btn btn-sm btn-success ">
                                                Lihat
                                            </a>
                                        </center>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- <script>
        $("#tblLaporan").dataTable();

        function keDetail(kdPengujian) {
            renderPage('hasilR/' + kdPengujian, 'hasilRekom');
        }
    </script> --}}

    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.7.14/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    const server = "{{ url('') }}/";

    $(document).ready(function() {
        $("#tblLaporan").DataTable();
    });

    var mainApp = new Vue({
        el: '#mainApp',
        data: {
            judulPage: 'Dashboard'
        },
        methods: {

        }
    });

    function keDetail(kdPengujian) {
        window.location.href = server + 'hasilR/' + kdPengujian;
    }
</script>
