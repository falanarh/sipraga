<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        html,
        body,
        div,
        span,
        applet,
        object,
        iframe,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        blockquote,
        pre,
        a,
        abbr,
        acronym,
        address,
        big,
        cite,
        code,
        del,
        dfn,
        em,
        img,
        ins,
        kbd,
        q,
        s,
        samp,
        small,
        strike,
        strong,
        sub,
        sup,
        tt,
        var,
        b,
        u,
        i,
        center,
        dl,
        dt,
        dd,
        ol,
        ul,
        li,
        fieldset,
        form,
        label,
        legend,
        table,
        caption,
        tbody,
        tfoot,
        thead,
        tr,
        th,
        td,
        article,
        aside,
        canvas,
        details,
        embed,
        figure,
        figcaption,
        footer,
        header,
        hgroup,
        menu,
        nav,
        output,
        ruby,
        section,
        summary,
        time,
        mark,
        audio,
        video {
            margin: 0;
            padding: 0;
            border: 0;
            font: inherit;
            vertical-align: baseline;
        }



        /* HTML5 display-role reset for older browsers */
        article,
        aside,
        details,
        figcaption,
        figure,
        footer,
        header,
        hgroup,
        menu,
        nav,
        section {
            display: block;
        }


        body {
            line-height: 1;
            font-family: sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        
        /* @media print { */

            /* Menentukan ukuran dan margin halaman cetakan */
            @page {
                size: A4;
                margin: 10mm 0 10mm 0;
            }

            html,
            body {
                width: 210mm;
                height: 297mm;
                font-size: 11px;
                background: #FFF;
                overflow: visible;
            }

            body {
                padding-top: 15mm;
            }

            /* Menentukan aturan page-break untuk menghindari potongan tabel di tengah */
            thead {
                display: table-header-group;
                margin-top: 100px;
            }

            tbody {
                page-break-inside: avoid;
            }

            /* Memberikan ruang kosong pada awal tabel untuk header */
            .table thead tr {
                height: 100px;
                /* Sesuaikan dengan tinggi header */
            }

            /* Menetapkan margin atas untuk tr pada halaman baru */
            tr {
                page-break-inside: avoid;
                page-break-before: auto;
                margin-top: 20px;
            }

            span{
                page-break-inside: avoid;
                page-break-before: auto;
            }
        /* } */



        ol,
        ul {
            list-style: none;
        }

        blockquote,
        q {
            quotes: none;
        }

        blockquote:before,
        blockquote:after,
        q:before,
        q:after {
            content: '';
            content: none;
        }

        html {
            margin: 0px;
        }

        thead tr {
            padding-top: 100px;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
            page-break-inside: auto;

        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-footer-group;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        /* jarak {
            margin-top: 20px;
        } */

        .corp .left {

            position: fixed;
            display: flex;
            align-items: center;
            clear: both;
            /* Hanya akan ditempatkan di bawah elemen yang berada di sebelah kiri atau kanan */
            margin-bottom: 40px;
        }

        .corp p {

            line-height: 2;
            margin-left: 2rem;
            letter-spacing: 0.5px;
        }

        img {
            margin-right: 10 px;
            height: auto;
            max-width: 20%;

        }


        header {
            display: inline-block;
            width: 100%;
        }

        p,
        th,
        td {
            font-size: 12px;
        }

        .table-title {
            font-size: 14px;
            clear: both;
            margin-bottom: 30px;
        }

        span {
            /* font-size: 14px; */
            /* Sesuaikan ukuran font sesuai kebutuhan */
            display: inline-block;
        }

        .left {
            float: left;
        }

        .right,
        .right .value {
            float: right;
        }

        .right .value {
            margin-right: 35px;
        }


        .value p {
            margin-left: 5px;
        }

        .table-title {
            text-align: center;
            font-weight: 600;
        }

        .table-title .property p {
            text-decoration: underline;
        }

        .sub-title {
            display: inline-block;
            width: 100%;
            margin: 10px 0 30px 0;
        }

        .sub-title-left {
            float: left;
        }

        .sub-title-right {
            float: right;
        }

        .sub-title-right .property {
            float: left;
        }

        .sub-title-right .value {
            float: right;
        }

        .exporBHP {
            margin: 0% 10% 0% 10%;
            display: flex;
            flex-direction: column;
            align-items: center;

        }

        table {
            width: 100%;
            /* margin: 5px auto; */
            /* margin-bottom: 20%; */
            margin-top: 10 %;
            margin-bottom: 5px;
            /* Atur margin secara otomatis dan tengahkan tabel */
            max-width: 100%;
            border-collapse: collapse;
            /* Hilangkan spasi antar sel */
        }

        .property {
            padding-left: 15px;
            /* Sesuaikan dengan jumlah padding yang diinginkan */
            display: block;
            /* Membuat elemen menjadi blok agar padding berlaku */
        }

        table th {
            border: 1px solid #090808;
            padding: 10px;
            font-weight: bold;

        }

        table td {
            padding: 10px;
        }

        table,
        th,
        tfoot td {
            border: 1px solid #000;
            vertical-align: middle;
        }

        table .dark {
            background-color: rgb(189, 189, 189);
        }

        th,
        td {
            padding: 10px;
            text-align: center;
            align-items: center;
        }

        tbody tr td {
            border-right: 1px solid #000;
            border-left: 1px solid #000;
            border-bottom: 1px solid #000;
            border-top: 1px solid #000;
        }

        tfoot td {
            text-align: center;
            border-bottom: 1px solid #000;
        }

        .polstat strong {
            font-weight: bold;
            /* display: block; */
        }

        .polstat {
            line-height: 2;
            margin-left: 2rem;
            letter-spacing: 0.5px;
        }

        .polstat b {
            text-decoration: underline;
            margin-bottom: 5px;
        }
        

        .ttd .left {
            
            line-height: 2;
            text-align: center;
            align-items: center;
            padding-left: 50px;
        }

        .ttd .right {
            line-height: 2;
            text-align: center;
            align-items: center;
            padding-right: 50px;
        }

        .ttd {
            padding-top: 25mm;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .table-title {
            text-align: center;
            font-weight: 600;
            display: block;
            /* Menjadikan elemen ini menjadi blok */
        }

        table tbody td {
            line-height: 1;
        }

        /* Menetapkan lebar kolom pada elemen <th> dan <td> */
        table th:nth-child(1),
        table td:nth-child(1) {
            width: 10%;
            /* Sesuaikan lebar kolom pertama sesuai kebutuhan Anda */
        }

        /* Menetapkan lebar kolom pada elemen <th> dan <td> untuk kolom lainnya */
        table th:nth-child(2),
        table td:nth-child(2) {
            width: 20%;
            /* Sesuaikan lebar kolom kedua sesuai kebutuhan Anda */
        }

        /* Menetapkan lebar kolom pada elemen <th> dan <td> untuk kolom lainnya */
        table th:nth-child(3),
        table td:nth-child(3) {
            width: 15%;
            /* Sesuaikan lebar kolom ketiga sesuai kebutuhan Anda */
        }

        table th:nth-child(4),
        table td:nth-child(4) {
            width: 15%;
            /* Sesuaikan lebar kolom ketiga sesuai kebutuhan Anda */
        }

        table th:nth-child(5),
        table td:nth-child(5) {
            width: 40%;
            /* Sesuaikan lebar kolom ketiga sesuai kebutuhan Anda */
        }

        tbody tr td,
        tfoot td {
            border-bottom: 1px solid #000;
        }

        .ttd .left .pemohon {
            margin-top: 70px;
            align-items: center;
        }

        .ttd .right .pemohon {
            margin-top: 70px;
            align-items: center;
        }







        /* Dan seterusnya sesuai dengan jumlah kolom */
    </style>
</head>

<body>
    <div class="exporBHP">
        {{-- <header> --}}
        <div class="corp">
            <span class="left">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/corp.png'))) }}">
                <span class="polstat">
                    <strong>POLITEKNIK STATISTIKA STIS</strong> <br>
                    Jl Otto Iskandardinata No. 64C, Jakarta 13330<br>
                    Telp. (021)8508812, 8191437, Fax. 8197577<br>
                    Web: <b>www.stis.ac.id</b> Email: info@stis.ac.id
                </span>
            </span>
        </div>


        <div class="table">
            <h2 class="table-title">FORM PENGAMBILAN BARANG HABIS PAKAI</h2>
            <span class="sub-title">
                <span class="sub-title-left">
                    <span class="property">
                        <p>Bagian/Unit/Ruang : {{ $bhp->nama_ruang }} </p>
                    </span>
                </span>
            </span>
            <table>
                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Nama Barang</th>
                        <th colspan="2">Banyaknya</th>
                        <th rowspan="2">Keterangan</th>
                    </tr>
                    <tr>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1; // variabel untuk nomor urut
                    @endphp

                    @if ($ambilbhps)
                        @foreach ($ambilbhps as $row)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ isset($row->jenis_barang) ? $row->jenis_barang : 'Data Tidak Tersedia' }}
                                </td>
                                <td>{{ isset($row->jumlah_ambilBHP) ? $row->jumlah_ambilBHP : 'Data Tidak Tersedia' }}
                                </td>
                                <td>{{ isset($row->satuan) ? $row->satuan : 'Data Tidak Tersedia' }}</td>
                                <td>{{ isset($row->keterangan) ? $row->keterangan : 'Data Tidak Tersedia' }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5">Data tidak ditemukan</td>
                        </tr>
                    @endif


                </tbody>

                {{-- <tfoot>
                        <tr>
                            <td colspan="5" style="border-bottom: 1px solid #000;"></td>
                        </tr>
                    </tfoot> --}}

            </table>
            <div class="ttd">
                <span class="left">
                    Mengetahui <br>
                    Wakil Direktur/Kepala/Ketua<br>
                    <span class="pemohon">
                        <p>{{ $admin ->name}}</p>
                        <p> ___________________</p>
                    </span>

                </span>
                <span class="right">
                    Jakarta, {{ $tanggal_formatted }} <br>
                    Pemohon <br>
                    <span class="pemohon">
                        <p>{{ $pengambilbhp -> name }}</p>
                        <p> ___________________</p>
                    </span>
                </span>
            </div>
        </div>

    </div>
</body>

</html>
