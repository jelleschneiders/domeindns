<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/home') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-globe"></i>
        </div>
        <div class="sidebar-brand-text mx-3">DomeinDNS</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/domains') }}">
            <i class="fas fa-fw fa-globe-europe"></i>
            <span>Domains</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/templates') }}">
            <i class="fas fa-fw fa-list"></i>
            <span>Templates</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/tags') }}">
            <i class="fas fa-fw fa-tags"></i>
            <span>Tags</span></a>
    </li>
    <li class="nav-item">
         <a class="nav-link" href="{{ url('/reseller/users') }}">
             <i class="fas fa-fw fa-user-friends"></i>
             <span>Reseller</span>
         </a>
     </li>
    @if(auth()->user()->is_admin)
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/users') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>All users</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/reseller/requests') }}">
                <i class="fas fa-fw fa-question"></i>
                <span>Requests</span></a>
        </li>
    @endif
</ul>
