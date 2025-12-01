<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <div class="logo-box">
                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('backend/assets/images/logo-light.png') }}" alt="" height="24">
                    </span>
                </a>
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('backend/assets/images/logo-dark.png') }}" alt="" height="24">
                    </span>
                </a>
            </div>

            <ul id="side-menu">

                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{ route('dashboard') }}" class="tp-link">
                        <i data-feather="home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>


                <li>
                    <a href="#brand" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Brand Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="brand">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('brand.index') }}" class="tp-link">All Brand</a>
                            </li>
                            <li>
                                <a href="{{ route('brand.create') }}" class="tp-link">Add Brand</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#wareHouse" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> WareHouse Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="wareHouse">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.warehouse') }}" class="tp-link">All WareHouse</a>
                            </li>
                            <li>
                                <a href="{{ route('add.warehouse') }}" class="tp-link">Add WareHouse</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#supplier" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Supplier Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="supplier">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.supplier') }}" class="tp-link">All supplier</a>
                            </li>
                            <li>
                                <a href="{{ route('add.supplier') }}" class="tp-link">Add supplier</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#Customer" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Customer Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Customer">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.customer') }}" class="tp-link">All Customer</a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#Product" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Product Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Product">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.category') }}" class="tp-link">All Category</a>
                            </li>

                            <li>
                                <a href="{{ route('all.product') }}" class="tp-link">All Product</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#Purchase" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Purchase Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Purchase">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.purchase') }}" class="tp-link">All Purchase</a>
                            </li>
                            <li>
                                <a href="{{ route('all.return.purchase') }}" class="tp-link">Purchase Return</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#Sale" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Sale Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Sale">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.sale') }}" class="tp-link">All Sale</a>
                            </li>
                            <li>
                                <a href="{{ route('all.return.purchase') }}" class="tp-link">Sale Return</a>
                            </li>

                        </ul>
                    </div>
                </li>


            </ul>
        </div>
        <!-- End Sidebar -->
        <div class="clearfix"></div>
    </div>
</div>
