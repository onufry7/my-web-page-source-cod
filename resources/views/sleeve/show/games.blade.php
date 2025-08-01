<section class="flex flex-col gap-y-2 px-2 py-4">
    <h3>{{ __('Used in games') }}:</h3>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="default-table">
            <thead>
                <tr>
                    <th scope="col">
                        {{ __('Game') }}
                    </th>
                    <th scope="col">
                        {{ __('Quantity') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($games as $game)
                    <tr>
                        <td>
                            <a href="{{ route('board-game.show', $game) }}">
                                {{ $game->name }}
                            </a>
                        </td>
                        <td>
                            {{ $game->pivot->quantity ?? 0 }} szt.
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination-links">
        {{ $games->withQueryString()->links() }}
    </div>

</section>
