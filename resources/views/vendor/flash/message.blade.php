@foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ])
    @else
        <div class="Huialert
        Huialert-{{ $message['level'] }}
                    {{ $message['important'] ? 'alert-important' : '' }}"
                    role="alert"
        >
                <i class="Hui-iconfont">&#xe6a6;</i>

            {!! $message['message'] !!}
        </div>
    @endif
@endforeach

{{ session()->forget('flash_notification') }}

@if (session('errors'))
@foreach (session('errors')->all() as $error)
<div class="Huialert
        Huialert-danger
                     
                    role="alert"
        >
                <i class="Hui-iconfont">&#xe6a6;</i>

            {!! $error !!}
        </div>
@endforeach
@endif