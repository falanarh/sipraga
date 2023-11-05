{{-- Mewarisi semua konten dari view dashboard --}}
@extends('layouts.dashboard')

{{-- Menambahkan library full Calendar --}}
@section('js')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                timeZone: 'UTC',
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay'
                },
                events: [
                    // Daftar event disini
                    {
                        title: 'Falana Rofako',
                        start: '2023-11-02T11:00:00',
                        end: '2023-11-02T12:00:00',
                    },
                    {
                        title: 'Gita Kirana',
                        start: '2023-11-03T08:00:00',
                        end: '2023-11-03T10:00:00',
                    },
                    {
                        title: 'Sariyyanti Hikmah',
                        start: '2023-11-01T07:00:00',
                        end: '2023-11-01T09:00:00',
                    }
                    // Anda dapat menambahkan event-event lainnya
                ]
            });
            calendar.render();
        });
    </script>
@endsection

{{-- Menambahkan sidebar untuk admin --}}
@section('sidebar')
    @include('partials.sidebar-admin')
@endsection

{{-- Menambahkan header untuk admin --}}
@section('header')
    @include('partials.header-admin')
@endsection

{{-- Menambahkan konten yang sesuai --}}
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="title d-flex mb-4">
                <a href="/admin/ketersediaan-ruangan" class="table-title d-flex text-dark">
                    KETERSEDIAAN RUANGAN
                </a>
                <img src="{{ asset('images/icons/arrow-right.svg') }}" alt="">
                <a href="/admin/ketersediaan-ruangan/detail" class="table-title d-flex text-dark">
                    RUANG 331
                </a>            
            </div>
            <div id='calendar'></div>
        </div>
    </div>
@endsection
