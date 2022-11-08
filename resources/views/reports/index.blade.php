@extends('layouts.master')
@section('title', 'Semua Role')
@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>
                    Ajukan Pengaduan
                </h4>
            </div>

            <div class="card-body">
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group row">
                                <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Dari Tanggal</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control form-control-sm" id="colFormLabelSm"
                                        placeholder="col-form-label-sm">
                                </div>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group row">
                                <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Sampai Tanggal </label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control form-control-sm" id="colFormLabelSm"
                                        placeholder="col-form-label-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    </section>
@endsection
@push('page-scripts')
@endpush
