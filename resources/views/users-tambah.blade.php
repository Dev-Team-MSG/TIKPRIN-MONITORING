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
                                        <label
                                            @error('name')
                      class="text-danger"
                  @enderror>Nama
                                            @error('nama')
                                                {{ $message }}
                                            @enderror
                                        </label>
                                        <input type="text" class="form-control" placeholder="Name Lengkap" name="name"
                                            value="{{ old('name') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            @error('username')
                      class="text-danger"
                  @enderror>Username
                                            @error('username')
                                                {{ $message }}
                                            @enderror
                                        </label>
                                        <input type="text" class="form-control" name="username"
                                            value="{{ old('username') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            @error('email')
                        class="text-danger"
                    @enderror>E-mail
                                            @error('email')
                                                {{ $message }}
                                            @enderror
                                        </label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">@</div>
                                            </div>
                                            <input type="text" class="form-control" id="inlineFormInputGroup"
                                                placeholder="Email" name="email" {{ old('email') }}>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            @error('phone')
                      class="text-danger"
                  @enderror>Nomer
                                            Telepon @error('phone')
                                                {{ $message }}
                                            @enderror
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-phone"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control phone-number" name="phone"
                                                value="{{ old('phone') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            @error('password')
                      class="text-danger"
                  @enderror>Password
                                            @error('password')
                                                {{ $message }}
                                            @enderror
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-lock"></i>
                                                </div>
                                            </div>
                                            <input type="password" class="form-control pwstrength"
                                                data-indicator="pwindicator" name="password" value="{{ old('password') }}">
                                        </div>
                                        <div id="pwindicator" class="pwindicator">
                                            <div class="bar"></div>
                                            <div class="label"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            @error('password')
                      class="text-danger"
                  @enderror>Konfirmasi
                                            Password @error('password')
                                                {{ $message }}
                                            @enderror
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-lock"></i>
                                                </div>
                                            </div>
                                            <input type="password" class="form-control pwstrength confirmation"
                                                data-indicator="pwindicator" name="password_confirmation"
                                                value="{{ old('password_confirmation') }}">
                                        </div>
                                        <div id="pwindicator" class="pwindicator">
                                            <div class="bar"></div>
                                            <div class="label"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label @error('roles')
                        
                    @enderror
                                            class="d-block">Roles @error('roles')
                                                {{ $message }}
                                            @enderror
                                        </label>
                                        @if (count($roles) > 0)
                                            @foreach ($roles as $role)
                                                <input onchange="collapseKanim()" type="radio" name="roles"
                                                    value="{{$role->id}}" @if (isset($user->roles) && $user->roles == 'admin') checked @endif>
                                                {{$role->name}}<br>
                                            @endforeach
                                        @endif
                                        {{-- <input onchange="collapseKanim()" type="radio" name="roles" value="kanim"
                                            @if (isset($user->roles) && $user->roles == 'kanim') checked @endif> Kanim<br>
                                        <input onchange="collapseKanim()" type="radio" name="roles" value="eos"
                                            @if (isset($user->roles) && $user->roles == 'eos') checked @endif> EOS<br> --}}
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
                                        <input id="image" name="image" type="file" class="form-control">
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
