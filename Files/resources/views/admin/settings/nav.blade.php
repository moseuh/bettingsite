<div class="btn-group" role="group" aria-label="Basic example">
    <a href="{{route('admin.profile')}}" class="btn btn-sm btn-outline-success @if(Request::routeIs('admin.profile')) active @endif">
       <i class=" mdi mdi-account-circle "></i> Profile
    </a>
    <a href="{{route('admin.password')}}" class="btn btn-sm btn-outline-success @if(Request::routeIs('admin.password')) active @endif">
       <i class=" mdi mdi-account-key "></i> Password 
    </a>
</div>