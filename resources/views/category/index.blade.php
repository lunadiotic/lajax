@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Category list
                        <a onclick="addForm()" class="btn btn-primary pull-right" style="margin-top: -8px;">Add Category</a>
                        </h4>
                    </div>
                    <div class="panel-body">
                        <table id="category-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="30">No</th>
                                    <th>Category</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('category.form')
@endsection

@section('scripts')
    <script type="text/javascript">
        var table, save_method;
        table = $('#category-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('api.category.data') }}",
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'category', name: 'category'},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ]
                });

        $(function(){
            $('#modal-form form').validator().on('submit', function (e) {
                if (!e.isDefaultPrevented()){
                    var id = $('#id').val();
                    if (save_method == 'add') url = "{{ $base_url }}";
                    else url = "{{ $base_url . '/' }}" + id;

                    $.ajax({
                        url : url,
                        type : "POST",
                        data : $('#modal-form form').serialize(),
                        success : function($data) {
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                            swal({
                                title: 'Success!',
                                text: 'Data has been created!',
                                type: 'success',
                                timer: '1500'
                            })
                        },
                        error : function(){
                            swal({
                                title: 'Oops...',
                                text: 'Something went wrong!',
                                type: 'error',
                                timer: '1500'
                            })
                        }
                    });
                    return false;
                }
            });
        });

        function addForm() {
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            $('.modal-title').text('Add Category');
        }

        function editForm(id){
            save_method = "edit";
            $('input[name=_method]').val('PATCH');
            $('#modal-form form')[0].reset();
            $.ajax({
                url : "{{ $base_url . '/' }}" + id + "/edit",
                type : "GET",
                dataType : "JSON",
                success : function(data){
                    $('#modal-form').modal('show');
                    $('.modal-title').text('Edit Category');

                    $('#id').val(data.id);
                    $('#category').val(data.category);
                },
                error : function() {
                    alert("Nothing Data");
                }
            });
        }

        function deleteData(id){
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then(function () {
                $.ajax({
                    url : "{{ $base_url . '/' }}" + id,
                    type : "POST",
                    data : {'_method' : 'DELETE', '_token' : $('meta[name="csrf-token"]').attr('content')},
                    success : function(data) {
                        table.ajax.reload();
                        swal({
                            title: 'Success!',
                            text: 'Data has been created!',
                            type: 'success',
                            timer: '1500'
                        })
                    },
                    error : function () {
                        swal({
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            type: 'error',
                            timer: '1500'
                        })
                    }
                });
            });
        }

    </script>
@endsection