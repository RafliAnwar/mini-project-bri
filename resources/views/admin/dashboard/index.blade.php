@extends('admin.layouts.base')

@section('title', 'Dashboard')

@section('content')
    <style type="text/css">
        /* Google font */
        @import url('https://fonts.googleapis.com/css?family=Orbitron');

        #digit_clock_time {
            font-family: 'Work Sans', sans-serif;
            color: #272827;
            font-size: 35px;
            text-align: center;
            padding-top: 10px;
        }

        #digit_clock_date {
            font-family: 'Work Sans', sans-serif;
            color: #272827;
            font-size: 20px;
            text-align: center;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .digital_clock_wrapper {
            background-color: #33333300;
            padding: 25px;
            max-width: 350px;
            width: 100%;
            text-align: center;
            border-radius: 5px;
            margin: 0 auto;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header" style="background-color: #6998AB">
                        <h3 class="card-title">Buat Kode Absen</h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center mt-3 mb-3">
                            <form action="{{ route('admin.code.store') }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-danger">Generate Kode Absen</button>
                            </form>
                        </div>
                        @if (session('code'))
                            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                                Kode Absen: {{ session('code') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header" style="background-color: #6998AB">
                        <h3 class="card-title">Form Absen</h3>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="text-center">
                            <h3>Selamat datang, {{ Auth::user()->name }}</h3>
                        </div>
                        <div class="digital_clock_wrapper">
                            <div id="digit_clock_time"></div>
                            <div id="digit_clock_date"></div>
                        </div>
                        {{-- form check in --}}
                        <div>
                            @if (empty($check))
                                <form enctype="multipart/form-data" method="POST"
                                    action="{{ route('admin.attendance.store') }}">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="title">ID Asisten</label>
                                            <input type="text" class="form-control" id="assistant_id" name="assistant_id"
                                                placeholder="Teknik Komputer" value="{{ $user->assistant_id }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="title">Kelas</label>
                                            <select name="grade_id" id="grade_id" class="form-control">
                                                <option disabled selected>Silahkan dipilih</option>
                                                @foreach ($grade as $grade)
                                                    <option value="{{ $grade->id }}">{{ $grade->class_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="title">Materi</label>
                                            <select name="subject_id" id="subject_id" class="form-control">
                                                <option disabled selected>Silahkan dipilih</option>
                                                @foreach ($subject as $subject)
                                                    <option value="{{ $subject->id }}">{{ $subject->subject_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="title">Peran Jaga</label>
                                            <select class="form-control" name="teaching_role" id="teaching_role">
                                                <option selected>Pilih peran jaga</option>
                                                <option value="Ketua">Ketua</option>
                                                <option value="Asisten">Asisten</option>
                                                <option value="Moderator">Moderator</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="title">Kode Absen</label>
                                            <input type="text" class="form-control" id="code" name="code"
                                                placeholder="Ex:Ash2x46ft1" value="{{ old('code') }}">
                                        </div>
                                        <p><em>*Untuk mendapatkan kode absen dapat meminta ke Admin, Staff, dan PJ</em></p>
                                        <div class="col text-center">
                                            <button type="submit" class="btn btn-primary">Clock In</button>
                                        </div>
                                </form>
                            @endif
                            
                            @if (!empty($check))
                                <form id="form-update-absen" method="post"
                                    action = "{{ route('admin.attendance.update') }}" enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf
                                    <div class="col text-center">
                                        <button type="submit" class="btn btn-warning">Clock Out</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

            </div>

        </div>
    </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        function currentTime() {
            var date = new Date(); /* creating object of Date class */
            var hour = date.getHours();
            var min = date.getMinutes();
            var sec = date.getSeconds();
            var midday = "AM";
            midday = (hour >= 12) ? "PM" : "AM"; /* assigning AM/PM */
            hour = (hour == 0) ? 12 : ((hour > 12) ? (hour - 12) : hour); /* assigning hour in 12-hour format */
            hour = changeTime(hour);
            min = changeTime(min);
            sec = changeTime(sec);
            document.getElementById("digit_clock_time").innerText = hour + " : " + min + " : " + sec + " " +
                midday; /* adding time to the div */

            var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October',
                'November', 'December'
            ];
            var days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

            var curWeekDay = days[date.getDay()]; // get day
            var curDay = date.getDate(); // get date
            var curMonth = months[date.getMonth()]; // get month
            var curYear = date.getFullYear(); // get year
            var date = curWeekDay + ", " + curDay + " " + curMonth + " " + curYear; // get full date
            document.getElementById("digit_clock_date").innerHTML = date;

            var t = setTimeout(currentTime, 1000); /* setting timer */
        }

        function changeTime(k) {
            /* appending 0 before time elements if less than 10 */
            if (k < 10) {
                return "0" + k;
            } else {
                return k;
            }
        }

        currentTime();
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
@endsection
