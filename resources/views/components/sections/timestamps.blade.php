@props(['model'])

<section class="timestamps">
    <span> {{ __('Created') . ': ' . $model->created_at->format('d-m-Y | H:m:i') }} </span>
    <span> {{ __('Updated') . ': ' . $model->updated_at->format('d-m-Y | H:m:i') }} </span>
</section>
