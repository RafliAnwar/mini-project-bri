@extends('admin.layouts.base')

@section('title', 'Riwayat')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header" style="background-color: #121F3E">
                    <h3 class="card-title">Riwayat Absen</h3>
                </div>

                <div class="card-body">

                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <table id="attendance" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        {{-- <th>Id</th> --}}
                                        <th>ID Asisten</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Materi</th>
                                        <th>Peran</th>
                                        <th>Tanggal</th>
                                        <th>Waktu Mulai</th>
                                        <th>Waktu Akhir</th>
                                        <th>Durasi</th>
                                        <th>PJ</th>  
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($attendance as $attendance)
                                        <tr>
                                            <td></td>
                                            {{-- <td>{{ $attendance->id }} </td> --}}
                                            <td>{{ $attendance->user->assistant_id}} </td>
                                            <td>{{ $attendance->user->name}} </td>
                                            <td>{{ $attendance->grade->class_name}} </td>
                                            <td>{{ $attendance->subject->subject_name}} </td>
                                            <td>{{ $attendance->teaching_role}} </td>
                                            <td>{{ $attendance->date }} </td>
                                            <td>{{ $attendance->start }} </td>
                                            <td>{{ $attendance->end }} </td>
                                            <td>{{ $attendance->duration }} </td>
                                            @php 
                                                $getCode = App\Model\Code::where('id', $attendance->code_id)->first();
                                                $getPJ = App\User::where('id', $getCode->user_id)->first();
                                            @endphp
                                            <td>{{ $getPJ->name}} </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#attendance').DataTable();
            table
                .on('order.dt search.dt', function() {
                    var i = 1;

                    table
                        .cells(null, 0, {
                            search: 'applied',
                            order: 'applied'
                        })
                        .every(function(cell) {
                            this.data(i++);
                        });
                })
                .draw();
            // Apply event listener to all delete buttons
            $('#attendance').on('click', '.delete-btn', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');

                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: 'Item yang telah dihapus tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e31231',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus item!',
                    cancelButtonText: 'Kembali'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form after confirmation
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
