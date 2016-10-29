@extends('layouts.master')

@section('title')
    Edit Page
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Edit Contact</strong>
        </div>
        <form action="{{ route('update.contact', ['id' => $contact->id]) }}" method="post" enctype="multipart/form-data">
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
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $contact->name }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="company" class="control-label col-md-3">Company</label>
                                <div class="col-md-8">
                                    <input type="text" name="company" id="company" class="form-control" value="{{ $contact->company }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="control-label col-md-3">Email</label>
                                <div class="col-md-8">
                                    <input type="text" name="email" id="email" class="form-control" value="{{ $contact->email }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone" class="control-label col-md-3">Phone</label>
                                <div class="col-md-8">
                                    <input type="text" name="phone" id="phone" class="form-control" value="{{ $contact->phone }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="control-label col-md-3">Address</label>
                                <div class="col-md-8">
                                    <textarea name="address" id="address" rows="3" class="form-control">{{ $contact->address }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="group" class="control-label col-md-3">Group</label>
                                <div class="col-md-8">
                                    <select name="group" id="group" class="form-control">
                                        <option value="">Select group</option>
                                        @foreach ($groups as $group)
                                            <option value="{{ $group->id }}" {{ $contact->group_id == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                                    <img style="width: 100%;height: 100%;" src="{{ asset($contact->photo) }}" alt="Photo">
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
