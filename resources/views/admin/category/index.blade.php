@extends('admin.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">

    <div class="card shadow mb-4">

        <x-modal-head title="Category List" id="addCategory" />

        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Icon</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lists as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <th><img src="{{imgPath('category',$list->icon)}}" class="img" /></th>
                            <td>{{ ucwords($list->name)}}</td>
                            <td>{!!$list->status == 1 ? '<span class="badge badge-success">Avtive</span>' : '<span class="badge badge-warning">In Active</span>'!!}</td>
                            <td>{{ $list->dformat($list->created)}}</td>
                            <td>
                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-info editcategory" _id="{{$list->_id}}"><span class="mdi mdi-pencil-box-outline"></span></a>
                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger remove" id="{{$list->_id}}"><span class="mdi mdi-delete"></span></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $lists->appends($_GET)->links()}}
            </div>
        </div>
    </div>

</div>

@push('modal')
<!-- Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalHeading">Add Category</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="cover-loader d-none">
                <div class="loader"></div>
            </div>


            <div class="modal-body h-body">
                <form id="category" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div id="put"></div>

                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" name="name" id="name" class="form-control form-control-sm" placeholder="Enter Category Name">
                        <span id="name_msg" class="c-text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control form-control-sm" id="status" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Icon</label>
                            <input type="file" class="form-control form-control-sm" accept="image/*" id="imgInp" name="icon">
                            <span id="icon_msg" class="c-text-danger"></span>
                        </div>
                        <div class="form-group col-md-6 mt-3">
                            <img src="" id="imgPreview" class="img" />
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success" id="submitcategory">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endpush
@push('script')
<script>
    $(document).ready(function() {

        $('#addCategory').click(function() {
            $('#modalHeading').html('Add Category');
            $('#submitCategory').html('Submit');
            $('form#category').attr('action', '{{url("admin/category")}}');
            $('form#category')[0].reset();
            $('#put').html('');
            $('#categoryModal').modal('show');
        });

        $('form#category').submit(function(e) {
            e.preventDefault();
            formData = new FormData(this);
            let url = $(this).attr('action');
            $('.cover-loader').removeClass('d-none');
            $('.h-body').addClass('d-none');
            axios.post(url, formData)
                .then(function(response) {
                    res = response.data;

                    $('.cover-loader').addClass('d-none');
                    $('.h-body').removeClass('d-none');

                    /*Start Validation Error Message*/
                    $('span.custom-text-danger').html('');
                    $.each(res.validation, (index, msg) => {
                        $(`#${index}_msg`).html(`${msg}`);
                    })
                    /*Start Validation Error Message*/

                    /*Start Status message*/
                    if (res.status == 'success' || res.status == 'error') {
                        Swal.fire(
                            `${res.status}!`,
                            res.msg,
                            `${res.status}`,
                        )
                    }
                    /*End Status message*/

                    //for reset all field
                    if (res.status == 'success') {
                        $('form#category')[0].reset();
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }

                })
                .catch(function(error) {
                    console.log(error);
                    error = error ?? '';
                    Swal.fire(
                        `Error!`,
                        error,
                        `error`,
                    );
                });
        });


        //for edit
        $('.editcategory').click(function() {

            let id = $(this).attr('_id');

            let url = `{{url('admin/category')}}/${id}/edit`;

            axios.get(url).then(resp => {
                response = resp.data.data;
                let image = imgPath('category', response.icon);
                $('#imgPreview').attr('src', image);
                $('#name').val(response.name);
                $('#status').val(response.status);

                $('form#category').attr('action', '{{url("admin/category")}}/' + id);
                $('#put').html('<input type="hidden" name="_method" value="PUT">');

                $('#modalHeading').html('Edit Category');
                $('#submitCategory').html('Update');
                $('#categoryModal').modal('show');

            }).catch(function(error) {
                console.log(error);
                error = error ?? '';
                Swal.fire(
                    `Error!`,
                    error,
                    `error`,
                );
            });
        })


        //for delete
        $('.remove').click(function() {
            let clieckEvt = $(this);
            let id = $(this).attr('_id');
            let url = `{{url('admin/city')}}/${id}`;
            removeRecord(clieckEvt, url);
        });
    })
</script>
@endpush
@endsection