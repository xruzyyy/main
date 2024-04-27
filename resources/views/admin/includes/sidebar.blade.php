
 <div class="sidebar border-right col-md-3 col-lg-2 p-0 " style="z-index: 9999;">
        <div class="offcanvas-md offcanvas-start " tabindex="1" id="sidebarMenu"
            aria-labelledby="sidebarMenuLabel">
            <h4 class="illustration-text text-center" style="font-size: x-large; padding:10px;">Welcome Back, {{ auth()->user()->name }}!</h4>


            <div class="offcanvas-body position-static sidebar-sticky d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link mb-2" href="{{ route('business.home') }}">
                            <i class="fas fa-home mr-2"></i> <!-- Home icon -->
                            Main
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-2" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt mr-2"></i> <!-- Updated Font Awesome icon -->
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-2" href="{{ route('ManagePost') }}">
                            <i class="fas fa-list-alt mr-2"></i> <!-- Font Awesome icon -->
                            Business List
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route('users') }}">
                            <i class="fas fa-user-cog mr-2"></i> <!-- Updated Font Awesome icon -->
                            Manage All Users
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route('admin.ManageBusiness') }}">
                            <i class="fas fa-business-time mr-2"></i> <!-- Updated Font Awesome icon -->
                            Business Users List
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route(config('chatify.routes.prefix'), ['userId' => auth()->id()]) }}">
                            <i class="fas fa-comments mr-2"></i>
                            Messages
                        </a>
                    </li>

                </ul>


            </div>
        </div>
    </div>


