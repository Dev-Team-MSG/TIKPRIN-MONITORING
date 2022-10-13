@extends('layouts.master')
@section('title','Home')
@section('content')

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-6 col-lg-6">
            <a href="crud/tambah" class="btn btn-icon icon-left btn-primary"><i class="far fa-edit"></i> Tambah Data</a>
        </div>
    </div>
</div>



@endsection
@push('page-scripts')
@endpush