@use('App\Enums\UserRole')

<x-app-layout>

    <x-slot name="header">
        {{ __('Users') }}
    </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-rpg-wooden-sign/> {{ __('Users list') }} <span>({{ $users->total() }})</span> </h2>
    </x-slot>

    @if ($users->isEmpty())
        <x-no-data> {{ __('No users') }}. </x-no-data>
    @else
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="default-table">
                <thead>
                    <tr>
                        <th scope="col">
                            <span class="show-icon">
                                {{ __('User name') }} <x-icon-eye />
                            </span>
                        </th>
                        <th scope="col">
                            {{ __('User nick') }}
                        </th>
                        <th scope="col">
                            {{ __('Permissions') }}
                        </th>
                        <th class="actions" scope="col">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                        @php $textClass = $user->role === UserRole::Admin->value ? '!text-rose-600 dark:!text-rose-400' : ''; @endphp

                        <tr>
                            <th class="{{ $textClass }}" scope="row">
                                <a class="block" href="{{ route('user.show', $user) }}" title="{{ __('Show') }}"> {{ $user->name }} </a>
                            </th>
                            <th class="{{ $textClass }}" scope="row">
                                {{ $user->nick }}
                            </th>
                            <th class="{{ $textClass }}" scope="row">
                                {{ __($user->getNameRole()) }}
                            </th>
                            <td class="actions">
                                <span>
                                    <x-forms.delete id="delete-{{ $user->id }}" :withTextDelete="false" content="{{ __('User') . ': ' . $user->name }}"
                                        action="{{ route('user.destroy', $user) }}" />
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="pagination-links">
        {{ $users->withQueryString()->links() }}
    </div>

    <x-sections.action-footer>
        <x-buttons.backward href="{{ route('admin.dashboard') }}">
            {{ __('To Dashboard') }}
        </x-buttons.backward>
    </x-sections.action-footer>

</x-app-layout>
