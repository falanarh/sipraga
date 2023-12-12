<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Perbaikan Sarpras - {{ $pemeliharaanAc->pemeliharaan_ac_id }}</title>
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
            font-size: 10px;
        }

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

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        .dbr {
            margin: 50px;
        }

        header {
            display: inline-block;
            width: 100%;
        }

        .dbr p {
            margin-bottom: 5px;
        }

        .table {
            margin-top: 50px;
        }
        
        p,
        th,
        td {
            font-size: 11px;
        }

        .table-title {
            font-size: 14px;
        }

        header {
            
        }

        span {
            /* font-size: 14px; */
            /* Sesuaikan ukuran font sesuai kebutuhan */
            display: inline-block;
        }

        .left {
            float: left;
        }

        .right, .right .value {
            float: right;
        }

        .right .value {
            margin-right: 35px;
        }

        .dbr .right,
        .sub-title-right {
            width: 185px;
        }

        .value p {
            margin-left: 5px;
        }

        .table-title {
            text-align: center;
            font-weight: 600;
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

        table {
            width: 100%;
            margin-top: 10px;
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
        }

        tbody tr td {
            border-right: 1px solid #000;
            border-left: 1px solid #000;
        }

        tfoot td {
            text-align: center
        }

        /* Additional styles for Perbaikan PDF */
        .header-right {
            float: right;
            margin-top: -10px;
        }

        .header-right p {
            margin-bottom: 5px;
        }

        .header-right .property,
        .header-right .value {
            display: inline-block;
        }

        .header-right .property {
            width: 90px;
        }

        .header-right .value {
            width: calc(100% - 90px);
        }

        .perbaikan-table th,
        .perbaikan-table td {
            border: 1px solid #000;
        }

        .perbaikan-table th,
        .perbaikan-table tfoot td {
            background-color: rgb(189, 189, 189);
            text-align: center;
        }

        .perbaikan-table th,
        .perbaikan-table td {
            padding: 10px;
        }

        .perbaikan-table tfoot td {
            text-align: center;
        }

        .lampiran-page {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <div class="dbr">
        <header>
            <span class="left">
                <p>BADAN PUSAT STATISTIK</p>
                <p>BADAN PUSAT STATISTIK</p>
                <p>SATKER KONSOLIDASI BADAN PUSAT STATISTIK</p>
            </span>
            <span class="header-right">
                <p class="property">Tanggal Cetak</p>
                <p class="value">: {{ now()->format('Y-m-d') }}</p>
            </span>
        </header>
        <div class="table">
            <h2 class="table-title">LAPORAN DETAIL PEMELIHARAAN AC</h2>
            <table class="perbaikan-table">
                <!-- Table body -->
                <thead>
                    <tr>
                        <th class="dark">Property</th>
                        <th class="dark">Isi Data</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <!-- Specifications -->
                        <td class="property">ID</td>
                        <td class="value">{{ $pemeliharaanAc->pemeliharaan_ac_id }}</td>
                    </tr>
                    <tr>
                        <td class="property">Tanggal</td>
                        <td class="value">{{ $pemeliharaanAc->tanggal_selesai->format('Y-m-d') }}</td>
                    </tr>
                    <tr>
                        <td class="property">Kode Barang</td>
                        <td class="value">{{ $jadwalPemeliharaanAc->kode_barang }}</td>
                    </tr>
                    <tr>
                        <td class="property">NUP</td>
                        <td class="value">{{ $jadwalPemeliharaanAc->nup }}</td>
                    </tr>
                    <tr>
                        <td class="property">Merek</td>
                        <td class="value">{{ $ac->merek }}</td>
                    </tr>
                    <tr>
                        <td class="property">Ruang</td>
                        <td class="value">{{ $jadwalPemeliharaanAc->ruang->nama }}</td>
                    </tr>
                    <tr>
                        <td class="property">Pemeliharaan</td>
                        <td class="value">{{ $pemeliharaanAc->judul_pemeliharaan }}</td>
                    </tr>
                    <tr>
                        <td class="property">Keterangan</td>
                        <td class="value">{{ $pemeliharaanAc->keterangan }}</td>
                    </tr>
                    {{-- <tr>
                        <td class="property">Lampiran</td>
                        <td class="value">
                            @php
                                $imageData = file_get_contents($lampiranPath);
                                $base64 = 'data:image/';
                                $imageInfo = getimagesize($lampiranPath);
                                $imageType = image_type_to_mime_type($imageInfo[2]);
                                $base64 .= $imageType;
                                $base64 .= ';base64,' . base64_encode($imageData);
                            @endphp
                            <img src="{{ $base64 }}" alt="Bukti Pemeliharaan AC" style="width: 500px; height: 300px;">
                        </td>
                    </tr> --}}
                    <tr>
                        <td class="property">Lampiran</td>
                        <td class="value">
                            @php
                                $lampiranPath = public_path('storage/' . $pemeliharaanAc->file_path);
                                $base64 = '';
                    
                                // Check if the file exists and is not empty
                                if (file_exists($lampiranPath) && filesize($lampiranPath) > 0) {
                                    $imageData = file_get_contents($lampiranPath);
                                    $base64 = 'data:image/';
                                    $imageInfo = getimagesize($lampiranPath);
                                    $imageType = image_type_to_mime_type($imageInfo[2]);
                                    $base64 .= $imageType;
                                    $base64 .= ';base64,' . base64_encode($imageData);
                                }
                            @endphp
                    
                            @if ($base64)
                                <img src="{{ $base64 }}" alt="Bukti Pemeliharaan AC" style="width: 500px; height: 300px;">
                            @else
                                <p>Tidak ada lampiran</p>
                            @endif
                        </td>
                    </tr>                    
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>