@if($errors->any())
    <div class="alert alert-danger {{ config('app.locale') == 'fa' ? 'tar' : 'tal' }}">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
