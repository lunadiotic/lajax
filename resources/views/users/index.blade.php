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
                        <table id="users-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created At</th>
                                    <th>Update At</th>
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

    {{--@include('category.form')--}}
@endsection

@section('scripts')
    <script type="text/javascript">
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('api.user.data') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
@endsection