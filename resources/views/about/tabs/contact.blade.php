<h3 class="py-4 text-center">{{ __('Contact form') }}</h3>

<form class="lg:max-w-1/2 mx-auto" action="{{ route('contact.submit') }}" method="post">

	@csrf

	<input class="hidden" id="firstname" name="firstname" type="text" value="" autocomplete="off" />

	<div>
		<label for="email">{{ __('Your email') }}:</label>
		<input class="w-full" id="email" name="email" type="email" value="{{ old('email', '') }}" required />
		<x-forms.input-error for="email" />
	</div>

	<div>
		<label for="message">{{ __('Your message') }}:</label>
		<textarea class="w-full" id="message" name="message" rows="8" maxlength="4500" required>{{ old('message', '') }}</textarea>
		<x-forms.input-error for="message" />
	</div>

	<div class="my-4 text-center">
		<button type="submit" class="btn primary">
            <x-icon-send-mail /> {{ __('Send') }}
		</button>
	</div>

</form>
