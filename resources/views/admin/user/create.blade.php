@extends('admin.layouts.base')

@section('title', 'Asisten')

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
                <h3 class="card-title">Tambah Asisten</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form enctype="multipart/form-data" method="POST" action="{{ route('admin.user.store') }}">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">ID Asisten</label>
                        <input type="number" class="form-control w-50" id="assistant_id" name="assistant_id"
                            placeholder="21120992" value="{{ old('assistant_id') }}">
                    </div>
                    <div class="form-group">
                        <label for="title">Nama</label>
                        <input type="text" class="form-control w-50" id="name" name="name"
                            placeholder="Nama Asisten" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="role">Jabatan</label>
                        <select class="form-control w-50" id="role" name="role">
                            <option value="">Pilih Jabatan</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="pj" {{ old('role') == 'pj' ? 'selected' : '' }}>PJ</option>
                            <option value="asisten" {{ old('role') == 'asisten' ? 'selected' : '' }}>Asisten</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="title">Email</label>
                        <input type="text" class="form-control w-50" id="email" name="email"
                            placeholder="zzz@gmail.com" value="{{ old('email') }}">
                    </div>
                    <div class="form-group">
                        <label for="title">Password</label>
                        <input type="text" class="form-control w-50" id="password" name="password"
                            placeholder="password" value="{{ old('password') }}">
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
