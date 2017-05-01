@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Accounts</div>
                    <div class="panel-body">
                        <a href="{{ url('/a/accounts/create') }}" class="btn btn-success btn-sm" title="Add New Account">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>
                        
                        <form style="display: inline;" action="/a/accounts/upload" method="post" enctype="multipart/form-data" id="upload_form">
                            {{csrf_field()}}
                            <label class="btn btn-default btn-file btn-sm">
                                <i class="fa fa-arrow-up" aria-hidden="true"></i> Upload <input name="accounts_file" type="file" style="display: none;">
                            </label> &nbsp; <span class="file-name"></span>
                        </form>

                        {!! Form::open(['method' => 'GET', 'url' => '/a/accounts', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th><th>Ig Username</th><th>Followers</th><th>Followings</th>
                                        <th>Added on</th> <th>Updated on</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($accounts as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->ig_username }}</td><td><b> {{count($item->followers)}}</b><br> </td><td><b> {{count($item->followings)}}</b><br> </td>
                                        <td>{{$item->created_at}}</td>
                                        <td>{{$item->updated_at}}</td>
                                        <td>
                                            <a href="{{ url('/a/accounts/' . $item->id) }}" title="View Account"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/a/accounts', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete Account',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $accounts->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
    $('input[type="file"]').change(function(e){

        var fileName = e.target.files[0].name;
        // $(e.target).parent().next().html(fileName)
        // alert('The file "' + fileName +  '" has been selected.');
        $('#upload_form').submit();
    })
</script>
@endsection
