
<div class="col-md-3 ">
    <div class="card">
        <div class="card-body pt-3 pb-1">

            <div class="text-center">
                @if( $user->image == null)
                    <img src=" {{url('public/images/user/user-default.jpg')}} "
                         class="user-profile" alt="Profile Pic">
                @else
                    <img src=" {{url('public/images/user/'.$user->image)}} " class="user-profile"
                         alt="Profile Pic">
                @endif
            </div>
            <div class="list-wrapper text-center mt-2">

                <p>User Name : <span class="text-right">{{ $user->username }}</span></p>
                <p>Email : <span class="text-right">{{ $user->email }}</span></p>
                <p>Mobile : <span class="text-right">{{ $user->phone }}</span></p>
                <p>BALANCE : <span
                            class="text-right">{{number_format(floatval($user->balance), $basic->decimal, '.', '')}} {{$basic->currency}}</span>
                </p>
            </div>
        </div>
    </div>
    <div class="card mt-2">
        <div class="card-body ">

            <div class="user-menu list-group">



                <a href="{{route('user.single',[$user->id])}}" class="@if(Request::routeIs('user.single')) active @endif list-group-item list-group-item-action">Profile Setting <i class="mdi mdi-face-profile float-right"></i></a>
                <a href="{{route('user.password',[$user->id])}}" class="@if(Request::routeIs('user.password')) active @endif list-group-item list-group-item-action">Password Setting <i class="mdi mdi-key float-right"></i></a>
                <a href="{{route('user.balance',[$user->id])}}" class="@if(Request::routeIs('user.balance')) active @endif list-group-item list-group-item-action ">Manage Balance <i class="mdi mdi-wallet float-right"></i></a>
                <a href="{{route('user.email',[$user->id])}}" class="@if(Request::routeIs('user.email')) active @endif list-group-item list-group-item-action ">Send Email <i class="mdi mdi-mail float-right"></i></a>
                <a href="{{route('user.sms',[$user->id])}}" class="@if(Request::routeIs('user.sms')) active @endif list-group-item list-group-item-action ">Send SMS <i class="mdi mdi-phone float-right"></i></a>
                <a href="{{route('user.predictions',[$user->id])}}" class="@if(Request::routeIs('user.predictions')) active @endif  list-group-item list-group-item-action">Prediction Log <i class="mdi mdi-stack-exchange float-right"></i></a>
                <a href="{{route('user.paymentLog',[$user->id])}}" class="@if(Request::routeIs('user.paymentLog')) active @endif list-group-item list-group-item-action ">Payment Log <i class="mdi mdi-stack-exchange float-right"></i></a>

                <a href="{{route('user.withdrawLog',[$user->id])}}" class="@if(Request::routeIs('user.withdrawLog')) active @endif list-group-item list-group-item-action ">Withdraw Log <i class="mdi mdi-stack-exchange float-right"></i></a>


                <a href="{{route('user.transferSEND',[$user->id])}}" class="@if(Request::routeIs('user.transferSEND')) active @endif list-group-item list-group-item-action">Money Transfer <small class="float-right"> (Send)</small></a>
                <a href="{{route('user.transferRECEIVE',[$user->id])}}" class="@if(Request::routeIs('user.transferRECEIVE')) active @endif  list-group-item list-group-item-action ">Money Transfer <small class="float-right"> (Receive)</small></a>
                <a href="{{route('user.transactionLog',[$user->id])}}" class="@if(Request::routeIs('user.transactionLog')) active @endif  list-group-item list-group-item-action">Transaction <i class="mdi mdi-stack-exchange float-right"></i></a>
                <a href="{{route('user.loginLogs',[$user->id])}}" class="@if(Request::routeIs('user.loginLogs')) active @endif list-group-item list-group-item-action">Login History <i class="mdi mdi-information float-right"></i></a>

            </div>
        </div>
    </div>
</div>