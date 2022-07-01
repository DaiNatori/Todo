@section('tab-header')
<div>
 <ul class="nav nav-tabs card-header-tabs">
      <li class="nav-item">
          <a class="nav-link {{ ($tabindex ?? "" ) == 1 ? 'active':''  }}" name="tab-ready" href="{{ route('tasklist',['tabindex' => 1]) }}">未着手</a>
      </li>
      <li class="nav-item">
          <a class="nav-link {{ ($tabindex ?? "" ) == 2 ? 'active':''  }}" name="tab-doing" href="{{ route('tasklist',['tabindex' => 2]) }}">着手中</a>
      </li>
      <li class="nav-item">
          <a class="nav-link {{ ($tabindex ?? "" ) == 3 ? 'active':''  }}" name="tab-done" href="{{ route('tasklist',['tabindex' => 3]) }}">完了</a>
      </li>
      <li class="nav-item">
          <a class="nav-link {{ ($tabindex ?? "" ) == 4 ? 'active':''  }}" name="tab-notready" href="{{ route('tasklist',['tabindex' => 4]) }}" >延期</a>
      </li>
  </ul>
  </div>
@endsection