<div id="kt_aside" class="aside" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <!--begin::Aside Toolbarl-->
    <div class="aside-toolbar flex-column-auto" id="kt_aside_toolbar">
        <!--begin::Aside user-->
        <!--begin::User-->
        <div class="aside-user d-flex align-items-sm-center justify-content-center py-5">
            <!--begin::Symbol-->
            <div class="symbol symbol-50px">
                <img src="{{asset('admin/media/avatars/blank.png')}}" alt="" />
            </div>
            <!--end::Symbol-->
            <!--begin::Wrapper-->
            <div class="aside-user-info flex-row-fluid flex-wrap ms-5">
                <!--begin::Section-->
                <div class="d-flex">
                    <!--begin::Info-->
                    <div class="flex-grow-1 me-2">
                        <!--begin::Username-->
                        <a href="#" class="text-white text-hover-primary fs-6 fw-bold">{{Auth::user()->name ?? 'User'}}</a>
                        <!--end::Username-->
                    </div>
                    <!--end::Info-->
                    <!--begin::User menu-->

                    <!--end::User menu-->
                </div>
                <!--end::Section-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::User-->
        <!--end::Aside user-->
    </div>
    <!--end::Aside Toolbarl-->
    <!--begin::Aside menu-->
    <div class="aside-menu flex-column-fluid">
        <!--begin::Aside Menu-->
        <div class="hover-scroll-overlay-y px-2 my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="{default: '#kt_aside_toolbar, #kt_aside_footer', lg: '#kt_header, #kt_aside_toolbar, #kt_aside_footer'}" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="5px">
            <!--begin::Menu-->
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true">
                <div class="menu-item">
                    @if(auth()->user()->user_type == \App\Classes\Enums\UserTypesEnum::User)
                        <div class="menu-item">
                            <a class="menu-link {{ Route::currentRouteNamed(auth()->user()->user_type.  '.company.dashboard') ? 'active' : '' }}" href="{{ route((auth()->user()->user_type. '.company.dashboard'),['company'=>\Illuminate\Support\Facades\Session::get('url-slug')])}}" >
                                <span class="menu-title">Dashboard</span>
                            </a>
                        </div>
                    @else
                    <div class="menu-item">
                        <a class="menu-link {{ Route::currentRouteNamed(auth()->user()->user_type.'.dashboard') ? 'active' : '' }}" href="{{ route(auth()->user()->user_type.'.dashboard')}}" >
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </div>
                    @endif

                    @role('finance')
                        <div class="menu-item">
                            <a class="menu-link {{ Route::currentRouteNamed(\App\Classes\Enums\UserTypesEnum::Finance.'.request') ? 'active' : '' }}" href="{{route(\App\Classes\Enums\UserTypesEnum::Finance.'.request')}}" >
                                <span class="menu-title">Manage Request</span>
                            </a>
                        </div>
                        @endrole

                    {{--SUPER ADMIN--}}
                    @role(\App\Classes\Enums\UserTypesEnum::SuperAdmin)
                    <div class="menu-item">
                        <a class="menu-link {{ Route::currentRouteNamed(\App\Classes\Enums\UserTypesEnum::SuperAdmin.'.users') ? 'active' : '' }}" href="{{route(\App\Classes\Enums\UserTypesEnum::SuperAdmin.'.users')}}" >
                            <span class="menu-title">Manage Users</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ Route::currentRouteNamed(\App\Classes\Enums\UserTypesEnum::SuperAdmin.'.company') ? 'active' : '' }}" href="{{route(\App\Classes\Enums\UserTypesEnum::SuperAdmin.'.company')}}" >
                            <span class="menu-title">Manage Companies</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ Route::currentRouteNamed(\App\Classes\Enums\UserTypesEnum::SuperAdmin.'.type-of-expense') ? 'active' : '' }}" href="{{route(\App\Classes\Enums\UserTypesEnum::SuperAdmin.'.type-of-expense')}}" >
                            <span class="menu-title">Manage Type Of Expanses</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ Route::currentRouteNamed(\App\Classes\Enums\UserTypesEnum::SuperAdmin.'.department') ? 'active' : '' }}" href="{{route(\App\Classes\Enums\UserTypesEnum::SuperAdmin.'.department')}}" >
                            <span class="menu-title">Manage Departments</span>
                        </a>
                    </div>
                    @endrole

                    @role('user')
                    <div class="menu-item">
                        <a class="menu-link {{ Route::currentRouteNamed(auth()->user()->user_type.'.supplier') ? 'active' : '' }}"
                           href="{{url(auth()->user()->user_type.'/'.\Illuminate\Support\Facades\Session::get('url-slug').'/'.'supplier')}}" >
                            <span class="menu-title">Manage Suppliers</span>
                        </a>
                    </div>
                    @endrole

                        @hasanyrole('super-admin|accounting')
                        <div class="menu-item">
                            <a class="menu-link {{ Route::currentRouteNamed(auth()->user()->user_type.'.supplier') ? 'active' : '' }}"
                               href="{{url(auth()->user()->user_type.'/'.'supplier')}}" >
                                <span class="menu-title">Manage Suppliers</span>
                            </a>
                        </div>
                        @endhasanyrole

                    @role(\App\Classes\Enums\UserTypesEnum::User)
                    <div class="menu-item">
                        <a class="menu-link {{ Route::currentRouteNamed(\App\Classes\Enums\UserTypesEnum::User.'.request') ? 'active' : '' }}"
                           href="{{url(\App\Classes\Enums\UserTypesEnum::User.'/'.\Illuminate\Support\Facades\Session::get('url-slug').'/'.'request')}}" >
                            <span class="menu-title">Manage Requests</span>
                        </a>
                    </div>
                    @endrole

            </div>
            <!--end::Menu-->
        </div>
        <!--end::Aside Menu-->
    </div>
    <!--end::Aside menu-->

</div>

</div>
