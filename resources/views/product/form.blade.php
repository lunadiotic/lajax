<div class="modal" id="modal-form" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" class="form-horizontal" data-toggle="validator">
                {{ csrf_field() }} {{ method_field('post') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> &times; </span>
                    </button>
                    <h3 class="modal-title"></h3>
                </div>

                <div class="modal-body">

                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="barcode" class="col-md-3 control-label">Barcode</label>
                        <div class="col-md-6">
                            <input type="text" name="barcode" id="barcode" class="form-control" autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="product" class="col-md-3 control-label">Product</label>
                        <div class="col-md-6">
                            <input type="text" name="product" id="product" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="category" class="col-md-3 control-label">Category</label>
                        <div class="col-md-6">
                            <select name="category_id" id="category_id" class="form-control">
                                @foreach($category as $data)
                                    <option value="{{ $data->id }}">{{ $data->category }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="price" class="col-md-3 control-label">Price</label>
                        <div class="col-md-3">
                            <input type="number" name="price" id="price" class="form-control" autofocus>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-save">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>

            </form>
        </div>
    </div>
</div>