@extends('admin.layouts.base')

@section('title', 'Kelas')

@section('content')
<div class="row">
    <div class="col-md-12">

        {{-- Alert Here --}}
        @if ($errors->any())    
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error )
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Buat Kelas</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form enctype="multipart/form-data" method="POST" action="{{ route('admin.grade.store') }}">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Jurusan</label>
                        <input type="text" class="form-control w-50" id="department" name="department"
                            placeholder="Teknik Komputer" value="{{ old('department') }}">
                    </div>
                    <div class="form-group">
                        <label for="title">Fakultas</label>
                        <input type="text" class="form-control w-50" id="faculty" name="faculty"
                            placeholder="Teknik" value="{{ old('faculty') }}">
                    </div>
                    <div class="form-group">
                        <label for="title">Tingkat</label>
                        <input type="number" class="form-control w-50" id="grade" name="grade"
                            placeholder="4" value="{{ old('grade') }}">
                    </div>
                    <div class="form-group">
                        <label for="title">Nama Kelas</label>
                        <input type="text" class="form-control w-50" id="class_name" name="class_name"
                            placeholder="A201" value="{{ old('class_name') }}">
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
