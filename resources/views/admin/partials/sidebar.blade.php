<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="{{ route('admin.index') }}">{{ env('APP_NAME') }}</a>
  </div>
  <div class="sidebar-brand sidebar-brand-sm">
    <a href="index.html">PP</a>
  </div>
  <ul class="sidebar-menu">
    <li class="menu-header">Dashboard</li>
    <li class="{{ Request::route()->getName() == 'admin.index' ? ' active' : '' }}"><a class="nav-link" href="{{ route('admin.index') }}"><i class="fas fa-columns"></i> <span>Dashboard</span></a></li>
    
    @if(!(Auth::user()->can('ver-clientes')))
    <li class="menu-header">Clientes</li>    
    <li class="{{ Request::route()->getName() == 'painel.clientes' ? ' active' : '' }}"><a class="nav-link" href="{{ route('painel.clientes') }}"><i class="fas fa-list"></i> <span>Clientes</span></a></li>
    @endif

    @if(Auth::user()->can('manage-users'))
    <li class="menu-header">Usuários</li>
    <li class="{{ Request::route()->getName() == 'admin.users' ? ' active' : '' }}"><a class="nav-link" href="{{ route('admin.users') }}"><i class="fas fa-users"></i> <span>Users</span></a></li>
    @endif
  </ul>
</aside>
