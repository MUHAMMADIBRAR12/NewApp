<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Update Role') }}
        </h2>
    </x-slot>   
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl mx-auto"> 
                    <header class="mb-6"> 
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Roles Information') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __("Update your Roles information.") }}
                        </p>
                    </header>

                    <form method="POST" action="{{ route('role.update', $role->id) }}" class="space-y-6"> 
                        @csrf
                        @method('PUT')
                        
                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name', $role->name) }}" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <!-- Update Button -->
                        <div class="flex justify-start mt-4"> 
                            <x-primary-button>
                                {{ __('Update') }}
                            </x-primary-button>
                            
                            <a href="{{ route('role.index') }}" 
                            class="inline-block bg-gray-500 text-white font-semibold py-2 px-4 rounded-md shadow-md hover:bg-gray-600 ml-4">
                             {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
