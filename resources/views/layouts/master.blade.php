<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>@yield('title')</title>

    <!-- Bootstrap -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/jasny-bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('jquery-ui/jquery-ui.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/custom.css')}}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <!-- navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand text-uppercase" href="{{ url('/') }}">
                    My contact
                </a>
            </div>
            <!-- /.navbar-header -->
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <div class="nav navbar-right navbar-btn">
                    <a href="{{ route('contacts.create') }}" class="btn btn-default">
                        <i class="glyphicon glyphicon-plus"></i>
                        Add Contact
                    </a>
                </div>
                <form action="{{ route('contacts.index') }}" class="navbar-form navbar-right">
                    <div class="input-group">
                        <input type="text" name="term" value="{{ Request::get('term') }}" id="Search" class="form-control" placeholder="Search..." autocomplete="off">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </nav>

    <!-- content -->
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group" id="side_bar">
                    <?php $selected = Request::get('groupid') ?>
                    <a href="{{ route('contacts.index') }}" class="list-group-item {{ empty($selected) ? 'active' : '' }}">All Contact <span class="badge">{{count(App\Contact::all())}}</span></a>
                    @foreach (App\Group::all() as $group)
                        <a href="{{ route('contacts.index', ['groupid' => $group->id]) }}" class="list-group-item {{ $selected == $group->id ? 'active' : '' }}">{{ $group->name }} <span class="badge">{{ count($group->contacts) }}</span></a>
                    @endforeach
                </div>
            </div><!-- /.col-md-3 -->

            <div class="col-md-9">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/jasny-bootstrap.min.js')}}"></script>
    <script src="{{asset('jquery-ui/jquery-ui.min.js')}}"></script>
    <script>
        $(function() {
            $("input[name=term]").autocomplete({
                source: "{{ route('contacts.autocomplete') }}",
                minLength: 3,
                select: function(event, ui) {
                    $(this).val(ui.item.value);
                }
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
