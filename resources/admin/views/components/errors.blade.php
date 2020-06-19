@error($name)
@foreach($errors->get($name) as $error)
    <span class="invalid-feedback {{isset($center)?'text-center':'text-left'}} d-block"
          role="alert">{{ $error }}</span>
@endforeach
@enderror
