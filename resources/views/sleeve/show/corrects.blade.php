<section class="flex flex-col gap-y-2 px-2 py-4">
    <h3>{{ __('Corrects') }}:</h3>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="default-table">
            <thead>
                <tr>
                    <th scope="col">
                        {{ __('Description') }}
                    </th>
                    <th class="text-center" scope="col">
                        {{ __('Before') }}
                    </th>
                    <th class="text-center" scope="col">
                        {{ __('After') }}
                    </th>
                    <th scope="col">
                        {{ __('Correction date') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($corrects as $key => $correct)
                    <tr>
                        <td>
                            {{ $correct->description ?? '---' }}
                        </td>
                        <td class="text-center">
                            {{ $correct->quantity_before }}
                        </td>
                        <td class="text-center">
                            {{ $correct->quantity_after }}
                        </td>
                        <td class="text-sm">
                            {{ $correct->created_at }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination-links">
        {{ $corrects->withQueryString()->links() }}
    </div>

</section>
