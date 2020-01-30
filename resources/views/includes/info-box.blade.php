@if (Session::has('fail'))
	<section class="alert alert-warning">
		{{ Session::get('fail') }}
	</section>
@endif

@if (Session::has('success'))
	<section class="alert alert-primary">
		{{ Session::get('success') }}
	</section>
@endif

@if(count($errors) > 0)
	<section class="alert alert-danger">
    <ul class="list-group">
      @foreach($errors->all() as $error)
        <li class="list-group-item">{{ $error }}</li>
      @endforeach
    </ul>
	</section>
@endif