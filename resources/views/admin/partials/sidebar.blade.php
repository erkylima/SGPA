<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="{{ route('admin.dashboard') }}">{{ env('APP_NAME') }}</a>
  </div>
  <div class="sidebar-brand sidebar-brand-sm">
    <a href="index.html">PP</a>
  </div>
  <ul class="sidebar-menu">
    <li class="menu-header">Menu</li>
    <li class="{{ Request::route()->getName() == 'admin.dashboard' ? ' active' : '' }}"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
    @if(Auth::user()->can('manage-users'))
    <li class="menu-header">Usuários</li>
    <li class="{{ Request::route()->getName() == 'admin.users' ? ' active' : '' }}"><a class="nav-link" href="{{ route('admin.users') }}"><i class="fas fa-users"></i> <span>Users</span></a></li>
    @endif
  </ul>
</aside>
