<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>{{$title}}</h2>
                <div class="d-flex flex-row-reverse"><button
                        class="btn btn-sm btn-pill btn-outline-primary font-weight-bolder" id="createNew"><i
                            class="fas fa-plus"></i>add data </button></div>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table" id="tableUser">
                            <thead class="font-weight-bold text-center">
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Updated Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal-->
<div class="modal fade" id="addModal" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="exampleModalLabel">Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="addForm" name="addForm">
                    <div class="form-group">
                        <input type="hidden" name="id" id="id" value="">
                        <input type="text" name="title" class="form-control" id="title" placeholder="Title"><br>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary font-weight-bold" id="saveBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>



@push('scripts')
<script>
    $('document').ready(function () {
        // success alert
        function swal_success() {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Your work has been saved',
                showConfirmButton: false,
                timer: 1000
            })
        }
        // error alert
        function swal_error() {
            Swal.fire({
                position: 'centered',
                icon: 'error',
                title: 'Something goes wrong !',
                showConfirmButton: true,
            })
        }
        // table serverside
        var table = $('#tableUser').DataTable({
            processing: false,
            serverSide: true,
            ordering: false,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf'
            ],
            ajax: "{{ route('items.index') }}",
            columns: [{
                    data: 'id'
                },
                {
                    data: 'title'
                },
                {
                    data: 'updated_at'
                },
                {
                    data: 'action'
                },
            ]
        });
        
        // csrf token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // initialize btn add
        $('#createNew').click(function () {
            $('#saveBtn').removeClass("d-none");
            $('#saveBtn').val("create");
            $('#id').val('');
            $('#addForm').trigger("reset");
            $('#addModal').modal('show');
        });
        // initialize btn edit
        $('body').on('click', '.editUser', function () {
            var id = $(this).data('id');
            $.get("{{route('items.index')}}" + '/' + id + '/edit', function (data) {
                $('#saveBtn').removeClass("d-none");
                $('#saveBtn').val("edit");
                $('#addModal').modal('show');
                $('#id').val(data.id);
                $('#title').val(data.title);
            })
        });
        $('body').on('click', '.actionPreview', function () {
            var id = $(this).data('id');
            $.get("{{route('items.index')}}" + '/' + id + '/edit', function (data) {
                $('#saveBtn').addClass("d-none");
                $('#addModal').modal('show');
                $('#id').val(data.id);
                $('#title').val(data.title);
            })
        });
        // initialize btn save
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Save');

            $.ajax({
                data: $('#addForm').serialize(),
                url: "{{ route('items.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {

                    $('#addForm').trigger("reset");
                    $('#addModal').modal('hide');
                    swal_success();
                    table.draw();

                },
                error: function (data) {
                    swal_error();
                    $('#saveBtn').html('Save Changes');
                }
            });

        });
        // initialize btn delete
        $('body').on('click', '.deleteUser', function () {
            var id = $(this).data("id");

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
                    $.ajax({
                        type: "DELETE",
                        url: "{{route('items.store')}}" + '/' + id,
                        success: function (data) {
                            swal_success();
                            table.draw();
                        },
                        error: function (data) {
                            swal_error();
                        }
                    });
                }
            })
        });

        // statusing


    });

</script>
@endpush
