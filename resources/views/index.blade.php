@extends('layouts.master')

@section('title')
    homepage
@endsection

@section('content')
    <div class="panel panel-default">
        @if (Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}</div>
        @endif
        <table class="table">
            @foreach ($contacts as $contact)
                <tr>
                    <td class="middle">
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object" src="{{!empty($contact->photo) && $contact->photo != 'http://placehold.it/100x100'  ? asset($contact->photo) : $contact->photo}}" alt="...">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">{{ $contact->name }}</h4>
                                <address>
                                    <strong>{{ $contact->company }}</strong><br>
                                    {{ $contact->email }}
                                </address>
                            </div>
                        </div>
                    </td>
                    <td width="100" class="middle">
                        <div>
                            <a href="{{ route('contacts.edit', ['id' => $contact->id]) }}" class="btn btn-circle btn-default btn-xs" title="Edit">
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>
                            <a href="{{ route('delete.contact', ['id' => $contact->id]) }}" class="btn btn-circle btn-danger btn-xs" title="Delete">
                                <i class="glyphicon glyphicon-remove"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="text-center">
        <nav>
            {!! $contacts->appends(Request::query())->render() !!}
        </nav>
    </div>
@endsection
