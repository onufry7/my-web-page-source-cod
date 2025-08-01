<x-app-layout>

    <x-slot name="header">
        {{ __('Access tokens') }}
    </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-rpg-wooden-sign/> {{ __('Access tokens list') }} <span>({{ $accessTokens->total() }})</span> </h2>
        <x-buttons.create href="{{ route('access-token.create') }}">
            {{ __('Add') }}
        </x-buttons.create>
    </x-slot>

    @if ($accessTokens->isEmpty())
        <x-no-data> {{ __('No access tokens') }}. </x-no-data>
    @else
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="default-table">
                <thead>
                    <tr>
                        <th scope="col">
                            <span class="show-icon">
                                {{ __('Token') }} <x-icon-eye />
                            </span>
                        </th>
                        <th class="text-center" scope="col">
                            {{ __('Active') }}
                        </th>
                        <th scope="col">
                            {{ __('Email') }}
                        </th>
                        <th class="actions" scope="col">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($accessTokens as $key => $accessToken)
                        <tr>
                            <th scope="row">
                                <a class="block" href="{{ route('access-token.show', $accessToken) }}" title="{{ __('Show') }}">
                                    {{ $accessToken->token }}
                                </a>
                            </th>
                            <td>
                                @php $isActive = $accessToken->isActive(); @endphp
                                <x-dynamic-component class="{{ $isActive ? 'text-green-800' : 'text-red-800' }} h-8 w-auto m-auto"
                                    alt="{{ $isActive ? __('Yes') : __('No') }}"
                                    title="{{ $isActive ? __('Active') : __('Inactive') }}"
                                    component="{{ $isActive ? 'icon-confirm' : 'icon-cancel' }}" />
                            </td>
                            <td>
                                {{ $accessToken->email }}
                            </td>
                            <td class="actions">
                                <span>
                                    <x-buttons.edit href="{{ route('access-token.edit', $accessToken) }}" />
                                    <x-forms.delete id="delete-{{ $accessToken->id }}" :withTextDelete="false"
                                    content="{{ $accessToken->name }}" action="{{ route('access-token.destroy', $accessToken) }}" />
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="pagination-links">
        {{ $accessTokens->withQueryString()->links() }}
    </div>

    <x-sections.action-footer>
        <x-buttons.backward href="{{ route('admin.dashboard') }}">
            {{ __('To Dashboard') }}
        </x-buttons.backward>
    </x-sections.action-footer>

</x-app-layout>
