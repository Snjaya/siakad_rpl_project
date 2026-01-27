<div x-show="sidebarOpen" @click="sidebarOpen = false"
    class="fixed inset-0 bg-slate-900/50 z-30 lg:hidden transition-opacity duration-300"
    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    style="display: none;">
</div>

<aside :class="sidebarOpen ? 'translate-x-0 w-64' : '-translate-x-full lg:translate-x-0 lg:w-20'"
    class="fixed left-0 top-0 h-full bg-slate-900 text-white transition-all duration-300 ease-in-out z-40 border-r border-slate-800 shadow-2xl flex flex-col">

    <div class="h-16 flex items-center justify-center border-b border-slate-800 bg-slate-950">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-2 overflow-hidden w-full justify-center">
            <img src="{{ asset('logo.png') }}" alt="Logo"
                class="w-10 h-10 object-contain drop-shadow-lg transition-transform hover:scale-110">

            <div class="flex flex-col transition-opacity duration-300" x-show="sidebarOpen">
                <span class="font-extrabold text-sm tracking-wide text-white whitespace-nowrap">SMK MARHAS</span>
                <span class="text-[10px] text-emerald-400 font-medium tracking-wider whitespace-nowrap">SIAKAD
                    SYSTEM</span>
            </div>
        </a>
    </div>

    <div class="flex-1 overflow-y-auto overflow-x-hidden py-4 px-3 space-y-1 custom-scrollbar">

        <x-responsive-nav-link
    :href="route('dashboard')"
    :active="
        request()->routeIs('admin.dashboard') ||
        request()->routeIs('tu.dashboard') ||
        request()->routeIs('guru.dashboard') ||
        request()->routeIs('siswa.dashboard')
    "
    class="flex items-center px-3 py-2.5 mb-1 rounded-lg transition-all
    {{
        request()->routeIs('admin.dashboard') ||
        request()->routeIs('tu.dashboard') ||
        request()->routeIs('guru.dashboard') ||
        request()->routeIs('siswa.dashboard')
            ? 'bg-slate-800 text-emerald-400 border-l-4 border-emerald-500'
            : 'text-slate-400 hover:bg-slate-800 hover:text-white'
    }}">

    <i class="fa-solid fa-house w-6 text-center text-lg"></i>

    <span class="ml-3 font-medium text-sm whitespace-nowrap"
          x-show="sidebarOpen">
        Dashboard
    </span>
</x-responsive-nav-link>



        <div class="border-t border-slate-800 my-4 mx-2"></div>

        @if (Auth::user()->role == 'Admin')
            <div class="mb-2">
                <p class="px-4 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest whitespace-nowrap transition-opacity"
                    x-show="sidebarOpen">Administrator</p>
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')"
                    class="group flex items-center px-3 py-2.5 rounded-lg transition-all duration-200
                    {{ request()->routeIs('admin.users.*') ? 'bg-slate-800 text-emerald-400 border-l-4 border-emerald-500' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-users-gear w-6 text-center"></i>
                    <span class="ml-3 text-sm font-medium whitespace-nowrap" x-show="sidebarOpen">Kelola Akun</span>
                </x-responsive-nav-link>
            </div>
        @endif

        @if (Auth::user()->role == 'TU')
            <div class="mb-2">
                <p class="px-4 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest whitespace-nowrap transition-opacity"
                    x-show="sidebarOpen">Master Data</p>

                <x-responsive-nav-link :href="route('tu.teachers.index')" :active="request()->routeIs('tu.teachers.*')"
                    class="flex items-center px-3 py-2.5 mb-1 rounded-lg transition-all {{ request()->routeIs('tu.teachers.*') ? 'bg-slate-800 text-emerald-400 border-l-4 border-emerald-500' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-chalkboard-user w-6 text-center"></i>
                    <span class="ml-3 text-sm font-medium whitespace-nowrap" x-show="sidebarOpen">Data Guru</span>
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('tu.students.index')" :active="request()->routeIs('tu.students.*')"
                    class="flex items-center px-3 py-2.5 mb-1 rounded-lg transition-all {{ request()->routeIs('tu.students.*') ? 'bg-slate-800 text-emerald-400 border-l-4 border-emerald-500' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-user-graduate w-6 text-center"></i>
                    <span class="ml-3 text-sm font-medium whitespace-nowrap" x-show="sidebarOpen">Data Siswa</span>
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('tu.classrooms.index')" :active="request()->routeIs('tu.classrooms.*')"
                    class="flex items-center px-3 py-2.5 mb-1 rounded-lg transition-all {{ request()->routeIs('tu.classrooms.*') ? 'bg-slate-800 text-emerald-400 border-l-4 border-emerald-500' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-school w-6 text-center"></i>
                    <span class="ml-3 text-sm font-medium whitespace-nowrap" x-show="sidebarOpen">Data Kelas</span>
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('tu.subjects.index')" :active="request()->routeIs('tu.subjects.*')"
                    class="flex items-center px-3 py-2.5 mb-1 rounded-lg transition-all {{ request()->routeIs('tu.subjects.*') ? 'bg-slate-800 text-emerald-400 border-l-4 border-emerald-500' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-book w-6 text-center"></i>
                    <span class="ml-3 text-sm font-medium whitespace-nowrap" x-show="sidebarOpen">Mata Pelajaran</span>
                </x-responsive-nav-link>

                <p class="px-4 mt-6 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest whitespace-nowrap transition-opacity"
                    x-show="sidebarOpen">Manajemen Jadwal</p>

                <x-responsive-nav-link :href="route('tu.academic_years.index')" :active="request()->routeIs('tu.academic_years.*')"
                    class="flex items-center px-3 py-2.5 mb-1 rounded-lg transition-all {{ request()->routeIs('tu.academic_years.*') ? 'bg-slate-800 text-emerald-400 border-l-4 border-emerald-500' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-regular fa-calendar-check w-6 text-center"></i>
                    <span class="ml-3 text-sm font-medium whitespace-nowrap" x-show="sidebarOpen">Tahun Ajaran</span>
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('tu.schedules.index')" :active="request()->routeIs('tu.schedules.*')"
                    class="flex items-center px-3 py-2.5 mb-1 rounded-lg transition-all {{ request()->routeIs('tu.schedules.*') ? 'bg-slate-800 text-emerald-400 border-l-4 border-emerald-500' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-calendar-days w-6 text-center"></i>
                    <span class="ml-3 text-sm font-medium whitespace-nowrap" x-show="sidebarOpen">Jadwal
                        Pelajaran</span>
                </x-responsive-nav-link>
            </div>
        @endif

        @if (Auth::user()->role == 'Guru')
            <div class="mb-2">
                <p class="px-4 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest whitespace-nowrap transition-opacity"
                    x-show="sidebarOpen">Aktivitas</p>
                <x-responsive-nav-link :href="route('dashboard')"
                    class="flex items-center px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('dashboard') ? 'bg-slate-800 text-emerald-400 border-l-4 border-emerald-500' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-pen-to-square w-6 text-center"></i>
                    <span class="ml-3 text-sm font-medium whitespace-nowrap" x-show="sidebarOpen">Jadwal & Nilai</span>
                </x-responsive-nav-link>
            </div>
        @endif

        @if (Auth::user()->role == 'Siswa')
            <div class="mb-2">
                <p class="px-4 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest whitespace-nowrap transition-opacity"
                    x-show="sidebarOpen">Akademik Saya</p>
                <x-responsive-nav-link :href="route('siswa.schedules.index')" :active="request()->routeIs('siswa.schedules.*')"
                    class="flex items-center px-3 py-2.5 mb-1 rounded-lg transition-all {{ request()->routeIs('siswa.schedules.*') ? 'bg-slate-800 text-emerald-400 border-l-4 border-emerald-500' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-regular fa-calendar w-6 text-center"></i>
                    <span class="ml-3 text-sm font-medium whitespace-nowrap" x-show="sidebarOpen">Jadwal
                        Pelajaran</span>
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('siswa.grades.index')" :active="request()->routeIs('siswa.grades.*')"
                    class="flex items-center px-3 py-2.5 mb-1 rounded-lg transition-all {{ request()->routeIs('siswa.grades.*') ? 'bg-slate-800 text-emerald-400 border-l-4 border-emerald-500' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-file-contract w-6 text-center"></i>
                    <span class="ml-3 text-sm font-medium whitespace-nowrap" x-show="sidebarOpen">Transkrip Nilai</span>
                </x-responsive-nav-link>
            </div>
        @endif

    </div>

    <div class="p-4 bg-slate-950 border-t border-slate-800 flex-shrink-0">
        <div class="flex items-center gap-3 mb-4 overflow-hidden">
            <div
                class="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-br from-emerald-600 to-teal-700 flex items-center justify-center text-white text-sm font-bold shadow-lg ring-2 ring-slate-800">
                {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
            </div>
            <div class="overflow-hidden transition-all duration-300" x-show="sidebarOpen">
                <p class="text-sm font-semibold text-white truncate max-w-[140px] leading-tight">
                    {{ Auth::user()->username }}</p>
                <div class="flex items-center gap-1.5 mt-0.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <p class="text-[10px] text-slate-400 uppercase tracking-wide">{{ Auth::user()->role }}</p>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="group flex items-center justify-center w-full py-2 text-sm font-medium text-slate-400 hover:text-white bg-slate-900 hover:bg-red-600 rounded-lg transition-all duration-200 border border-slate-800 hover:border-red-500">
                <i class="fa-solid fa-right-from-bracket transition-transform group-hover:-translate-x-1"></i>
                <span class="ml-2 whitespace-nowrap transition-all duration-300" x-show="sidebarOpen">Keluar</span>
            </button>
        </form>
    </div>
</aside>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #334155;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #475569;
    }
</style>
