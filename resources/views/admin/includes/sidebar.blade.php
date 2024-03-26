 
 <div class="sidebar border-right col-md-3 col-lg-2 p-0 " style="z-index: 9999;">
        <div class="offcanvas-md offcanvas-start " tabindex="1" id="sidebarMenu"
            aria-labelledby="sidebarMenuLabel">
            <h4 class="illustration-text text-center" style="font-size: x-large; padding:10px;">Welcome Back, {{ auth()->user()->name }}!</h4>
            

            <div class="offcanvas-body position-static sidebar-sticky d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
                <ul class="nav flex-column">
                    
                    @can('user_access')
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('admin/users*')) ? 'active' : '' }}"
                            href="{{ route('admin.users.index') }}">
                                <span data-feather="users" class="align-text-bottom"></span>
                                Users
                            </a>
                        </li>
                    @endcan
                    
                    @can('permission_access')
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('admin/permissions*')) ? 'active' : '' }}"
                            href="{{ route('admin.permissions.index') }}">
                                <span data-feather="shield" class="align-text-bottom"></span>
                                Permissions
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('admin/roles*')) ? 'active' : '' }}"
                            href="{{ route('admin.roles.index') }}">
                                <span data-feather="disc" class="align-text-bottom"></span>
                                Roles
                            </a>
                        </li>
                    @endcan
                    @can('post_access')
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('admin/posts*')) ? 'active' : '' }}"
                            href="{{ route('admin.posts.index') }}">
                                <span data-feather="file" class="align-text-bottom"></span>
                                Posts
                            </a>
                        </li>
                    @endcan
                    @can('category_access')
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('admin/categories*')) ? 'active' : '' }}"
                            href="{{ route('admin.categories.index') }}">
                                <span data-feather="list" class="align-text-bottom"></span>
                                Categories
                            </a>
                        </li>
                    @endcan
                    @can('tag_access')
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('admin/tags*')) ? 'active' : '' }}"
                            href="{{ route('admin.tags.index') }}">
                                <span data-feather="tag" class="align-text-bottom"></span>
                                Tags
                            </a>
                        </li>
                    @endcan
                </ul>

                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link mb-2" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt mr-2"></i> <!-- Updated Font Awesome icon -->
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-2" href="{{ route('categories') }}">
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
                            Business Users
                        </a>
                    </li>
                
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route(config('chatify.routes.prefix')) }}">
                            <i class="fas fa-comments mr-2"></i> <!-- Updated Font Awesome icon -->
                            Messages <!-- Corrected spelling from "Messagess" -->
                        </a>
                    </li>
                </ul>
                
                
            </div>
        </div>
    </div>
    
    
