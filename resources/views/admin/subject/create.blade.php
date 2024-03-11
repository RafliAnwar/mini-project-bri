@extends('admin.layouts.base')

@section('title', 'Materi')

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
                <h3 class="card-title">Buat Kategori</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form enctype="multipart/form-data" method="POST" action="{{ route('admin.subject.store') }}">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Nama Materi</label>
                        <input type="text" class="form-control w-50" id="subject_name" name="subject_name"
                            placeholder="Dasar Visualisasi" value="{{ old('subject_name') }}">
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
