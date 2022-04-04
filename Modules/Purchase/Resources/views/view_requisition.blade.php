<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>{{$title}}</h2>
                <div class="d-flex flex-row-reverse"><button class="btn btn-sm btn-pill btn-outline-primary font-weight-bolder" id="createNew"><i class="fas fa-plus"></i>add data </button></div>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table" id="tableUser">
                            <thead class="font-weight-bold text-center">
                                <tr>
                                    <th>ID</th>
                                    <th>voucher_no</th>
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
<div class="modal fade" id="addModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
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
                        <input type="text" name="voucher_no" class="form-control" id="voucher_no" placeholder="voucher_no"><br>
                    </div>
                    <div class="form-body">
                        <input type="hidden" name="id" id="po_id" />
                        <input type="hidden" name="action" id="po_action" value="add" />
                        <div class="row">
                            <label for="po_voucher_no" class="col-sm-2 col-form-label font-weight-600"><?php echo get_phrases(['SPR', 'no.']) ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-1">
                                <input name="voucher_no" type="text" class="form-control" id="po_voucher_no" placeholder="<?php echo get_phrases(['purchase', 'order', 'no']) ?>" autocomplete="off" readonly>
                            </div>
                            <label for="po_date" class="col-sm-1 col-form-label font-weight-600"><?php echo get_phrases(['date']) ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-1">
                                <input name="date" type="text" class="form-control datepicker1" id="po_date" placeholder="<?php echo get_phrases(['date']) ?>" value="<?php echo date('d/m/Y') ?>" autocomplete="off" readonly>
                            </div>
                        </div>


                        <input type="hidden" name="item_counter" id="po_item_counter" value="1">
                        <div class="row mt-2">
                            <table class="table table-sm table-stripped w-100" id="purchase_table">
                                <thead>
                                    <tr>
                                        <th width="15%" class="text-center"><?php echo get_phrases(['item', 'name']) ?><i class="text-danger">*</i></th>
                                        <th width="5%" class="text-center"><?php echo get_phrases(['present', 'stock']) ?></th>
                                        <th width="10%" class="text-center"><?php echo get_phrases(['total', 'quantity']) ?></th>
                                        <th width="5%" class="text-left"><?php echo get_phrases(['unit']) ?></th>
                                        <th width="5%" class="text-left"><?php echo get_phrases(['last', 'receive', 'date']) ?></th>
                                        <th width="5%" class="text-left"><?php echo get_phrases(['last', 'receive', 'quantity']) ?></th>
                                        <th width="5%" class="text-center"><?php echo get_phrases(['monthly', 'consumption']) ?></th>
                                        <th width="5%" class="text-left"><?php echo get_phrases(['where', 'use']) ?></th>
                                        <th width="5%"><?php echo get_phrases(['action']) ?></th>

                                    </tr>
                                </thead>
                                <tbody id="po_item_div">

                                </tbody>
                                <input type="hidden" name="sub_total" class="form-control text-right" id="po_sub_total" readonly="">
                                <input type="hidden" name="grand_total" class="form-control text-right" id="po_grand_total" readonly="">
                                <input type="hidden" name="vat" class="form-control text-right" id="po_vat" readonly="">
                            </table>
                        </div>

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
    $('document').ready(function() {
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
        function first_item_row(){
        var item_list = $('#item_list').html();

        var html = '<tr>'+
                        '<td><select name="item_id[]" id="item_id1" class="form-control custom-select" onchange="po_item_info(this.value,1)" required>'+item_list+'</select></td>'+
                        '<td class="valign-middle text-right"><span id="main_stock1"></span></td>'+
                        '<td><input type="text" name="qty[]" class="form-control text-right onlyNumber" id="po_qty1" required autocomplete="off" ></td>'+
                        '<td class="valign-middle"><span id="po_unit1"></span></td>'+
                        '<td><input type="text" name="total[]" class="form-control po_total text-right" id="po_total_price_1" readonly=""></td>'+
                        '<td><input type="hidden" name="existing[]" id="existing1" value="0"><button type="button" class="btn btn-success addRow" ><i class="fa fa-plus"></i></button></td>'+
                        '<input type="hidden" name="store[]" id="store1" />'+
                    '</tr>';      
        $("#po_item_div").html(html); 
        $("#po_item_counter").val(1);
        $('select').select2({
            placeholder: '<?php echo get_phrases(['select','item']);?>'                
        });
    }

    function get_item_list(){
         $.ajax({
            url: "{{ route('requisition.index') }}",
            type: 'POST',
            dataType:"html",
            async: false,
            success: function (data) {
                $('#item_list').html(data);
                first_item_row();
            }
        });
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
            ajax: "{{ route('requisition.index') }}",
            columns: [{
                    data: 'id'
                },
                {
                    data: 'voucher_no'
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
        $('#createNew').click(function() {
            get_item_list();
            $('#saveBtn').removeClass("d-none");
            $('#saveBtn').val("create");
            $('#id').val('');
            $('#addForm').trigger("reset");
            $('#addModal').modal('show');
        });
        // initialize btn edit
        $('body').on('click', '.editUser', function() {
            var id = $(this).data('id');
            $.get("{{route('requisition.index')}}" + '/' + id + '/edit', function(data) {
                $('#saveBtn').removeClass("d-none");
                $('#saveBtn').val("edit");
                $('#addModal').modal('show');
                $('#id').val(data.id);
                $('#voucher_no').val(data.voucher_no);
            })
        });
        $('body').on('click', '.actionPreview', function() {
            var id = $(this).data('id');
            $.get("{{route('requisition.index')}}" + '/' + id + '/edit', function(data) {
                $('#saveBtn').addClass("d-none");
                $('#addModal').modal('show');
                $('#id').val(data.id);
                $('#voucher_no').val(data.voucher_no);
            })
        });
        // initialize btn save
        $('#saveBtn').click(function(e) {
            e.preventDefault();
            $(this).html('Save');

            $.ajax({
                data: $('#addForm').serialize(),
                url: "{{ route('requisition.store') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {

                    $('#addForm').trigger("reset");
                    $('#addModal').modal('hide');
                    swal_success();
                    table.draw();

                },
                error: function(data) {
                    swal_error();
                    $('#saveBtn').html('Save Changes');
                }
            });

        });
        // initialize btn delete
        $('body').on('click', '.deleteUser', function() {
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
                        url: "{{route('requisition.store')}}" + '/' + id,
                        success: function(data) {
                            swal_success();
                            table.draw();
                        },
                        error: function(data) {
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