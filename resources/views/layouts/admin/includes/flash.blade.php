@foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @php
        $icons = ['danger' => 'ban', 'warning' => 'exclamation-triangle', 'success' => 'check', 'info' => 'info']
    @endphp
    @if(Session::has('alert-' . $msg))
        <div class="alert alert-{{ $msg }} alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-{{ $icons[$msg] }}"></i> Alert!</h5>
            {{ Session::get('alert-' . $msg) }}
        </div>
    @endif
@endforeach