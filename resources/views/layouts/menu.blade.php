<div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                        @else
                            @if ( App\User::find(Auth::user()->id)->group->name == 'admin'  )
                            <li><a href="{{ url('/mains/index/today') }}">Dashboard</a></li>
                            <li class="dropdown">
                                
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->laconame }} - {{App\User::find(Auth::user()->id)->group->name}} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                    <a href="{{route('users.index')}}">User</a>
                                    </li>
                                    <li>
                                    <a href="{{route('jobs.index')}}">Job</a>
                                    </li>
                                    <li>
                                    <a href="{{route('shifts.index')}}">Shift</a>
                                    </li>
                                    <li>
                                    <a href="{{route('products.index')}}">Product</a>
                                    </li>
                                    <li>
                                    <a href="{{route('pst-products.index')}}">PST Product</a>
                                    </li>
                                    
                                    <li>
                                    <a href="{{route('orders.index')}}">Order</a>
                                    </li>
                                    <li>
                                    <a href="{{route('product-groups.index')}}">Product Group</a>
                                    </li>
                                    <li>
                                    <a href="{{route('std-processs.index')}}">Std Productivity</a>
                                    </li>
                                     <li>
                                    <a href="{{route('timeslots.index')}}">Timeslot</a>
                                    </li>
                                    <li>
                                    <a href="{{route('units.index')}}">Unit</a>
                                    </li>
                                    <li>
                                    <a href="{{ route('plannings.index') }}">Planning</a>
                                    </li>
                                    <li>
                                    <a href="{{ route('methods.index') }}">Methods</a>
                                    </li>
                                    <li>
                                    <a href="{{route('packages.index')}}">Packages</a>
                                    </li>
                                    <li>
                                    <a href="{{route('std-packs.index')}}">Std Pack</a>
                                    </li>
                                    <li>
                                    <a href="{{route('iqf-jobs.index')}}">iQf Job</a>
                                    </li>
                                    <li>
                                    <a href="{{route('pre-prods.index')}}">Prepare Prod</a>
                                    </li>
                                    <li>
                                    <a href="{{route('std-pre-prods.index')}}">Std Prepare Prod</a>
                                    </li>
                                    <li>
                                    <a href="{{route('std-select-psts.index')}}">Std Selected PST</a>
                                    </li>
                                    <li><hr/></li>
                                    <li>

                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>

                                    
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        Logs <span class="caret"></span>
                                    </a>
                                <ul class="dropdown-menu" role="menu">       
                                    <li>
                                    <a href="{{ url('/main') }}">Main Select</a>
                                    </li>
                                    <li>
                                    <a href="{{route('log-select-ms.index')}}">FT Select Logs</a>
                                    </li>
                                    <li>
                                    <a href="{{route('log-pack-ms.index')}}">FT Pack Logs</a>
                                    </li>
                                    <li>
                                    <a href="{{route('freeze-ms.index')}}">FT Freeze Logs</a>
                                    </li>
                                    <li>
                                    <a href="{{route('log-prepare-ms.index')}}">FT Prepare Logs</a>
                                    </li>
                                    
                                        <li>
                                    <a href="{{route('log-pst-selects.index')}}">PST Select Logs</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        Reports <span class="caret"></span>
                                    </a>
                                <ul class="dropdown-menu" role="menu">       
                                <li>
                                <a href="{{route('reports.daily')}}">Select Daily Report</a>
                                </li>
                                <li>
                                <a href="{{route('reports.range')}}">Select Range Report</a>
                                </li>
                                <li>
                                <a href="{{route('reports.dailypack2')}}">Pack Daily Report</a>
                                </li>
                                <li>
                                <a href="{{route('reports.rangepack2')}}">Pack Range Report</a>
                                </li>
                                <li>
                                <a href="{{route('reports.dailyfreeze2')}}">Freeze Daily Report</a>
                                </li>
                                <li>
                                <a href="{{route('reports.rangefreeze2')}}">Freeze Range Report</a>
                                </li>
                                <li>
                                <a href="{{route('reports.dailypreprod')}}">Prepare Daily Report</a>
                                </li>
                                <li>
                                <a href="{{route('reports.rangepreprod')}}">Prepare Range Report</a>
                                </li>
                                <li>
                                <a href="{{route('reports.dailypreprod2')}}">New Prepare Daily Report</a>
                                </li>
                                <li>
                                <a href="{{route('reports.rangepreprod2')}}">New Prepare Range Report</a>
                                </li>
                                <li>
                                <a href="{{route('reports.dailyselect2')}}">New Select Daily Report</a>
                                </li>
                                <li>
                                <a href="{{route('reports.rangeselect2')}}">New Select Range Report</a>
                                </li>
                                <li>
                                        <a href="{{route('reports.dailypst')}}">PST Daily Report</a>
                                        </li>
                                        <li>
                                        <a href="{{route('reports.rangepst')}}">PST Range Report</a>
                                        </li>
                                <li>
                                <a href="{{route('reports.orderreport')}}">Order Report</a>
                                </li>
                                <li>
                                <a href="{{ url('/reports/report_pl/pk') }}">PL-PK report</a>
                                </li>
                                <li>
                                <a href="{{route('reports.dailypreprod3')}}">Prepare With Summary Daily Report</a>
                                </li>
                                <li>
                                <a href="{{route('reports.rangepreprod3')}}">Prepare With Summary Range Report</a>
                                </li>
                            </li>
                                @else
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->laconame }} - {{App\User::find(Auth::user()->id)->group->name}} <span class="caret"></span>
                                </a>
                                    @if ( App\User::find(Auth::user()->id)->group->name == 'user_pack' )
                                    <ul class="dropdown-menu" role="menu">
                                        <<li>
                                    <a href="{{route('log-pack-ms.index')}}">FT Pack Logs</a>
                                    </li>
                                        <li><hr/></li>
                                        <li>
                                        <a href="{{route('reports.dailypack')}}">Pack Daily Report</a>
                                        </li>
                                        <li>
                                        <a href="{{route('reports.rangepack')}}">Pack Range Report</a>
                                        </li>
                                        <li>
                                        <a href="{{route('reports.dailypack2')}}">New Pack Daily Report</a>
                                        </li>
                                        <li>
                                        <a href="{{route('reports.rangepack2')}}">New Pack Range Report</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                    @else
                                    @if ( App\User::find(Auth::user()->id)->group->name == 'user_freeze' )
                                    <ul class="dropdown-menu" role="menu">
                                       
                                        <li>
                                    <a href="{{route('freeze-ms.index')}}">FT Freeze Logs</a>
                                    </li>
                                        <li><hr/></li>
                                         <li>
                                        <a href="{{route('reports.dailyfreeze2')}}">Freeze Daily Report</a>
                                        </li>
                                        <li>
                                        <a href="{{route('reports.rangefreeze2')}}">Freeze Range Report</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                    @else
                                    @if ( App\User::find(Auth::user()->id)->group->name == 'user_prepare' )
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                    <a href="{{route('log-prepare-ms.index')}}">FT Prepare Logs</a>
                                    </li>
                                        <li><hr/></li>
                                        <li>
                                        <a href="{{route('reports.dailypreprod')}}">Prepare Daily Report</a>
                                        </li>
                                        <li>
                                        <a href="{{route('reports.rangepreprod')}}">Prepare Range Report</a>
                                        </li>
                                        <li>
                                        <a href="{{route('reports.dailypreprod2')}}">New Prepare Daily Report</a>
                                        </li>
                                        <li>
                                        <a href="{{route('reports.rangepreprod2')}}">New Prepare Range Report</a>
                                        </li>
                                <li>
                                <a href="{{route('reports.dailypreprod3')}}">Prepare With Summary Daily Report</a>
                                </li>
                                <li>
                                <a href="{{route('reports.rangepreprod3')}}">Prepare With Summary Range Report</a>
                                </li>
                                        <li>
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                    @else
                                    @if ( App\User::find(Auth::user()->id)->group->name == 'user_pst' )
                                    <ul class="dropdown-menu" role="menu">
                                    <li>
                                    <a href="{{route('pst-products.index')}}">PST Product</a>
                                    </li>
                                    <li><hr/></li>
                                    <li>
                                    <a href="{{route('log-pst-selects.index')}}">PST Select Logs</a>
                                    </li>
                                        <li><hr/></li>
                                        <li>
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                    @else
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                        <a href="{{ url('/main') }}">Main</a>
                                        </li>
                                        <li>
                                        <a href="{{route('log-select-ms.index')}}">FT Select Logs</a>
                                        </li>
                                        <li><hr/></li>
                                        <li>
                                        <a href="{{route('reports.dailypst')}}">PST Daily Report</a>
                                        </li>
                                        <li>
                                        <a href="{{route('reports.rangepst')}}">PST Range Report</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                    @endif
                                    @endif
                                    @endif
                                    @endif
                                @endif
                            </li>
                        @endif
                    </ul>
                </div>