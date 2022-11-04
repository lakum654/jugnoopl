<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile border-bottom">
      <a href="{{url('user/u-profile')}}" class="nav-link flex-column">
        <div class="nav-profile-image">
          <img src="{{profileImg()}}" alt="profile" />
          <!--change to offline or busy as needed-->
        </div>
        <div class="nav-profile-text d-flex ml-0 mb-3 flex-column">
          <span class="font-weight-semibold mb-1 mt-2 text-center">{{ Auth::user()->name}}</span>
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
    <li class="nav-item">
      <a class="nav-link" href="{{url('user/u-dashboard')}}">
        <i class="mdi mdi-compass-outline menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <!-- <li class="nav-item">
      <a class="nav-link" href="{{url('admin/user')}}">
        <i class="mdi mdi-account-multiple menu-icon"></i>
        <span class="menu-title">User</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{url('admin/shopkeeper')}}">
        <i class="mdi mdi-account-network menu-icon"></i>
        <span class="menu-title">Shopkeeper</span>
      </a>
    </li> -->

    <!-- <li class="nav-item">
      <a class="nav-link" href="{{url('admin/supplier')}}">
        <i class="mdi mdi-nature-people menu-icon"></i>
        <span class="menu-title">Supplier</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{url('admin/warehouse')}}">
        <i class="mdi mdi-store menu-icon"></i>
        <span class="menu-title">Warehouse</span>
      </a>
    </li> -->

    @if(role() == 'supplier')
    <li class="nav-item">
      <a class="nav-link" href="{{ url('user/supp-product') }}">
        <i class="mdi mdi-buffer menu-icon"></i>
        <span class="menu-title">Product</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{ url('user/supplier-po') }}">
        <i class="mdi mdi-buffer menu-icon"></i>
        <span class="menu-title">Purchase Order</span>
      </a>
    </li>
    @endif


    @if(role() =='warehouse')

    <li class="nav-item">
      <a class="nav-link" href="{{ url('user/warehouse-product') }}">
        <i class="mdi mdi-buffer menu-icon"></i>
        <span class="menu-title">Product</span>
      </a>
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
            <a class="nav-link" href="{{ url('user/w-po/requested') }}">Requested PO</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('user/w-po/in-progress') }}">In Progress PO</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('user/w-po/received') }}">Received PO</a>
          </li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{url('user/grn')}}">
        <i class="mdi mdi-note-plus menu-icon"></i>
        <span class="menu-title">GRN</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{url('user/po-report')}}">
        <i class="mdi mdi-note-plus menu-icon"></i>
        <span class="menu-title">PO Report</span>
      </a>
    </li>

    @endif

    @if(role() =='shopkeeper')

    <li class="nav-item">
      <a class="nav-link" href="{{ url('user/sho-order') }}">
        <i class="mdi mdi-buffer menu-icon"></i>
        <span class="menu-title">Order</span>
      </a>
    </li>

    @endif

    @if(role() !=='shopkeeper')
    <!-- <li class="nav-item">
      <a class="nav-link" href="{{ url('user/po-price') }}">
        <i class="mdi mdi-buffer menu-icon"></i>
        <span class="menu-title">PO Price</span>
      </a>
    </li> -->
    @endif

    <!-- <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
        <i class="mdi mdi-account-multiple menu-icon"></i>
        <span class="menu-title">Addons</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-basic">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{url('admin/city')}}">City</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/unit') }}">Unit</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/brand') }}">Brand</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/category') }}">Category</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/sub_category') }}">Sub Category</a>
          </li>
        </ul>
      </div>
    </li> -->

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