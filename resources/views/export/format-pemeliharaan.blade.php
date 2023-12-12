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

        .pemeliharaan {
            margin: 50px;
        }

        header {
            display: inline-block;
            width: 100%;
        }

        .pemeliharaan p {
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

        header {}

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

        .pemeliharaan .right,
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
        th {
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

        thead tr td,
        tbody tr td {
            border: 1px solid #000;
        }

        thead tr td {
            font-weight: bold;
            text-align: center;
        }

        /* tfoot td {
            text-align: center
        } */
    </style>
</head>

<body>
    <div class="pemeliharaan">
        <header>
            <span class="left">
                <p>BADAN PUSAT STATISTIK</p>
                {{-- <p>BADAN PUSAT STATISTIK</p> --}}
                <p>SATKER KONSOLIDASI BADAN PUSAT STATISTIK</p>
            </span>
            <span class="right">
                <span class="property">
                    <p>Tanggal Cetak</p>
                    <p>Halaman</p>
                </span>
                <span class="value">
                    <p> : {{ $created_at }}</p>
                    <p> : 1</p>
                </span>
            </span>
        </header>
        <div class="table">
            <h2 class="table-title">LAPORAN PEMELIHARAAN DAN PERBAIKAN AC</h2>
            <span class="sub-title">
                <span class="sub-title-left">
                    <span class="property">
                        <p>NAMA</p>
                        <p>KODE UAKPB</p>
                    </span>
                    <span class="value">
                        <p>: Politeknik Statistika STIS</p>
                        <p>: 054.01.0199.690332.000</p>
                    </span>
                </span>
                {{-- <span class="sub-title-right">
                    <span class="property">
                        <p>NAMA RUANG</p>
                        <p>KODE RUANG</p>
                    </span>
                    <span class="value">
                        <p>: {{ $ruang->nama }}</p>
                        <p>: {{ $ruang->kode_ruang }}</p>
                    </span>
                </span> --}}
            </span>
            <table>
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Tanggal Selesai</td>
                        <td>Gedung</td>
                        <td>Lantai</td>
                        <td>Ruangan</td>
                        <td>Jenis AC</td>
                        <td>Pemeliharaan</td>
                        <td>Perbaikan</td>
                        <td>Keterangan</td>
                        <td>Follow Up Rekanan</td>
                        {{-- <td></td> --}}
                        <td>Status</td>
                    </tr>
                    <tr class="dark">
                        <th>(1)</th>
                        <th>(2)</th>
                        <th>(3)</th>
                        <th>(4)</th>
                        <th>(5)</th>
                        <th>(6)</th>
                        <th>(7)</th>
                        <th>(8)</th>
                        <th>(9)</th>
                        <th>(10)</th>
                        <th>(11)</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- {{ use App\Models\Aset; }} --}}
                    @php
                        $no = 1; // variabel untuk nomor urut
                    @endphp

                    @foreach ($dataPemeliharaan as $row)
                        {{-- {{ $ac = Aset::where('kode_barang', $pemeliharaanAc->jadwalPemeliharaanAc->kode_barang)->where('nup', $pemeliharaanAc->jadwalPemeliharaanAc->nup)->first() }} --}}
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $row->tanggal_selesai->format('d/m/Y') }}</td>
                            <td>{{ $row->jadwalPemeliharaanAc->ruang->gedung }}</td>
                            <td>{{ $row->jadwalPemeliharaanAc->ruang->lantai }}</td>
                            <td>{{ $row->jadwalPemeliharaanAc->ruang->nama }}</td>
                            <td>{{ $dataAset[$no]->merek }}</td>
                            <td>{{ $row->judul_pemeliharaan }}</td>
                            <td>{{ $row->judul_perbaikan }}</td>
                            <td>{{ $row->keterangan }}</td>
                            <td>
                                @if ($row->file_path)
                                    Ya
                                @else
                                    Tidak
                                @endif
                            </td>
                            <td>{{ $row->jadwalPemeliharaanAc->status }}</td>
                            {{-- <td>1 Buah</td> --}}
                            {{-- <td style="width: 25%;">Milik Sendiri</td> --}}
                            {{-- <td>-</td> --}}
                            {{ $no = $no+1 }}
                        </tr>
                    @endforeach
                </tbody>
                {{-- <tfoot>
                    <tr>
                        <td colspan="9">
                            Tidak dibenarkan memindahkan barang-barang yang ada pada daftar ini tanpa sepengetahuan
                            penanggung jawab Unit Akuntansi Kuasa
                        </td>
                    </tr>
                </tfoot> --}}
            </table>
        </div>
    </div>
</body>

</html>
