<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Permissions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-4xl mx-auto">
                    <h1 class="text-lg font-medium text-gray-900 dark:text-gray-100 text-center">
                        {{ __('Permissions LIST') }}
                    </h1>
                    
                    <!-- Add New Item Button -->
                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ms-4">
                            <a href="{{ route('permission.create') }}" 
                            class="inline-block bg-blue-500 text-white font-semibold py-2 px-6 rounded-md shadow-md hover:bg-blue-600">
                             {{ __('Add Permission') }}
                         </a>
                        </x-primary-button>
                    </div> 
                    @if ($permissions->isEmpty())
                        <p class="text-center text-gray-600 mt-6">{{ __('No Items found.') }}</p>
                    @else
                        <!-- Table -->
                        <table class="w-full mt-6 text-center border-collapse border border-gray-300 rounded-lg shadow-lg">
                            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                <tr>
                                    <th class="px-6 py-4 text-sm font-semibold border-b border-gray-300">
                                        {{ __('ID') }}
                                    </th>
                                    <th class="px-6 py-4 text-sm font-semibold border-b border-gray-300">
                                        {{ __('Name') }}
                                    </th>
                                    <th class="px-6 py-4 text-sm font-semibold border-b border-gray-300 text-center">
                                        {{ __('Actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                    <tr class="border-b">
                                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                            {{ $permission->id }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                            {{ $permission->name }}
                                        </td>
                                        <td class="px-6 py-4 text-center space-x-2">
                                            <!-- Edit Button -->
                                            <div class="flex items-center justify-center mt-4 mb-4">
                                                <a href="{{ route('permission.edit', $permission->id) }}" 
                                                   class="inline-block bg-gray-800 text-white font-semibold py-1 px-3 text-sm rounded-md shadow-md hover:bg-gray-900">
                                                    {{ __('Edit') }}
                                                </a>
                                            </div>                                                                                      
                                            <!-- Delete Button -->
                                            <form action="{{ route('permission.destroy', $permission->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="bg-red-500 text-white font-semibold py-1 px-3 text-sm rounded-md shadow-md hover:bg-red-600"
                                                        onclick="return confirm('{{ __('Are you sure?') }}')">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
