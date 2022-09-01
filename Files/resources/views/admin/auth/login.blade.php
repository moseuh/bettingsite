@extends('admin.form')

@section('content')


    <form class="pt-3"  action="{{route('admin.login')}}" method="post">
        @csrf
      <div class="form-group">
        <input type="text" name="username" value="{{old('username')}}"  class="form-control form-control-lg"  placeholder="Username">
      </div>
      <div class="form-group">
        <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
      </div>
      <div class="mt-3">
        <button type="submit" class="btn btn-block btn-gradient-success btn-lg font-weight-medium auth-form-btn" >SIGN IN</button>
      </div>
    </form>



@endsection