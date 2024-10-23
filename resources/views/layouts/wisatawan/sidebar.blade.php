@php
    use App\Models\Menu;
    use Illuminate\Support\Facades\Route;
@endphp
<div class="sidebar dark-bg">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-primary">
                <li class="nav-item @if (Route::currentRouteName() == 'home') {{ 'active' }} @endif">
                    <a href="{{ route('home') }}">
                        <i class="fas fa-home"></i>
                        <p>Home</p>
                    </a>
                </li>
                {{-- @foreach (Menu::list() as $index_menu => $datas)
                    @if (Auth::user()->hasDepartment($datas['departments']))
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">{{ $datas['header'] }}</h4>
                        </li>
                        @foreach ($datas['menus'] as $index => $route)
                            @if (isset($route['children']))
                                @php
                                    $collectionA = collect($route['children']);
                                    $check = !empty($collectionA->where('route', Request::url())->all()) ? 1 : 0;
                                @endphp
                                <li class="nav-item @if ($check) {{ 'active' }} @endif">
                                    <a data-toggle="collapse" href="#menu_{{ $index_menu }}">
                                        <i class="{{ $route['icon'] }}"></i>
                                        <p>
                                            {{ $route['displayName'] }}
                                        </p>
                                        <span class="caret"></span>
                                    </a>
                                    <div class="collapse @if ($check) {{ 'show' }} @endif"
                                        id="menu_{{ $index_menu }}">
                                        <ul class="nav nav-collapse">

                                            @foreach ($route['children'] as $childRoute)
                                                @if (Auth::user()->hasDepartment($childRoute['sub_departments']))
                                                    <li
                                                        class="@if ($childRoute['route'] == Request::url()) {{ 'active' }} @endif">
                                                        <a
                                                            href="@isset($childRoute['route']) {{ $childRoute['route'] }} @else # @endisset">
                                                            <span
                                                                class="sub-item">{{ $childRoute['displayName'] }}</span>
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                            @else
                                <li class="nav-item @if ($route['route'] == Request::url()) {{ 'active' }} @endif">
                                    <a href="{{ $route['route'] }}">
                                        <i class="{{ $route['icon'] }}"></i>
                                        <p>
                                            {{ $route['displayName'] }}
                                        </p>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
                @can('administrate')
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Administration</h4>
                    </li>
                    <li class="nav-item">
                        <a data-toggle="collapse" href="#rbac">
                            <i class="fas fa-cogs"></i>
                            <p>
                                RBAC
                            </p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="rbac">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{ url('/rbac/users') }}">
                                        <i class="far fa-user nav-icon"></i>
                                        Users
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/rbac/department') }}">
                                        <i class="far fa-user-circle nav-icon"></i>
                                        Department
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/rbac/roles') }}">
                                        <i class="far fa-user-circle nav-icon"></i>
                                        Roles
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/rbac/permissions') }}">
                                        <i class="fas fa-id-badge nav-icon"></i>
                                        Permissions
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan --}}
            </ul>
        </div>
    </div>
</div>
