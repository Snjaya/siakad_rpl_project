<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Akun User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('info'))
                <div class="mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative">
                    {{ session('info') }}
                </div>
            @endif

            @if (session('warning'))
                <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative">
                    {{ session('warning') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-4 text-right">
                <a href="{{ route('admin.users.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                    + Tambah Akun
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-3">Username</th>
                                <th class="border p-3">Email</th>
                                <th class="border p-3">Role</th>
                                <th class="border p-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="border p-3">{{ $user->username }}</td>
                                    <td class="border p-3">{{ $user->email }}</td>
                                    <td class="border p-3">{{ $user->role }}</td>
                                    <td class="border p-3">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                                class="text-blue-600 hover:underline">Edit</a>
                                            <span class="text-gray-300">|</span>
                                            <a href="{{ route('admin.users.reset', $user) }}"
                                                class="text-yellow-600 hover:underline">Reset</a>
                                            <span class="text-gray-300">|</span>
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline"
                                                    onclick="return confirm('Yakin hapus akun {{ $user->username }}?')">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
