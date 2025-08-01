<x-app-layout>

	<x-slot name="header">
		{{ __('Files') }}
	</x-slot>

	<x-slot name="pageHeader">
		<h2> <x-icon-page /> {{ $file->name }} </h2>
	</x-slot>

	<div class="dataRow">
        <p>
            {{ __('File') }}: <span>{{ $file->getNameWithModelName() }}</span>
        </p>

        <p>
            {{ __('File name') }}: <span>{{ $file->name }}</span>
        </p>

		<p>
			{{ __('Related entry') }}:
			<a class="link" href="{{ route(Str::snake(class_basename($file->model_type), '-') . '.show', $file->model) }}">
				{{ $file->model->name }}
			</a>
		</p>

		<p>
			{{ __('Files list related entry') }}:
			<a class="link" href="{{ route(Str::snake(class_basename($file->model_type), '-') . '.files', $file->model) }}">
				{{ __('Files') }}
			</a>
		</p>

        <p class="mt-4">
            {{ __('Model') }}: <span>{{ Str::afterLast($file->model_type, '\\') }}</span>
        </p>

        <p>
            {{ __('ID related entry') }}: <span>{{ $file->model_id }}</span>
        </p>

        <x-sections.timestamps :model="$file" />
	</div>

	<x-sections.action-footer>
		<div class="flex flex-wrap justify-center">
            <x-buttons.backward href="{{ route('file.index') }}">
                {{ __('To files list') }}
            </x-buttons.backward>
        </div>

        <div class="flex flex-wrap justify-center gap-8">
            <x-buttons.download href="{{ route('file.download', $file) }}">
                {{ __('Download') }}
            </x-buttons.download>

            <x-buttons.edit href="{{ route('file.edit', $file) }}">
                {{ __('Edit') }}
            </x-buttons.edit>

            <x-forms.delete action="{{ route('file.destroy', $file) }}" content="{{ __('File') }}: {{ $file->name }}" />
        </div>
	</x-sections.action-footer>

</x-app-layout>
