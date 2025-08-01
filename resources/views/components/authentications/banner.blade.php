@props(['hasErrors' => $errors->any(), 'status' => session('status')])

@if ($hasErrors || ($status && $status !== 'verification-link-sent'))
    @php
        $message = $hasErrors ? $errors->first() : $status;
        $class = $hasErrors ? 'bg-danger' : 'bg-success';
    @endphp

    <div class="mt-4 mb-6 text-sm font-normal p-2 rounded-md text-white {{ $class }}">
        {{ $message }}
    </div>
@endif

