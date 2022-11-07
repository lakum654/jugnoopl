<div class="card-body p-0">
    <div class="row">
        <div class="col-md-12">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-all-tab" data-toggle="tab" href="#nav-all" role="tab" aria-controls="nav-all" aria-selected="true">All</a>
                    <a class="nav-item nav-link" id="nav-inprogress-tab" data-toggle="tab" href="#nav-inprogress" role="tab" aria-controls="nav-inprogress" aria-selected="false">Inprogress</a>
                    <a class="nav-item nav-link" id="nav-delivered-tab" data-toggle="tab" href="#nav-delivered" role="tab" aria-controls="nav-delivered" aria-selected="false">Delivered</a>
                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
                    @include('admin.order.order_parts.all')
                </div>
                <div class="tab-pane fade" id="nav-inprogress" role="tabpanel" aria-labelledby="nav-inprogress-tab">
                    @include('admin.order.order_parts.progress')
                </div>
                <div class="tab-pane fade" id="nav-delivered" role="tabpanel" aria-labelledby="nav-delivered-tab">
                    @include('admin.order.order_parts.delivered')
                </div>
            </div>
        </div>
    </div>
</div>
