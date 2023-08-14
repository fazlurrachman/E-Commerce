 <!-- Bootstrap core JavaScript -->
 <script src="/vendor/jquery/jquery.slim.min.js"></script>
 <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
 <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
 <script>
   AOS.init();
 </script>
 <script src="/script/navbar-scroll.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script>

    //flash message
    @if(session()->has('success'))
    Swal.fire({
        type: "success",
        icon: "success",
        title: "BERHASIL!",
        text: "{{ session('success') }}",
        timer: 3500,
        showConfirmButton: false,
        showCancelButton: false,
        buttons: false,
    });
    @elseif(session()->has('error'))
    Swal.fire({
        type: "error",
        icon: "error",
        title: "GAGAL!",
        text: "{{ session('error') }}",
        timer: 3500,
        showConfirmButton: false,
        showCancelButton: false,
        buttons: false,
    });
    @endif
</script>
