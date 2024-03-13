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
                                    @foreach ($attendance as $record)
                                        <tr>
                                            <td></td>
                                            <td>{{ $record->user->assistant_id }} </td>
                                            <td>{{ $record->user->name }} </td>
                                            <td>{{ $record->grade->class_name }} </td>
                                            <td>{{ $record->subject->subject_name }} </td>
                                            <td>{{ $record->teaching_role }} </td>
                                            <td>{{ $record->date }} </td>
                                            <td>{{ $record->start }} </td>
                                            <td>{{ $record->end }} </td>
                                            <td>{{ $record->duration }} </td>
                                            @php
                                                $getCode = App\Models\Code::where('id', $record->code_id)->first();
                                                $getPJ = App\Models\User::where('id', $getCode->user_id)->first();
                                            @endphp
                                            <td>{{ $getPJ->name }} </td>
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
            var table = $('#attendance').DataTable({
                dom: 'lBfrtipl',
                buttons: [
                    'excel',
                    {
                        extend: 'print',
                        autoPrint: true,
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ]
            });

            table.on('order.dt search.dt', function() {
                var i = 1;
                table.cells(null, 0, {
                    search: 'applied',
                    order: 'applied'
                }).every(function(cell) {
                    this.data(i++);
                });
            }).draw();

            $('#attendance').on('click', '.delete-btn', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');

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
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
