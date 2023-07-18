<!DOCTYPE html>
<html>

<head>
    <title>Todos</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">

        <nav class="navbar navbar-inverse">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ URL::to('todos') }}">Todo</a>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="pull-right navbar-brand">
                @csrf

                <a :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                    {{ __('Log Out') }}
                </a>
            </form>
        </nav>

        <a class="btn btn-small btn-success" href="{{ URL::to('todos/create') }}">Create Todo</a><br />
        <h1>Todo List</h1>

        <!-- will be used to show any messages -->
        @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Item</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                @foreach($todo->data as $key => $value)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $value-> name }}</td>


                    <td>

                        <!-- show the todo (uses the show method found at GET /todo/{id} -->
                        <a class="btn btn-small btn-primary" href="{{ URL::to('todos/' . $value->_id) }}">View</a>

                        <!-- edit this todo (uses the edit method found at GET /todo/{id}/edit -->
                        <a class="btn btn-small btn-primary" href="{{ URL::to('todos/' . $value->_id . '/edit') }}">Edit</a>
                        {{ Form::open(array('url' => 'todos/' . $value->_id, 'class' => 'pull-right')) }}
                        {{ Form::hidden('_method', 'DELETE') }}
                        {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}


                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
        </div>

    </div>
</body>

</html>