@foreach (Auth::user()->unreadNotifications as $notification)
    <div class="notification-item">
        <a href='{{ route('documents.index') }}'>{{ $notification->data['message'] }}</a>

        <a href="{{ route('notifications.read', $notification->id) }}">既読にする</a>
    </div>
@endforeach