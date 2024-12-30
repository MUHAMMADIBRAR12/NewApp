<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Roles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-4xl mx-auto">
                    <h1 class="text-lg font-medium text-gray-900 dark:text-gray-100 text-center">
                        {{ __('ROLES LIST') }}
                    </h1>
                    
                    <!-- Add New Item Button -->
                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ms-4">
                            <a href="{{ route('role.create') }}" 
                            class="inline-block bg-blue-500 text-white font-semibold py-2 px-6 rounded-md shadow-md hover:bg-blue-600">
                             {{ __('Add Role') }}
                         </a>
                        </x-primary-button>
                    </div> 
                    @if ($Roles->isEmpty())
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
                                    <th class="px-6 py-4 text-sm font-semibold border-b border-gray-300">
                                        {{ __('Permissions') }}
                                    </th>
                                    <th class="px-6 py-4 text-sm font-semibold border-b border-gray-300 text-center">
                                        {{ __('Actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Roles as $Role)
                                    <tr class="border-b">
                                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                            {{ $Role->id }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                            {{ $Role->name }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                            <button 
                                            class="bg-gray-500 text-white font-semibold py-2 px-4 rounded-md shadow-md hover:bg-gray-600 mr-2"
                                            onclick="openPermissionModal({{ $Role->id }}, '{{ $Role->name }}')">
                                            {{ __('Assign Permissions') }}
                                        </button>
                                        </td>
                                        <td class="px-6 py-4 text-center space-x-2">
                                            <!-- Edit Button -->
                                            <div class="flex items-center justify-center mt-4 mb-4">
                                                <a href="{{ route('role.edit', $Role->id) }}" 
                                                   class="inline-block bg-gray-800 text-white font-semibold py-1 px-3 text-sm rounded-md shadow-md hover:bg-gray-900">
                                                    {{ __('Edit') }}
                                                </a>
                                            </div>                                                                                      
                                            <!-- Delete Button -->
                                            <form action="{{ route('role.destroy', $Role->id) }}" method="POST" class="inline-block">
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

     <!-- Permission Modal -->
     <div id="permissionModal" class="fixed inset-0 flex items-center justify-center z-50 hidden bg-gray-900 bg-opacity-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-96">
            <h2 id="modalRoleName" class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4"></h2>
            <form id="permissionForm" method="POST" action="{{ route('role.assign.permissions') }}">
                @csrf
                <input type="hidden" id="roleId" name="role_id">
                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Permissions') }}</h3>
                    <div id="permissionsList" class="grid grid-cols-1 gap-2">
                        @foreach ($Permissions as $Permission)
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="permissions[]" value="{{ $Permission->name }}">
                                <span class="text-sm text-gray-600 dark:text-gray-300">{{ $Permission->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="flex items-center justify-end">
                    <button type="button" 
                            onclick="closePermissionModal()" 
                            class="bg-gray-500 text-white font-semibold py-2 px-4 rounded-md shadow-md hover:bg-gray-600 mr-2">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" 
                    class="bg-gray-500 text-white font-semibold py-2 px-4 rounded-md shadow-md hover:bg-gray-600 ml-4">
                    {{ __('Save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Modal Scripts -->
    <script>
        const rolesPermissions = @json($Roles->mapWithKeys(fn($role) => [$role->id => $role->permissions->pluck('name')]));
    
        function openPermissionModal(roleId, roleName) {
            document.getElementById('roleId').value = roleId;
            document.getElementById('modalRoleName').innerText = `Assign Permissions to ${roleName}`;
    
            // Uncheck all checkboxes
            document.querySelectorAll('#permissionsList input[type="checkbox"]').forEach(input => input.checked = false);
    
            // Check assigned permissions
            if (rolesPermissions[roleId]) {
                rolesPermissions[roleId].forEach(permission => {
                    const checkbox = document.querySelector(`#permissionsList input[value="${permission}"]`);
                    if (checkbox) checkbox.checked = true;
                });
            }
    
            document.getElementById('permissionModal').classList.remove('hidden');
        }
    
        function closePermissionModal() {
            document.getElementById('permissionModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
