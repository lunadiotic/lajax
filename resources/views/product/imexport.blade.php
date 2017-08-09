@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Import/Export Product</h4>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('product.import') }}" method="post" class="form-horizontal", enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="file" class="col-md-3 control-label">File Import</label>
                                <div class="col-md-3">
                                    <input type="file" id="file" name="file" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-3 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('product.export') }}" class="btn btn-success">Export</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection