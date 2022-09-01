@php
    $access = json_decode(Auth::guard('admin')->user()->access);
@endphp


<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="{{route('admin.profile')}}" class="nav-link">
                <div class="nav-profile-image">

                    @if(Auth::guard('admin')->user()->image == null)
                        <img src="{{asset('public/images/user/user-default.jpg')}}" alt="profile">
                    @else
                        <img src="{{ asset('public/images/user/') }}/{{Auth::guard('admin')->user()->image}}"
                             alt="profile">
                    @endif

                    <span class="login-status online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">{{Auth::guard('admin')->user()->username}}</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>

        @if(in_array('1',$access))
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.dashboard')}}">
                    <span class="menu-title">Dashboard</span>
                    <i class="mdi mdi-home menu-icon"></i>
                </a>
            </li>
        @endif


        @if(in_array('2',$access))
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false"
                   aria-controls="ui-basic">
                    <span class="menu-title">Prediction Management</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-basic">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"><a class="nav-link" href="{{route('admin.events')}}">Tournament</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('admin.matches')}}">Running Event</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{route('close.matches')}}">Closed Event</a></li>
                    </ul>
                </div>
            </li>
        @endif


        @if(in_array('3',$access))
            <li class="nav-item">
                <a class="nav-link" href="{{route('awaiting.winner')}}">
                    <span class="menu-title">Result</span>
                    <i class="mdi mdi-table-large menu-icon"></i>
                </a>
            </li>
        @endif


        @if(in_array('4',$access))
            <li class="nav-item">
                <a class="nav-link" href="{{route('users')}}">
                    <span class="menu-title">User List</span>
                    <i class="mdi mdi-account-multiple-outline menu-icon"></i>
                </a>
            </li>
        @endif




        @if(in_array('5',$access))
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#payment-method" aria-expanded="false"
                   aria-controls="payment-method">
                    <span class="menu-title">Payment Settings</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="payment-method">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"><a class="nav-link" href="{{route('deposit.pending')}}"> Payment Pending </a></li>

                        <li class="nav-item"><a class="nav-link" href="{{route('deposit.approved')}}"> Payment Approved </a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('deposit.rejected')}}"> Payment Rejected </a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('deposit.log')}}"> Payment Log </a></li>

                        <li class="nav-item"><a class="nav-link" href="{{route('payment-method')}}"> Payment Gateway </a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('admin.deposit.manual.index')}}"> Manual Deposit </a></li>


                    </ul>
                </div>
            </li>
        @endif

        @if(in_array('6',$access))
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#withdraw-method" aria-expanded="false"
                   aria-controls="withdraw-method">
                    <span class="menu-title">Withdraw Settings</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="withdraw-method">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"><a class="nav-link" href="{{route('withdraw-request')}}"> Withdraw
                                Request </a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('withdraw-log')}}"> Withdraw Log </a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{route('withdraw-method')}}"> Withdraw
                                Method </a></li>
                    </ul>
                </div>
            </li>
        @endif






        @if(in_array('7',$access))
            <li class="nav-item">
                <a class="nav-link" href="{{route('staff')}}">
                    <span class="menu-title">Staff Manage</span>
                    <i class="mdi mdi-account-convert menu-icon"></i>
                </a>
            </li>
        @endif

        @if(in_array('8',$access))
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.changePrefix')}}">
                    <span class="menu-title">Admin Prefix</span>
                    <i class="mdi mdi-format-text menu-icon"></i>
                </a>
            </li>
        @endif

        @if(in_array('16',$access))
            <li class="nav-item">
                <a class="nav-link" href="{{route('mail-setting')}}">
                    <span class="menu-title">Mail / SMS Setting</span>
                    <i class="mdi mdi-email menu-icon"></i>
                </a>
            </li>
        @endif


        <li class="nav-item sidebar-actions">
              <span class="nav-link">
                <div class="border-bottom">
                  <h6 class="font-weight-normal mb-3">UI SETTINGS</h6>
                </div>
              </span>
        </li>

        @if(in_array('9',$access))
            <li class="nav-item">
                <a class="nav-link" href="{{route('siteControl')}}">
                    <span class="menu-title">Site Settings</span>
                    <i class="mdi mdi-note-text menu-icon"></i>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('charge-control')}}">
                    <span class="menu-title">Charge &  Controls</span>
                    <i class="mdi mdi-xbox-controller menu-icon"></i>
                </a>
            </li>
        @endif


        @if(in_array('17',$access))
            <li class="nav-item">
                <a class="nav-link" href="{{route('slider')}}">
                    <span class="menu-title">Slider Setting</span>
                    <i class="mdi mdi-image-album menu-icon"></i>
                </a>
            </li>
        @endif


        @if(in_array('10',$access))
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.blog')}}">
                    <span class="menu-title">Blog  Manage</span>
                    <i class="mdi mdi-blogger menu-icon"></i>
                </a>
            </li>
        @endif


        @if(in_array('11',$access))
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#testimonial" aria-expanded="false"
                   aria-controls="testimonial">
                    <span class="menu-title">Testimonial</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-view-carousel menu-icon"></i>
                </a>
                <div class="collapse" id="testimonial">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"><a class="nav-link" href="{{route('testimonial.heading')}}"> Manage
                                Title </a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('testimonial')}}"> Testimonial List </a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif

        @if(in_array('12',$access))
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.about')}}">
                    <span class="menu-title">About Us</span>
                    <i class="mdi mdi-note-text menu-icon"></i>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.howItWork')}}">
                    <span class="menu-title">How It Works</span>
                    <i class="mdi mdi-note-text menu-icon"></i>
                </a>
            </li>



        @endif


        @if(in_array('13',$access))
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.faqs')}}">
                    <span class="menu-title">FAQS</span>
                    <i class="mdi mdi-comment-question-outline menu-icon"></i>
                </a>
            </li>
        @endif

        @if(in_array('14',$access))
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.terms')}}">
                    <span class="menu-title">Terms Conditions</span>
                    <i class="mdi mdi-note-outline menu-icon"></i>
                </a>
            </li>
        @endif

        @if(in_array('15',$access))
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.policy')}}">
                    <span class="menu-title">Privacy Policy</span>
                    <i class="mdi mdi-newspaper menu-icon"></i>
                </a>
            </li>
        @endif
    </ul>
</nav>
