@extends('layouts.master')

@section('title')
    Add Page
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Add Contact</strong>
        </div>
        <form action="{{ route('contacts.store') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="panel-body">
                <div class="form-horizontal">
                    <div class="row">
                        <div class="col-md-8">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $e)
                                        <ul>
                                            <li>{{ $e }}</li>
                                        </ul>
                                    @endforeach
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="name" class="control-label col-md-3">Name</label>
                                <div class="col-md-8">
                                    <input type="text" name="name" id="name" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="company" class="control-label col-md-3">Company</label>
                                <div class="col-md-8">
                                    <input type="text" name="company" id="company" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="control-label col-md-3">Email</label>
                                <div class="col-md-8">
                                    <input type="text" name="email" id="email" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone" class="control-label col-md-3">Phone</label>
                                <div class="col-md-8">
                                    <input type="text" name="phone" id="phone" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="control-label col-md-3">Address</label>
                                <div class="col-md-8">
                                    <textarea name="address" id="address" rows="3" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="group" class="control-label col-md-3">Group</label>
                                <div class="col-md-5">
                                    <select name="group" id="group" class="form-control">
                                        @foreach ($groups as $group)
                                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <a href="#" id="add-group-btn" class="btn btn-default btn-block">Add Group</a>
                                </div>
                            </div>
                            <div class="form-group" id="add-new-group">
                                <div class="col-md-offset-3 col-md-8">
                                    <div class="input-group">
                                        <input type="text" name="new_group" id="add_new_group_field" class="form-control">
                                        <span class="input-group-btn">
                                            <button type="button" id="add_new_group_button" class="btn btn-default">
                                                <i class="glyphicon glyphicon-ok"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                                    <img src="http://placehold.it/100x100" alt="Photo">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                <div class="text-center">
                                    <span class="btn btn-default btn-file"><span class="fileinput-new">Choose Photo</span><span class="fileinput-exists">Change</span><input type="file" name="photo"></span>
                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-6">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="#" class="btn btn-default">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection


@section('scripts')
    <script>
    $("#add-new-group").hide();
    $('#add-group-btn').click(function () {
        $("#add-new-group").slideToggle(function() {
            $('#new_group').focus();
        });
        return false;
    });
    var token = '{{ Session::token()  }}';
    var url = '{{ route('groups.store') }}';
    var newGroup = $('#add_new_group_field');
    var inputGroup = newGroup.closest('.input-group');
    $('#add_new_group_button').click(function(event) {
        $.ajax({
            method: 'POST',
            url: url,
            data: {
                name: $('#add_new_group_field').val(),
                _token: token,
            },
            // if the request successed will perform
            success: function (response) {
                if ( response != null ) {
                    inputGroup.removeClass('has-error');
                    inputGroup.next('.text-danger').remove();
                    $('select[name=group]').append('<option value=' + response['id'] + ' selected>' + response['name'] + '</option>');
                    newGroup.val("");
                    $("#add-new-group").slideToggle();
                }
            },
            // if the request has error will perform
            error: function (xhr) {
                var errors = xhr.responseJSON; // this varisble contains the json errors
                var error = errors.name[0]; // this variable contains the array with indexes
                if (error) {
                    // to prevent the dublication of the error messages will remove the old one
                    inputGroup.next('.text-danger').remove();
                    // the show the new err msg
                    inputGroup.addClass('has-error').after('<p class="text-danger">' + error + '</p>');
                }
            },
        });
    });
    </script>
@endsection
