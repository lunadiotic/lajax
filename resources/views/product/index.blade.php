@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>
                            Product List
                            <a onclick="addForm()" class="btn btn-primary pull-right" style="margin-top: -8px;">Add Product</a>
                            <a href="{{ route('product.imexport') }}" class="btn btn-default pull-right" style="margin-top: -8px;">Export/Import</a>
                            <a href="{{ route('product.print') }}" class="btn btn-default pull-right" style="margin-top: -8px;"><i class='glyphicon glyphicon-print'></i> List Product</a>
                            <a href="{{ route('product.print.barcode') }}" class="btn btn-default pull-right" style="margin-top: -8px;"><i class='glyphicon glyphicon-print'></i>  Barcode</a>
                        </h4>
                    </div>
                    <div class="panel-body">
                        <table id="product-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('product.form')
@endsection

@section('scripts')
    <script type="text/javascript">
        var table, save_method;
        table = $('#product-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('api.product.data') }}",
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'product', name: 'product'},
                        {data: 'category', name: 'category'},
                        {data: 'price', name: 'price'},
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
                    $('#barcode').val(data.barcode);
                    $('#product').val(data.product);
                    $('#category_id').val(data.category_id);
                    $('#price').val(data.price);
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