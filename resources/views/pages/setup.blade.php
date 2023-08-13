@extends('layouts.admin')


@section('title')
    Setup nilai support & confidence
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up" id="#mainApp">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Setup nilai support & confidence</h2>
            </div>
            <div class="dashboard-content" id="divUtama">
                <div class="row" id="divDataMentor">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Setup nilai support & confidence</div>
                            <div class="card-body" id="divFormSupp">
                                <div class="form-group">
                                    <label>Nama Penguji</label>
                                    <input type="text" class="form-control" id="txtNama"
                                        placeholder="Masukkan nama penguji" value="Aditia Darma">
                                </div>
                                <div class="form-group">
                                    <label for="company">Min. Support</label> <small>Semakin rendah nilai support akan
                                        semakin banyak
                                        proses yang mengakibatkan proses apriori menjadi lama</small>
                                    <select class="form-control" id="txtSupport">
                                        <?php
                        $x = 1;
                        for ($x; $x <= 100; $x++) { ?>
                                        <option value="<?= $x ?>"><?= $x ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="company">Min. Confidence</label>
                                    <select class="form-control" id="txtConfidence">
                                        <?php
                        $x = 1;
                        for ($x; $x <= 100; $x++) { ?>
                                        <option value="<?= $x ?>"><?= $x ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <a class="btn btn-primary" href="javascript:void(0)" onclick="prosesApriori()">Mulai
                                        Analisa
                                        Penjualan</a>
                                </div>
                            </div>

                            <div id="divLoadingPengujian" style="text-align: center;margin-bottom:30px;display:none;">
                                <img src="{{ asset('ladun/base/loading.svg') }}"><br />
                                Memproses apriori, akan memakan waktu sesuai dengan banyaknya data yang diproses
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.7.14/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    const server = "{{ url('') }}/";
</script>
<script>
    var rProsesApriori = server + "proses";

    document.querySelector("#txtNama").focus();

    var mainApp = new Vue({
        el: '#mainApp',
        data: {
            judulPage: 'Dashboard'
        },
        methods: {

        }
    });

    function renderPage(page, judulPage) {
        $("#divUtama").html("Memuat ...");
        $("#divUtama").load(server + page);
    }


    function confirmQuest(icon, title, text, x) {
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
        }).then((result) => {
            if (result.value) {
                x();
            }
        });
    }

    function prosesApriori() {
        let nama = document.querySelector("#txtNama").value;
        let support = document.querySelector("#txtSupport").value;
        let confidence = document.querySelector("#txtConfidence").value;
        let ds = {
            'support': support,
            'confidence': confidence,
            'nama': nama
        }
        confirmQuest('info', 'Konfirmasi', 'Mulai analisa penjualan ... ?', function(x) {
            konfirmasiApriori(ds)
        });
    }

    function pesanUmumApp(icon, title, text) {
        Swal.fire({
            icon: icon,
            title: title,
            text: text
        });
    }

    function konfirmasiApriori(ds) {
        $("#divFormSupp").hide();
        $("#divLoadingPengujian").show();
        axios.post(rProsesApriori, ds).then(function(res) {
            let kdPengujian = res.data.kdPengujian;
            pesanUmumApp('success', 'Sukses', 'Proses analisa apriori selesai ..');
            $(".dashboard-title").html('Hasil Analisa');
            $("title").html('Hasil Analisa');
            renderPage('hasil/' + kdPengujian, 'Hasil Analisa');
        });
    }
</script>
