@if ($boardGame->instruction)
    <a class="btn-game instruction-game group" href="{{ route('board-game.download-instruction', $boardGame) }}" title="{{ __('Instruction') }}">
        <div class="relative">
            <span class="label-name">{{ __('Instruction') }}</span>
            <span class="label-download">{{ __('Download') }}</span>
        </div>
        <x-icon-arrow-down-tray class="icon-hover" />
        <x-rpg-book class="icon-default" />
        <span class="label-size">({{ $boardGame->getInstructionSize() }})</span>
    </a>
@endif

@if ($boardGame->files->count() > 0)
    <div class="flex flex-row flex-wrap items-center gap-8">
        @foreach ($boardGame->files as $file)
            <a class="btn-game file-game group" href="{{ route('file.download', $file) }}" title="{{ $file->name }}">
                <div class="relative">
                    <span class="label-name">{{ Str::limit($file->name, 26) }}</span>
                    <span class="label-download">{{ __('Download') }}</span>
                </div>
                <x-icon-arrow-down-tray class="icon-hover" />
                <x-icon-post class="icon-default" />
                <span class="label-size">({{ $file->getSize(inMB: true) }})</span>
            </a>
        @endforeach
    </div>
@endif
