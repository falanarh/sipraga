@extends('layouts.dashboard')

@section('additional-js')
    <script>
        // Gunakan window.onload
        window.onload = function() {
            // Gunakan Swal.fire() langsung
            Swal.fire({
                title: "Pilih Peran",
                text: "Anda ingin masuk sebagai?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "PemakaiBHP",
                cancelButtonText: "Pelapor",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect ke dashboard PemakaiBHP atau lakukan tindakan lain
                    window.location.href = '/pemakaibhp/pengambilan';
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Redirect ke dashboard Pelapor atau lakukan tindakan lain
                    window.location.href = '/pelapor/buat-pengaduan';
                }
            });
        };
    </script>
@endsection
