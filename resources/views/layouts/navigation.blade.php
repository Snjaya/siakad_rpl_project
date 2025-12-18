<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- Menu Khusus ADMIN --}}
                    @if (Auth::user()->role == 'Admin')
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                            {{ __('Kelola User (A.5)') }}
                        </x-nav-link>
                        {{-- Menu Laporan Nilai Admin (A.2, A.3) - Link sementara ke dashboard --}}
                        <x-nav-link :href="route('dashboard')" :active="false">
                            {{ __('Laporan Nilai') }}
                        </x-nav-link>
                    @endif

                    {{-- Menu Khusus TATA USAHA (TU) --}}
                    @if (Auth::user()->role == 'TU')
                        <x-nav-link :href="route('dashboard')" :active="false">
                            {{ __('Data Siswa (D.2)') }}
                        </x-nav-link>
                        <x-nav-link :href="route('dashboard')" :active="false">
                            {{ __('Data Guru (D.3)') }}
                        </x-nav-link>
                        <x-nav-link :href="route('dashboard')" :active="false">
                            {{ __('Jadwal Pelajaran (D.7)') }}
                        </x-nav-link>
                    @endif

                    {{-- Menu Khusus GURU --}}
                    @if (Auth::user()->role == 'Guru')
                        <x-nav-link :href="route('dashboard')" :active="false">
                            {{ __('Input Nilai (B.6)') }}
                        </x-nav-link>
                        <x-nav-link :href="route('dashboard')" :active="false">
                            {{ __('Jadwal Mengajar (B.5)') }}
                        </x-nav-link>
                    @endif

                    {{-- Menu Khusus SISWA --}}
                    @if (Auth::user()->role == 'Siswa')
                        <x-nav-link :href="route('dashboard')" :active="false">
                            {{ __('Lihat Nilai (C.4)') }}
                        </x-nav-link>
                        <x-nav-link :href="route('dashboard')" :active="false">
                            {{ __('Jadwal Pelajaran (C.3)') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            {{-- Menggunakan username sesuai model User --}}
                            <div>{{ Auth::user()->username }} ({{ Auth::user()->role }})</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            {{-- Responsive Links Berdasarkan Role --}}
            @if (Auth::user()->role == 'Admin')
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                    {{ __('Kelola User') }}
                </x-responsive-nav-link>
            @endif

            @if (Auth::user()->role == 'TU')
                <x-responsive-nav-link :href="route('dashboard')">{{ __('Data Siswa') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('dashboard')">{{ __('Data Guru') }}</x-responsive-nav-link>
            @endif

            @if (Auth::user()->role == 'Guru')
                <x-responsive-nav-link :href="route('dashboard')">{{ __('Input Nilai') }}</x-responsive-nav-link>
            @endif

            @if (Auth::user()->role == 'Siswa')
                <x-responsive-nav-link :href="route('dashboard')">{{ __('Lihat Nilai') }}</x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->username }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
