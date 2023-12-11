{{-- Mewarisi semua konten dari view dashboard --}}
@extends('layouts.dashboard')

{{-- Menambahkan sidebar untuk admin --}}
@section('sidebar')
    @include('partials.sidebar-admin')
@endsection

{{-- Menambahkan header untuk admin --}}
@section('header')
    @include('partials.header')
@endsection

@section('additional-css')
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
            font-size: 14px;
        }

        #calendar {
            max-width: 900px;
            margin: 40px auto;
        }

        .popper,
        .tooltip {
            position: absolute;
            z-index: 9999;
            background: #FFC107;
            color: black;
            width: auto;
            max-width: 160px;
            border-radius: 3px;
            box-shadow: 0 0 2px rgba(0, 0, 0, 0.5);
            padding: 10px;
            text-align: center;
        }

        .style5 .tooltip {
            background: #1E252B;
            color: #FFFFFF;
            max-width: 200px;
            width: auto;
            font-size: .8rem;
            padding: .5em 1em;
        }

        .popper .popper__arrow,
        .tooltip .tooltip-arrow {
            width: 0;
            height: 0;
            border-style: solid;
            position: absolute;
            margin: 5px;
        }

        .tooltip .tooltip-arrow,
        .popper .popper__arrow {
            border-color: #FFC107;
        }

        .style5 .tooltip .tooltip-arrow {
            border-color: #1E252B;
        }

        .popper[x-placement^="top"],
        .tooltip[x-placement^="top"] {
            margin-bottom: 5px;
        }

        .popper[x-placement^="top"] .popper__arrow,
        .tooltip[x-placement^="top"] .tooltip-arrow {
            border-width: 5px 5px 0 5px;
            border-left-color: transparent;
            border-right-color: transparent;
            border-bottom-color: transparent;
            bottom: -5px;
            left: calc(50% - 5px);
            margin-top: 0;
            margin-bottom: 0;
        }

        .popper[x-placement^="bottom"],
        .tooltip[x-placement^="bottom"] {
            margin-top: 5px;
        }

        .tooltip[x-placement^="bottom"] .tooltip-arrow,
        .popper[x-placement^="bottom"] .popper__arrow {
            border-width: 0 5px 5px 5px;
            border-left-color: transparent;
            border-right-color: transparent;
            border-top-color: transparent;
            top: -5px;
            left: calc(50% - 5px);
            margin-top: 0;
            margin-bottom: 0;
        }

        .tooltip[x-placement^="right"],
        .popper[x-placement^="right"] {
            margin-left: 5px;
        }

        .popper[x-placement^="right"] .popper__arrow,
        .tooltip[x-placement^="right"] .tooltip-arrow {
            border-width: 5px 5px 5px 0;
            border-left-color: transparent;
            border-top-color: transparent;
            border-bottom-color: transparent;
            left: -5px;
            top: calc(50% - 5px);
            margin-left: 0;
            margin-right: 0;
        }

        .popper[x-placement^="left"],
        .tooltip[x-placement^="left"] {
            margin-right: 5px;
        }

        .popper[x-placement^="left"] .popper__arrow,
        .tooltip[x-placement^="left"] .tooltip-arrow {
            border-width: 5px 0 5px 5px;
            border-top-color: transparent;
            border-right-color: transparent;
            border-bottom-color: transparent;
            right: -5px;
            top: calc(50% - 5px);
            margin-left: 0;
            margin-right: 0;
        } 
    </style>
     <!-- FullCalendar CSS -->
     {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.css" /> --}}
@endsection

@section('js')
    {{-- <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script> --}}
    {{-- <script src='fullcalendar-scheduler/dist/index.global.js'></script> --}}
    <!-- jQuery -->
    {{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.js"></script> --}}

    {{-- <script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.10/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.10/index.global.min.js'></script>
    <script>

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'resourceTimelineWeek'
        });
        calendar.render();
      });

    </script> --}}
@endsection

{{-- Menambahkan konten yang sesuai --}}
@section('content')
    {{-- <div class="card">
        <div class="card-body">
            <a href="/admin/ketersediaan-ruangan" class="table-title text-dark d-block mb-4">KETERSEDIAAN RUANGAN</a>
            <div class="cards d-flex flex-wrap gap-4">
                <div class="card w-25 m-0 bg-primary">
                    <div class="card-body d-flex flex-column align-items-between p-4 gap-3">
                        <p class="card-text m-0 text-white">Gedung 3</p>
                        <h5 class="card-title fw-bolder text-uppercase text-white m-0">Ruang Kelas 331</h5>
                        <div class="bottom d-flex justify-content-between align-items-center">
                            <p class="m-0 text-white">Lantai 3</p>
                            <a href="/admin/ketersediaan-ruangan/detail" class="btn btn-light">Detail</a>
                        </div>
                    </div>
                </div>
                <div class="card w-25 m-0 bg-primary">
                    <div class="card-body d-flex flex-column align-items-between p-4 gap-3">
                        <p class="card-text text-white m-0">Gedung 3</p>
                        <h5 class="card-title fw-bolder text-uppercase text-white m-0">Ruang Kelas 332</h5>
                        <div class="bottom d-flex justify-content-between align-items-center">
                            <p class="m-0 text-white">Lantai 3</p>
                            <a href="ketersediaan-ruangan/detail" class="btn btn-light">Detail</a>
                        </div>
                    </div>
                </div>
                <div class="card w-25 m-0 bg-primary">
                    <div class="card-body d-flex flex-column align-items-between p-4 gap-3">
                        <p class="card-text text-white m-0">Gedung 3</p>
                        <h5 class="card-title fw-bolder text-uppercase text-white m-0">Ruang Kelas 333</h5>
                        <div class="bottom d-flex justify-content-between align-items-center">
                            <p class="m-0 text-white">Lantai 3</p>
                            <a href="#" class="btn btn-light">Detail</a>
                        </div>
                    </div>
                </div>
                <div class="card w-25 m-0 bg-primary">
                    <div class="card-body d-flex flex-column align-items-between p-4 gap-3">
                        <p class="card-text text-white m-0">Gedung 3</p>
                        <h5 class="card-title fw-bolder text-uppercase text-white m-0">Ruang Kelas 334</h5>
                        <div class="bottom d-flex justify-content-between align-items-center">
                            <p class="m-0 text-white">Lantai 3</p>
                            <a href="#" class="btn btn-light">Detail</a>
                        </div>
                    </div>
                </div>
                <div class="card w-25 m-0 bg-success">
                    <div class="card-body d-flex flex-column align-items-between p-4 gap-3">
                        <p class="card-text text-white m-0">Gedung 2</p>
                        <h5 class="card-title fw-bolder text-uppercase text-white m-0">Ruang Audit</h5>
                        <div class="bottom d-flex justify-content-between align-items-center">
                            <p class="m-0 text-white">Lantai 1</p>
                            <a href="#" class="btn btn-light">Detail</a>
                        </div>
                    </div>
                </div>
                <div class="card w-25 m-0 bg-dark">
                    <div class="card-body d-flex flex-column align-items-between p-4 gap-3">
                        <p class="card-text text-white m-0">Gedung 2</p>
                        <h5 class="card-title fw-bolder text-uppercase text-white m-0">Ruang Laboratorium Komputer I</h5>
                        <div class="bottom d-flex justify-content-between align-items-center">
                            <p class="m-0 text-white">Lantai 4</p>
                            <a href="#" class="btn btn-light">Detail</a>
                        </div>
                    </div>
                </div>
                <div class="card w-25 m-0 bg-dark">
                    <div class="card-body d-flex flex-column align-items-between p-4 gap-3">
                        <p class="card-text text-white m-0">Gedung 2</p>
                        <h5 class="card-title fw-bolder text-uppercase text-white m-0">Ruang Laboratorium Komputer II</h5>
                        <div class="bottom d-flex justify-content-between align-items-center">
                            <p class="m-0 text-white">Lantai 4</p>
                            <a href="#" class="btn btn-light">Detail</a>
                        </div>
                    </div>
                </div>
                <div class="card w-25 m-0 bg-dark">
                    <div class="card-body d-flex flex-column align-items-between p-4 gap-3">
                        <p class="card-text text-white m-0">Gedung 2</p>
                        <h5 class="card-title fw-bolder text-uppercase text-white m-0">Ruang Laboratorium Komputer III</h5>
                        <div class="bottom d-flex justify-content-between align-items-center">
                            <p class="m-0 text-white">Lantai 4</p>
                            <a href="#" class="btn btn-light">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <div id="calendar"></div> --}}
    <iframe src="https://docs.google.com/spreadsheets/d/1Jnid2YGJLwNopjjAtK83s-DJPK_nAAvyIHgMK693y_A/edit#gid=751984853" style="width: 100%; height: 85vh;"></iframe>
@endsection


@section('additional-js')
    {{-- <script>
        function Welcome(props) {
            return '<h1>Hello, ' + props.name + '</h1>';
        }

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['interaction', 'resourceTimeline'],
                timeZone: 'UTC',
                defaultView: 'resourceTimelineDay',
                aspectRatio: 1.5,
                header: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'resourceTimelineDay,resourceTimelineWeek,resourceTimelineMonth'
                },
                editable: true,
                resourceRender: function(info) {
                    var questionMark = document.createElement('a');
                    questionMark.innerText = ' (?) ';

                    info.el.querySelector('.fc-cell-text')
                        .appendChild(questionMark);

                    var tooltip = new Tooltip(questionMark, {
                        html: true,
                        title: '<span id="wewe">12121dfsfsdfsdfsdfsdfsdfsdfsdsdfsdf<br/>fdfdfdf</span>',
                        placement: 'right-start',
                        trigger: 'click',
                        closeOnClickOutside: true,
                        container: 'body',
                    }, {
                        onCreate: data => {}
                    });
                    // ReactDOM.render(Welcome({name: 'YourName'}), document.getElementById('wewe'));
                },
                resourceLabelText: 'Rooms',
                resources: [
                    { id: "a", title: "Ruang 1" },
                    { id: "b", title: "Ruang 2" }
                ],
                events: [
                    { id: "1", resourceId: "a", start: "2023-12-06 09:00:00", end: "2023-12-06 12:00:00", title: "title1" },
                    { id: "2", resourceId: "b", start: "2023-12-06 15:00:00", end: "2023-12-06 19:00:00", title: "title2" }
                ]
            });

            calendar.render();
        });
    </script> --}}
    
@endsection

