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
                                            class="form-control  {{ $errors->first('name') ? 'is-invalid' : '' }}" required=""
                                            placeholder="Name Lengkap" name="name" value="{{ old('name') }}"
                                            id="name">
                                        <div class="invalid-feedback">
                                            {{ $errors->first('name') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text"
                                            class="form-control {{ $errors->first('username') ? 'is-invalid' : '' }}" required=""
                                            name="username" value="{{ old('username') }}" id="username">
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
                                            <input type="email"
                                                class="form-control {{ $errors->first('email') ? 'is-invalid' : '' }}" required=""
                                                id="inlineFormInputGroup" placeholder="Email" name="email"
                                                value="{{ old('email') }}">
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
                                            <input type="phone"
                                                class="form-control phone-number {{ $errors->first('phone') ? 'is-invalid' : '' }}" required=""
                                                name="phone" value="{{ old('phone') }}">
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
                                            <input type="password"
                                                class="form-control pwstrength {{ $errors->first('password') ? 'is-invalid' : '' }}" required=""
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
                                            <input type="password"
                                                class="form-control pwstrength confirmation {{ $errors->first('password_confirmation') ? 'is-invalid' : '' }}" required=""
                                                data-indicator="pwindicator" name="password_confirmation"
                                                value="{{ old('password_confirmation') }}">
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
                                        @foreach ($roles as $role)
                                        <input onchange="collapseKanim()" type="radio" name="roles" 
                                        @if ($role->name == "kanim")
                                            checked
                                        @endif 
                                        value="{{$role->id}}"> {{$role->name}}<br>
                                        @endforeach
                                        
                                        {{-- <input onchange="collapseKanim()" type="radio" name="roles" value="1"
                                            @if (isset($user->roles[0]) && $user->roles[0]->name == 'admin') checked @endif> Admin<br>
                                        <input onchange="collapseKanim()" type="radio" name="roles" value="2"
                                            @if (isset($user->roles[0]) && $user->roles[0]->name == 'kanim') checked @endif> Kanim<br>
                                        <input onchange="collapseKanim()" type="radio" name="roles" value="3"
                                            @if (isset($user->roles[0]) && $user->roles[0]->name == 'engineer') checked @endif> EOS<br>
                                        <div class="invalid-feedback">
                                            {{ $errors->first('roles') }}
                                        </div> --}}
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
                                        <input id="image" name="image" type="file"
                                            class="form-control {{ $errors->first('image') ? 'is-invalid' : '' }}">
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

            if ($("input[name='roles']:checked").val() == 2) {
                $("#kanim").show();
            } else {
                $("#kanim").hide();
            }
        }
    </script>
@endpush
