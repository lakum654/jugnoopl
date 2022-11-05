<style>
    .active {
        color:blue !important;
    }

    .sub-menu .nav-item .nav-link .active{
        color:blueviolet !important;
    }
</style>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile border-bottom">
      <a href="{{'profile'}}" class="nav-link flex-column">
        <div class="nav-profile-image">
          <img src="{{profileImg()}}" alt="profile" />
          <!--change to offline or busy as needed-->
        </div>
        <div class="nav-profile-text d-flex ml-0 mb-3 flex-column">
          <span class="font-weight-semibold mb-1 mt-2 text-center">{{ Auth::user()->name }}</span>
          <!-- <span class="text-secondary icon-sm text-center">$3499.00</span> -->
        </div>
      </a>
    </li>
    <!-- <li class="nav-item pt-3">
            <a class="nav-link d-block" href="index.html">
              <img class="sidebar-brand-logo" src="../assets/images/logo.svg" alt="" />
              <img class="sidebar-brand-logomini" src="../assets/images/logo-mini.svg" alt="" />
              <div class="small font-weight-light pt-1">Responsive Dashboard</div>
            </a>
            <form class="d-flex align-items-center" action="#">
              <div class="input-group">
                <div class="input-group-prepend">
                  <i class="input-group-text border-0 mdi mdi-magnify"></i>
                </div>
                <input type="text" class="form-control border-0" placeholder="Search" />
              </div>
            </form>
          </li> -->
    <!-- <li class="pt-2 pb-1">
            <span class="nav-item-head">Template Pages</span>
          </li> -->
    <li class="nav-item ">
      <a class="nav-link" href="{{url('admin/dashboard')}}">
        <i class="fa fa-dashboard menu-icon"></i>
        <span class="menu-title {{ Request::is('admin/dashboard') ? 'active' : ''}}">Dashboard</span>
      </a>
    </li>

    <li class="nav-item {{ Request::is('admin/user') || Request::is('admin/user/*') ? 'active' : ''}}">
      <a class="nav-link" href="{{url('admin/user')}}">
        <i class="mdi mdi-account-multiple menu-icon"></i>
        <span class="menu-title">User</span>
      </a>
    </li>


    <li class="nav-item {{ Request::is('admin/orders_list') || Request::is('admin/orders_list/*') ? 'active' : ''}}">
        <a class="nav-link" href="{{ url('admin/orders_list') }}">
          <i class="mdi mdi-square menu-icon"></i>
          <span class="menu-title">Orders</span>
        </a>
      </li>

    <li class="nav-item {{ Request::is('admin/shopkeeper') || Request::is('admin/shopkeeper/*') ? 'active' : ''}}">
      <a class="nav-link" href="{{url('admin/shopkeeper')}}">
        <i class="mdi mdi-account-network menu-icon"></i>
        <span class="menu-title">Shopkeeper</span>
      </a>
    </li>

    <li class="nav-item {{ Request::is('admin/supplier') || Request::is('admin/supplier/*') ? 'active' : ''}}">
      <a class="nav-link" href="{{url('admin/supplier')}}">
        <i class="mdi mdi-nature-people menu-icon"></i>
        <span class="menu-title">Supplier</span>
      </a>
    </li>
    <li class="nav-item {{ Request::is('admin/supplier-product') ? 'active' : ''}}">
      <a class="nav-link" href="{{url('admin/supplier-product')}}">
        <i class="mdi mdi-playstation menu-icon"></i>
        <span class="menu-title">Supplier Product</span>
      </a>
    </li>


    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic1" aria-expanded="false" aria-controls="ui-basic">
        <i class="mdi mdi-store menu-icon"></i>
        <span class="menu-title {{ Request::is('admin/warehouse') || Request::is('admin/warehouse/*') ? 'active' : ''}}">Warehouse</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-basic1">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ Request::is('admin/warehouse') || Request::is('admin/warehouse/create') ? 'active' : ''}}" href="{{ url('admin/warehouse') }}">Warehouse List<a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('admin/warehouse-stock') || Request::is('admin/warehouse-stock/*') ? 'active' : ''}}" href="{{ url('admin/warehouse-stock') }}">Warehouse Stock</a>
          </li>
        </ul>
      </div>
    </li>



    <li class="nav-item {{ Request::is('admin/product') || Request::is('admin/product/create') ? 'active' : ''}}">
      <a class="nav-link" href="{{ url('admin/product') }}">
        <i class="mdi mdi-buffer menu-icon"></i>
        <span class="menu-title">Product</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
        <i class="mdi mdi-arrow-expand-all menu-icon"></i>
        <span class="menu-title">Addons</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-basic">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ Request::is('admin/city') || Request::is('admin/city/*') ? 'active' : ''}}" href="{{url('admin/city')}}">City</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('admin/unit') || Request::is('admin/unit/*') ? 'active' : ''}}" href="{{ url('admin/unit') }}">Unit</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('admin/brand') || Request::is('admin/brand/*') ? 'active' : ''}}" href="{{ url('admin/brand') }}">Brand</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('admin/category') || Request::is('admin/category/*') ? 'active' : ''}}" href="{{ url('admin/category') }}">Category</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('admin/sub_category') || Request::is('admin/sub_category/*') ? 'active' : ''}}" href="{{ url('admin/sub_category') }}">Sub Category</a>
          </li>
        </ul>
      </div>
    </li>


    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic1" aria-expanded="false" aria-controls="ui-basic">
        <i class="mdi mdi-pokeball menu-icon"></i>
        <span class="menu-title">Purchase Order</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-basic1">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ Request::is('admin/po/requested') || Request::is('admin/po/requested/*') ? 'active' : ''}}" href="{{ url('admin/po/requested') }}">Requested PO</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('admin/po/in-progress') || Request::is('admin/po/in-progress/*') ? 'active' : ''}}" href="{{ url('admin/po/in-progress') }}">In Progress PO</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('admin/po/received') || Request::is('admin/po/received/*') ? 'active' : ''}}" href="{{ url('admin/po/received') }}">Received PO</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- <li class="nav-item">
            <a class="nav-link" href="pages/icons/mdi.html">
              <i class="mdi mdi-contacts menu-icon"></i>
              <span class="menu-title">Icons</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/forms/basic_elements.html">
              <i class="mdi mdi-format-list-bulleted menu-icon"></i>
              <span class="menu-title">Forms</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/charts/chartjs.html">
              <i class="mdi mdi-chart-bar menu-icon"></i>
              <span class="menu-title">Charts</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/tables/basic-table.html">
              <i class="mdi mdi-table-large menu-icon"></i>
              <span class="menu-title">Tables</span>
            </a>
          </li>
          <li class="nav-item pt-3">
            <a class="nav-link" href="http://bootstrapdash.com/demo/plus-free/documentation/documentation.html" target="_blank">
              <i class="mdi mdi-file-document-box menu-icon"></i>
              <span class="menu-title">Documentation</span>
            </a>
          </li> -->
  </ul>
</nav>
