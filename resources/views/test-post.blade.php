<html lang="ja">
    <head>
        <title>test post</title>
    </head>
    <body>
        <form method="POST" action="{{route('sendname')}}">
        @csrf
            <div>
                name:
                <input name="name" type="text" placeholder="Text input" >
            </div>
            <div>
                <button>Submit</button>
            </div>
        </form>
    </body>
</html>
