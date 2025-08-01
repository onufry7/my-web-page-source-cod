<aside class="relative overflow-hidden w-full"
    x-data="marquee()"
    x-init="startAnimation()"
    x-on:mouseenter="pauseAnimation()"
    x-on:mouseleave="resumeAnimation()"
>
    @if($aphorism)
        <blockquote class="inline-block whitespace-nowrap transition-none text-xs leading-none cursor-default"
            x-ref="text"
            :style="{ transform: `translateX(${position}px)` }"
        >
            {{ $aphorism->sentence }}
            @if ($aphorism->author)
                <cite>- {{ $aphorism->author }}</cite>
            @endif
        </blockquote>
    @endif
</aside>
