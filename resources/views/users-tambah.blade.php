@extends('layouts.master')
@section('title')
    Tambah User
@endsection
@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <form enctype="multipart/form-data" action="{{ route('users.simpan') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4>Tambah User</h4>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text"
                                            class="form-control {{ $errors->first('name') ? "is-invalid" : ""}}"
                                            placeholder="Name Lengkap" name="name" value="{{ old('name') }}" id="name">
                                        <div class="invalid-feedback">
                                            {{ $errors->first('name') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" class="form-control {{$errors->first('username') ? "is-invalid" : ""}}" name="username"
                                            value="{{ old('username') }}" id="username">
                                            <div class="invalid-feedback">
                                                {{ $errors->first('username') }}
                                            </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>E-mail
                                        </label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">@</div>
                                            </div>
                                            <input type="text" class="form-control {{$errors->first('email') ? "is-invalid" : ""}}" id="inlineFormInputGroup"
                                                placeholder="Email" name="email" value="{{ old('email') }}">
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('email') }}
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nomer Telepon</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-phone"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control phone-number {{$errors->first('phone') ? "is-invalid" : ""}}" name="phone"
                                                value="{{ old('phone') }}">
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('phone') }}
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-lock"></i>
                                                </div>
                                            </div>
                                            <input type="password" class="form-control pwstrength {{$errors->first('password') ? "is-invalid" : ""}}"
                                                data-indicator="pwindicator" name="password" value="{{ old('password') }}">
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('password') }}
                                                </div>
                                        </div>
                                        <div id="pwindicator" class="pwindicator">
                                            <div class="bar"></div>
                                            <div class="label"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Konfirmasi Password</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-lock"></i>
                                                </div>
                                            </div>
                                            <input type="password" class="form-control pwstrength confirmation {{$errors->first('password_confirmation') ? "is-invalid" : ""}}"
                                                data-indicator="pwindicator" name="password_confirmation" value="{{ old('password_confirmation') }}">
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('password_confirmation') }}
                                                </div>
                                        </div>
                                        <div id="pwindicator" class="pwindicator">
                                            <div class="bar"></div>
                                            <div class="label"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="d-block">Roles
                                        </label>
                                        <input class="form {{$errors->first('roles') ? "is-invalid" : ""}}" onchange="collapseKanim()" type="radio" name="roles" value="admin"
                                            @if (isset($user->roles) && $user->roles == 'admin') checked @endif> Admin<br>
                                        <input class="form {{$errors->first('roles') ? "is-invalid" : ""}}" onchange="collapseKanim()" type="radio" name="roles" value="kanim"
                                            @if (isset($user->roles) && $user->roles == 'kanim') checked @endif> Kanim<br>
                                        <input class="form {{$errors->first('roles') ? "is-invalid" : ""}}" onchange="collapseKanim()" type="radio" name="roles" value="eos"
                                            @if (isset($user->roles) && $user->roles == 'eos') checked @endif> EOS<br>
                                            <div class="invalid-feedback">
                                                {{ $errors->first('roles') }}
                                            </div>
                                    </div>
                                    <div class="form-group" id="kanim">
                                        <label for="exampleInputEmail1">Kanim </label>
                                        <br>
                                        <select class="form-control" name="kanim_id">
                                            @foreach ($kanims as $kanim)
                                                <option value="{{ $kanim->id }}"
                                                    @if (isset($user->kanim_id) && $user->kanim_id == $kanim->id) selected @endif>{{ $kanim->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">Foto Profile</label>
                                        <br>
                                        <input id="image" name="image" type="file" class="form-control {{$errors->first('image') ? "is-invalid" : ""}}">
                                        <div class="invalid-feedback">
                                            {{ $errors->first('image') }}
                                        </div>
                                        <hr class="my-3">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit" value="Save">Submit</button>
                        <button class="btn btn-secondary" type="reset">Reset</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>
@endsection
@push('page-scripts')
@endpush
@push('specific-scripts')
    <script type="text/javascript">
        function collapseKanim() {
            // console.log($("input[name='privilege']:checked").val());

            if ($("input[name='roles']:checked").val() == 'kanim') {
                $("#kanim").show();
            } else {
                $("#kanim").hide();
            }
        }
    </script>
@endpush
