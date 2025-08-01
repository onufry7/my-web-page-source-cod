@props(['size' => 'h-[1px]'])

<hr {{ $attributes->merge(['class' => "bg-$accentColor border-none rounded-full $size"]) }} />
