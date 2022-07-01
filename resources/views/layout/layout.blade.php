<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Todo</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }
    </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
      <div class="container-fluid">
          <a class="navbar-brand" href="/">TODO</a>

      </div>
      </div>
  </nav>

  <div class="container">
      <div class="row">
          <main class="col-md-12 col-lg-12">
              <div class="mb-3">
                    @yield('newbutton')
              </div>
              <div class="card">
                  <div class="card-header d-flex justify-content-between">
                      @yield('tab-header')
                  </div>
                  <div class="card-body">
                      @yield('content')
                  </div>
              </div>
          </main>
      </div>
  </div>

</body>

</html>