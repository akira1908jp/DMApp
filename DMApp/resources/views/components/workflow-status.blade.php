@props(['label', 'status'])

@if($status == (\App\States\Rejected::$name))
<span class='font-medium text-xl text-red-500'>
    {{ $label ?? $slot }}
</span>
@endif
@if ($status == (\App\States\Draft::$name))
<span class='font-medium text-xl text-gray-500'>
    {{ $label ?? $slot }}
</span>
@endif
@if ($status == (\App\States\PendingAdmin::$name))
<span class='font-medium text-xl text-orange-500'>
    {{ $label ?? $slot }}
</span>
@endif
@if($status == (\App\States\PendingHeadquarters::$name))
<span class='font-medium text-xl text-orange-500'>
    {{ $label ?? $slot }}
</span>
@endif
@if ($status == (\App\States\Approved::$name))
<span class='font-medium text-xl text-green-500'>
    {{ $label ?? $slot }}
</span>
@endif