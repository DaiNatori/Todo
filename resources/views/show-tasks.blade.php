<html>
    <head>
        <title>show task</title>
    </head>
    <body>
      @foreach ($tasks as $task)
          <p> {{ $task->id }} - {{ $task->title }}</p>
      @endforeach
    </body>
</html>
