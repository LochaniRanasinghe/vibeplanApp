<!--start breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center" style="padding:10px; border-radius: 5px;">
    <div class="breadcrumb-title pe-3" style="color: rgb(41, 41, 41); font-weight: 600;">
        @yield('parent_heading')
    </div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0 align-items-center">
                <li class="breadcrumb-item">
                    <a href="javascript:;" style="color: rgb(40, 40, 40);">
                        <i class="mdi @yield('parent_icon')" style="font-size: 18px; color: #343a40;"></i>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page" style="color: rgb(46, 46, 46);">
                    @yield('child_heading')
                </li>
                @if (!empty(trim($__env->yieldContent('child_heading2'))))
                    <li class="breadcrumb-item active" aria-current="page" style="color: rgb(37, 37, 37);">
                        @yield('child_heading2')
                    </li>
                @endif
            </ol>
        </nav>
    </div>
</div>
<br>
<!--end breadcrumb-->
