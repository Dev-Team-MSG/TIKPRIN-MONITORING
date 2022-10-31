@extends("layouts.master")
@section("title") Create New User @endsection
@section("content")

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
        <form action="{{ route('users.store')}}" method="POST">
            @csrf
              <div class="card-header">
                <h4>Tambah User</h4>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label @error('name')
                      class="text-danger"
                  @enderror>Nama @error('nama')
                      {{ $message }}
                  @enderror</label>
                  <input type="text" class="form-control" name="name" value="{{ old('name')}}">
                </div>
                <div class="form-group">
                    <label @error('email')
                        class="text-danger"
                    @enderror>E-mail @error('email')
                        {{ $message }}
                    @enderror</label>
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text">@</div>
                      </div>
                      <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Username" name="email" {{ old('email')}}>
                    </div>
                  </div>
                <div class="form-group">
                  <label @error('phone')
                      class="text-danger"
                  @enderror>Phone Number @error('phone')
                      {{ $message }}
                  @enderror</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <i class="fas fa-phone"></i>
                      </div>
                    </div>
                    <input type="text" class="form-control phone-number" name="phone" value="{{ old('phone')}}">
                  </div>
                </div>
                <div class="form-group">
                  <label @error('password')
                      class="text-danger"
                  @enderror>Password @error('password')
                      {{ $message }}
                  @enderror</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <i class="fas fa-lock"></i>
                      </div>
                    </div>
                    <input type="password" class="form-control pwstrength" data-indicator="pwindicator" name="password" value="{{ old('password')}}">
                  </div>
                  <div id="pwindicator" class="pwindicator">
                    <div class="bar"></div>
                    <div class="label"></div>
                  </div>
                </div>
                <div class="form-group">
                    <label @error('roles')
                        
                    @enderror class="d-block">Roles @error('roles')
                        {{ $message }}
                    @enderror</label>
                    <input onchange="collapseKanim()" type="radio" name="roles" value="1" @if(isset($post->roles) && $post->roles == '1') checked @endif > Admin<br>
                    <input onchange="collapseKanim()" type="radio" name="roles" value="2" @if(isset($post->roles) && $post->roles == '2') checked @endif > Kanim<br>
                    <input onchange="collapseKanim()" type="radio" name="roles" value="3" @if(isset($post->roles) && $post->roles == '3') checked @endif > EOS<br>
                  </div>
                  {{-- <div class="form-group">
                    <label>Kelas</label>
                    <select class="form-control">
                      <option>Kelas 1</option>
                      <option>Kelas 2</option>
                      <option>Kelas 3</option>
                    </select>
                  </div> --}}
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