@extends('admin.layouts.layouts')
@section('content')

<div class="content-wrapper pb-0">

    <div class="card shadow mb-4">

        <x-modal-head title="Unit List" id="addUnit" />

        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Unit</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lists as $key => $list)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ ucwords($list->unit)}}</td>
                            <td>{!!$list->status == 1 ? '<span class="badge badge-success">Avtive</span>' : '<span class="badge badge-warning">In Active</span>'!!}</td>
                            <td>{{ $list->dformat($list->created)}}</td>
                            <td>
                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-info editunit" _id="{{$list->_id}}"><span class="mdi mdi-pencil-box-outline"></span></a>
                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger remove"><span class="mdi mdi-delete"></span></a>
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
<div class="modal fade" id="unitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalHeading">Add Unit</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="cover-loader d-none">
                <div class="loader"></div>
            </div>


            <div class="modal-body h-body">
                <form id="unit" action="" method="post">
                    @csrf
                    <div id="put"></div>

                    <div class="form-group">
                        <label>Unit Name</label>
                        <input type="text" name="unit" id="unit_name" class="form-control form-control-sm" placeholder="Enter Unit Name">
                        <span id="unit_msg" class="c-text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control form-control-sm" id="status" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success" id="submitunit">Submit</button>
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

        $('#addUnit').click(function() {
            $('#modalHeading').html('Add Unit');
            $('#submitUnit').html('Submit');
            $('form#unit').attr('action', '{{url("admin/unit")}}');
            $('form#unit')[0].reset();
            $('#put').html('');
            $('#unitModal').modal('show');
        });

        $('form#unit').submit(function(e) {
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
                        $('form#unit')[0].reset();
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
        $('.editunit').click(function() {

            let id = $(this).attr('_id');

            let url = `{{url('admin/unit')}}/${id}/edit`;

            axios.get(url).then(resp => {
                response = resp.data.data;
                $('#unit_name').val(response.unit);
                $('#status').val(response.status);

                $('form#unit').attr('action', '{{url("admin/unit")}}/' + id);
                $('#put').html('<input type="hidden" name="_method" value="PUT">');

                $('#modalHeading').html('Edit Unit');
                $('#submitUnit').html('Update');
                $('#unitModal').modal('show');

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

            let id = $(this).attr('_id');

            let url = `{{url('admin/unit')}}/${id}/edit`;

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            })
        });
    })
</script>
@endpush
@endsection