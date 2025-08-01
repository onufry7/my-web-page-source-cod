@use('Laravel\Jetstream\Jetstream')

<div>
	<!-- Generate API Token -->
	<x-forms.section submit="createApiToken">
		<x-slot name="title">
			{{ __('Create API Token') }}
		</x-slot>

		<x-slot name="description">
			{{ __('API tokens allow third-party services to authenticate with our application on your behalf.') }}
		</x-slot>

		<x-slot name="form">
			<!-- Token Name -->
			<div class="col-span-6 sm:col-span-4">
				<label for="name">{{ __('Token Name') }}</label>
				<input class="mt-1 block w-full" id="name" type="text" wire:model="createApiTokenForm.name" autofocus />
				<x-forms.input-error class="mt-2" for="name" />
			</div>

			<!-- Token Permissions -->
			@if (Jetstream::hasPermissions())
				<div class="col-span-6">
					<label for="permissions">{{ __('Permissions') }}</label>

					<div class="mt-2 grid grid-cols-1 gap-4 md:grid-cols-2">
						@foreach (Jetstream::$permissions as $permission)
							<label class="flex items-center">
								<input type="checkbox" wire:model="createApiTokenForm.permissions" :value="$permission" />
								<span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ $permission }}</span>
							</label>
						@endforeach
					</div>
				</div>
			@endif
		</x-slot>

		<x-slot name="actions">
			<x-actions.message on="created">
				{{ __('Created.') }}
			</x-actions.message>

			<button class="btn primary" type="submit">
				{{ __('Create') }}
			</button>
		</x-slot>
	</x-forms.section>

	@if ($this->user->tokens->isNotEmpty())
		<x-sections.border />

		<!-- Manage API Tokens -->
		<div class="mt-10 sm:mt-0">
			<x-actions.section>
				<x-slot name="title">
					{{ __('Manage API Tokens') }}
				</x-slot>

				<x-slot name="description">
					{{ __('You may delete any of your existing tokens if they are no longer needed.') }}
				</x-slot>

				<!-- API Token List -->
				<x-slot name="content">
					<div class="space-y-6">
						@foreach ($this->user->tokens->sortBy('name') as $token)
							<div class="flex items-center justify-between">
								<div class="break-all dark:text-white">
									{{ $token->name }}
								</div>

								<div class="ml-2 flex items-center gap-6">
									@if ($token->last_used_at)
										<div class="text-sm text-gray-400">
											{{ __('Last used') }} {{ $token->last_used_at->diffForHumans() }}
										</div>
									@endif

									@if (Jetstream::hasPermissions())
										<button class="cursor-pointer text-sm text-gray-400 underline" wire:click="manageApiTokenPermissions({{ $token->id }})">
											{{ __('Permissions') }}
										</button>
									@endif

									<button class="cursor-pointer text-sm text-red-500" wire:click="confirmApiTokenDeletion({{ $token->id }})">
										{{ __('Delete') }}
									</button>
								</div>
							</div>
						@endforeach
					</div>
				</x-slot>
			</x-actions.section>
		</div>
	@endif

	<!-- Token Value Modal -->
	<x-popups.dialog-modal wire:model.live="displayingToken">
		<x-slot name="title">
			{{ __('API Token') }}
		</x-slot>

		<x-slot name="content">
			<div>
				{{ __('Please copy your new API token. For your security, it won\'t be shown again.') }}
			</div>

			<input class="mt-4 w-full break-all rounded bg-gray-100 px-4 py-2 font-mono text-sm text-gray-500" type="text" x-ref="plaintextToken" readonly :value="$plainTextToken" autofocus autocomplete="off" autocorrect="off" autocapitalize="off"
				spellcheck="false" @showing-token-modal.window="setTimeout(() => $refs.plaintextToken.select(), 250)" />
		</x-slot>

		<x-slot name="footer">
			<button class="btn warning" type="button" wire:click="$set('displayingToken', false)" wire:loading.attr="disabled">
				{{ __('Close') }}
			</button>
		</x-slot>
	</x-popups.dialog-modal>

	<!-- API Token Permissions Modal -->
	<x-popups.dialog-modal wire:model.live="managingApiTokenPermissions">
		<x-slot name="title">
			{{ __('API Token Permissions') }}
		</x-slot>

		<x-slot name="content">
			<div class="grid grid-cols-1 gap-4 md:grid-cols-2">
				@foreach (Jetstream::$permissions as $permission)
					<label class="flex items-center">
						<input type="checkbox" wire:model="updateApiTokenForm.permissions" :value="$permission" />
						<span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ $permission }}</span>
					</label>
				@endforeach
			</div>
		</x-slot>

		<x-slot name="footer">
			<x-buttons.cancel type="button" wire:click="$set('managingApiTokenPermissions', false)" wire:loading.attr="disabled">
				{{ __('Cancel') }}
			</x-buttons.cancel>

			<x-buttons.save type="button" wire:click="updateApiToken" wire:loading.attr="disabled">
				{{ __('Save') }}
			</x-buttons.save>
		</x-slot>
	</x-popups.dialog-modal>

	<!-- Delete Token Confirmation Modal -->
	<x-popups.confirmation-modal wire:model.live="confirmingApiTokenDeletion">
		<x-slot name="title">
			{{ __('Delete API Token') }}
		</x-slot>

		<x-slot name="content">
			{{ __('Are you sure you would like to delete this API token?') }}
		</x-slot>

		<x-slot name="footer">
			<x-buttons.cancel type="button" wire:click="$toggle('confirmingApiTokenDeletion')" wire:loading.attr="disabled">
				{{ __('Cancel') }}
			</x-buttons.cancel>

			<x-buttons.delete type="button" wire:click="deleteApiToken" wire:loading.attr="disabled">
				{{ __('Delete') }}
			</x-buttons.delete>
		</x-slot>
	</x-popups.confirmation-modal>
</div>
