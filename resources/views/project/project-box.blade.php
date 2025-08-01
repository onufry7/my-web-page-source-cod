<article class="box-tile border-accent-project shadow-accent-project">

    <div>
        <a class="block" href="{{ route('project.show', $project) }}">
            <div class="box-tile-img border-accent-project">
                <div class="pin-btn bg-white dark:bg-black absolute bottom-0 right-0 z-10 overflow-hidden p-1">
                    <x-project.category-icon data-category="{{ $project->category }}" class="size-6" />
                </div>
                <x-image-bar :image="$project->image_path" noImage="images/project-no-image.webp"
                    alt="{{ __('Project image') }}" imgClass="image-bar-responsive" />
            </div>

            <h3 class="border-accent-project">
                {{ Str::title($project->name) }}
            </h3>
        </a>

        <p class="line-clamp-3 px-6 py-2 overflow-hidden">
            {{ $project->description }}
        </p>
    </div>


    <footer>
        <a href="{{ route('project.show', $project) }}">
            {{ __('More') }} >>
        </a>
    </footer>

</article>
