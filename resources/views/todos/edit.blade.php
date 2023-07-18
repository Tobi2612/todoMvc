<!DOCTYPE html>
<html>

<head>
    <title>Todo</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">

        <nav class="navbar navbar-inverse">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ URL::to('todos') }}">Todo</a>
            </div>
        </nav>

        <h1>Edit {{ $todo->name}}</h1>

        <!-- if there are creation errors, they will show here -->
        {{ Html::ul($errors->all()) }}

        {{ Form::model($todo, array('route' => array('todos.update', $todo->_id), 'method' => 'PUT')) }}

        <div class="form-group">
            {{ Form::hidden('id', $todo->_id) }}
            {{ Form::label('name', 'Item') }}
            {{ Form::text('name', null, array('class' => 'form-control')) }}
        </div>



        {{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}

        {{ Form::close() }}

    </div>
</body>

</html>