<!-- =============================================== -->

<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ $user->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">HOME</li>
            <li><a href="{{ route('admin.dashboard') }}"> <i class="fa fa-home"></i> Dashboard</a></li>
            @if($admin)
                <li class="header">SELL</li>
                <li class="treeview @if(request()->segment(2) == 'products') active @endif">
                    <a href="#">
                        <i class="fa fa-gift"></i> <span>Products</span>
                        <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.products.index') }}"><i class="fa fa-circle-o"></i> List products</a></li>
                        <li><a href="{{ route('admin.products.create') }}"><i class="fa fa-plus"></i> Create product</a></li>
                    </ul>
                </li>
                <li class="treeview @if(request()->segment(2) == 'categories') active @endif">
                    <a href="#">
                        <i class="fa fa-folder"></i> <span>Categories</span>
                        <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.categories.index') }}"><i class="fa fa-circle-o"></i> List categories</a></li>
                        <li><a href="{{ route('admin.categories.create') }}"><i class="fa fa-plus"></i> Create category</a></li>
                    </ul>
                </li>
                <li class="treeview @if(request()->segment(2) == 'customers' || request()->segment(2) == 'addresses') active @endif">
                    <a href="#">
                        <i class="fa fa-user"></i> <span>Customers</span>
                        <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.customers.index') }}"><i class="fa fa-circle-o"></i> List customers</a></li>
                        <li><a href="{{ route('admin.customers.create') }}"><i class="fa fa-plus"></i> Create customer</a></li>
                        <li class="@if(request()->segment(2) == 'addresses') active @endif">
                            <a href="#"><i class="fa fa-map-marker"></i> Addresses
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{ route('admin.addresses.index') }}"><i class="fa fa-circle-o"></i> List addresses</a></li>
                                <li><a href="{{ route('admin.addresses.create') }}"><i class="fa fa-plus"></i> Create address</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="header">ORDERS</li>
                <li class="treeview @if(request()->segment(2) == 'orders') active @endif">
                    <a href="#">
                        <i class="fa fa-money"></i> <span>Orders</span>
                        <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.orders.index') }}"><i class="fa fa-circle-o"></i> List orders</a></li>
                    </ul>
                </li>
                <li class="treeview @if(request()->segment(2) == 'order-statuses') active @endif">
                    <a href="#">
                        <i class="fa fa-anchor"></i> <span>Order Statuses</span>
                        <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.order-statuses.index') }}"><i class="fa fa-circle-o"></i> List order statuses</a></li>
                        <li><a href="{{ route('admin.order-statuses.create') }}"><i class="fa fa-plus"></i> Create order status</a></li>
                    </ul>
                </li>
                <li class="header">DELIVERY</li>
                <li class="treeview @if(request()->segment(2) == 'couriers') active @endif">
                    <a href="#">
                        <i class="fa fa-truck"></i> <span>Couriers</span>
                        <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.couriers.index') }}"><i class="fa fa-circle-o"></i> List couriers</a></li>
                        <li><a href="{{ route('admin.couriers.create') }}"><i class="fa fa-plus"></i> Create courier</a></li>
                    </ul>
                </li>
                <li class="header">CONFIG</li>
                <li class="treeview @if(request()->segment(2) == 'employees') active @endif">
                    <a href="#">
                        <i class="fa fa-star"></i> <span>Employees</span>
                        <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.employees.index') }}"><i class="fa fa-circle-o"></i> List employees</a></li>
                        <li><a href="{{ route('admin.employees.create') }}"><i class="fa fa-plus"></i> Create employee</a></li>
                    </ul>
                </li>
                <li class="treeview @if(request()->segment(2) == 'attributes') active @endif">
                    <a href="#">
                        <i class="fa fa-gear"></i> <span>Attributes</span>
                        <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.attributes.index') }}"><i class="fa fa-circle-o"></i> List attributes</a></li>
                        <li><a href="{{ route('admin.attributes.create') }}"><i class="fa fa-plus"></i> Create attribute</a></li>
                    </ul>
                </li>
                <li class="treeview @if(request()->segment(2) == 'countries' || request()->segment(2) == 'provinces') active @endif">
                    <a href="#">
                        <i class="fa fa-flag"></i> <span>Countries</span>
                        <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.countries.index') }}"><i class="fa fa-circle-o"></i> List</a></li>
                    </ul>
                </li>
            @endif
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<!-- =============================================== -->