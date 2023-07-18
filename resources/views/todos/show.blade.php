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

        <h1>List Item</h1>

        <div class="jumbotron text-center">
            <p>
                <strong>Item:</strong> {{ $todo->name }}<br>
            </p>
        </div>

    </div>
</body>

</html>