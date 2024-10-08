@extends('auth.layout')

@section('content')

<div class="container">
    <a class="btn btn-primary float-right m-2" href="javascript:void(0)" id="createNewProduct"> Create New Employee</a>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>DOB</th>
                <th>Gender</th>
                <th width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="productForm" name="productForm" class="form-horizontal">
                    <input type="hidden" name="employee_id" id="employee_id">
                    <input type="hidden" name="password" id="password" value="123456">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-12">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="dob" class="col-sm-2 control-label">DOB</label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" id="dob" name="dob" placeholder="Select DOB" value="" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="gender" class="col-sm-2 control-label">Gender</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="gender" name="gender">
                                <option value="MALE">MALE</option>
                                <option value="FEMALE">FEMALE</option>
                                <option value="NA">OTHER</option>
                            </select>
                        </div>
                    </div>


                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>

<script type="text/javascript">
    $(function() {

        /*------------------------------------------
         --------------------------------------------
         Pass Header Token
         --------------------------------------------
         --------------------------------------------*/
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /*------------------------------------------
        --------------------------------------------
        Render DataTable
        --------------------------------------------
        --------------------------------------------*/
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('employees.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'dob',
                    name: 'dob'
                },
                {
                    data: 'gender',
                    name: 'gender'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        /*------------------------------------------
        --------------------------------------------
        Click to Button
        --------------------------------------------
        --------------------------------------------*/
        $('#createNewProduct').click(function() {
            $('#saveBtn').val("create-product");
            $('#employee_id').val('');
            $('#productForm').trigger("reset");
            $('#modelHeading').html("Create New Employee");
            $('#ajaxModel').modal('show');
        });

        /*------------------------------------------
        --------------------------------------------
        Click to Edit Button
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.editProduct', function() {
            var employee_id = $(this).data('id');
            $.get("{{ route('employees.index') }}" + '/' + employee_id + '/edit', function(data) {                
                $('#modelHeading').html("Edit Employee");
                $('#saveBtn').val("edit-user");
                $('#ajaxModel').modal('show');
                $('#employee_id').val(data.id);
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#dob').val(data.dob);
                $('#gender').val(data.gender);
            })
        });

        /*------------------------------------------
        --------------------------------------------
        Create Product Code
        --------------------------------------------
        --------------------------------------------*/
        $('#saveBtn').click(function(e) {
            e.preventDefault();
            $(this).html('Sending..');

            $.ajax({
                data: $('#productForm').serialize(),
                url: "{{ route('employees.store') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {

                    $('#productForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    table.draw();

                },
                error: function(data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save Changes');
                }
            });
        });

        /*------------------------------------------
        --------------------------------------------
        Delete Product Code
        --------------------------------------------
        --------------------------------------------*/
        $('body').on('click', '.deleteProduct', function() {

            var employee_id = $(this).data("id");
            confirm("Are You sure want to delete !");

            $.ajax({
                type: "DELETE",
                url: "{{ route('employees.store') }}" + '/' + employee_id,
                success: function(data) {
                    table.draw();
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        });

    });
</script>

@endsection