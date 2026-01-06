<aside :class="sidebarOpen ? 'w-64' : 'w-20'"
    class="flex flex-col h-full bg-slate-900 border-r border-slate-800 transition-all duration-300 ease-in-out z-40 overflow-hidden flex-shrink-0">

    <div class="flex items-center h-20 px-6 bg-slate-950 border-b border-slate-800 flex-shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 w-full overflow-hidden">
            <div class="flex-shrink-0 p-2 bg-blue-600 rounded-lg shadow-lg shadow-blue-500/30">
                <x-application-logo class="w-6 h-6 fill-current text-white" />
            </div>
            <span class="text-lg font-bold text-white tracking-wide whitespace-nowrap transition-opacity duration-300"
                x-show="sidebarOpen" x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                SIAKAD
            </span>
        </a>
    </div>

    <div class="flex-1 px-4 py-6 space-y-2 overflow-y-auto overflow-x-hidden custom-scrollbar">

        <p class="px-2 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest whitespace-nowrap transition-opacity duration-300"
            x-show="sidebarOpen">
            Main Menu
        </p>

        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
            class="group flex items-center px-2 py-3 rounded-lg transition-all duration-200 border-none
            {{ request()->routeIs('dashboard') ? 'text-blue-400' : 'text-slate-400 hover:text-white hover:translate-x-1' }}">

            <i
                class="fa-solid fa-house w-6 text-center text-lg transition-colors duration-200 
               {{ request()->routeIs('dashboard') ? 'text-blue-500' : 'group-hover:text-blue-400' }}"></i>

            <span class="ml-3 font-medium whitespace-nowrap transition-all duration-300" x-show="sidebarOpen">
                Dashboard
            </span>
        </x-responsive-nav-link>

        @if (Auth::user()->role == 'Admin')
            <div class="mt-6">
                <p class="px-2 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest whitespace-nowrap transition-opacity duration-300"
                    x-show="sidebarOpen">
                    Administrator
                </p>

                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')"
                    class="group flex items-center px-2 py-3 rounded-lg transition-all duration-200 border-none cursor-pointer
                    {{ request()->routeIs('admin.users.*')
                        ? 'text-blue-400'
                        : 'text-slate-400 hover:text-white hover:translate-x-1' }}">

                    <i
                        class="fa-solid fa-users-gear w-6 text-center text-lg transition-colors duration-200
                       {{ request()->routeIs('admin.users.*') ? 'text-blue-500' : 'group-hover:text-blue-400' }}"></i>

                    <span class="ml-3 font-medium whitespace-nowrap transition-all duration-300" x-show="sidebarOpen">
                        Kelola Akun
                    </span>
                </x-responsive-nav-link>
            </div>
        @endif

        @if (Auth::user()->role == 'TU')
            <div class="mt-6">
                <p class="px-2 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest whitespace-nowrap transition-opacity duration-300"
                    x-show="sidebarOpen">
                    Akademik
                </p>

                <x-responsive-nav-link :href="route('tu.teachers.index')" :active="request()->routeIs('tu.teachers.*')"
                    class="group flex items-center px-2 py-3 rounded-lg transition-all duration-200 border-none cursor-pointer
                    {{ request()->routeIs('tu.teachers.*')
                        ? 'text-blue-400'
                        : 'text-slate-400 hover:text-white hover:translate-x-1' }}">

                    <i
                        class="fa-solid fa-chalkboard-user w-6 text-center text-lg transition-colors duration-200 
                       {{ request()->routeIs('tu.teachers.*') ? 'text-blue-500' : 'group-hover:text-blue-400' }}"></i>

                    <span class="ml-3 font-medium whitespace-nowrap transition-all duration-300" x-show="sidebarOpen">
                        Data Guru
                    </span>
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('tu.classrooms.index')" :active="request()->routeIs('tu.classrooms.*')"
                    class="group flex items-center px-2 py-3 rounded-lg transition-all duration-200 border-none cursor-pointer
                    {{ request()->routeIs('tu.classrooms.*') ? 'text-blue-400' : 'text-slate-400 hover:text-white hover:translate-x-1' }}">

                    <i
                        class="fa-solid fa-school w-6 text-center text-lg transition-colors duration-200 
                       {{ request()->routeIs('tu.classrooms.*') ? 'text-blue-500' : 'group-hover:text-blue-400' }}"></i>

                    <span class="ml-3 font-medium whitespace-nowrap transition-all duration-300" x-show="sidebarOpen">
                        Data Kelas
                    </span>
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('tu.students.index')" :active="request()->routeIs('tu.students.*')"
                    class="group flex items-center px-2 py-3 rounded-lg transition-all duration-200 border-none cursor-pointer
                    {{ request()->routeIs('tu.students.*') ? 'text-blue-400' : 'text-slate-400 hover:text-white hover:translate-x-1' }}">

                    <i
                        class="fa-solid fa-user-graduate w-6 text-center text-lg transition-colors duration-200 
                       {{ request()->routeIs('tu.students.*') ? 'text-blue-500' : 'group-hover:text-blue-400' }}"></i>

                    <span class="ml-3 font-medium whitespace-nowrap transition-all duration-300" x-show="sidebarOpen">
                        Data Siswa
                    </span>
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('tu.subjects.index')" :active="request()->routeIs('tu.subjects.*')"
                    class="group flex items-center px-2 py-3 rounded-lg transition-all duration-200 border-none cursor-pointer
    {{ request()->routeIs('tu.subjects.*') ? 'text-blue-400' : 'text-slate-400 hover:text-white hover:translate-x-1' }}">
                    <i
                        class="fa-solid fa-book w-6 text-center text-lg transition-colors duration-200 
       {{ request()->routeIs('tu.subjects.*') ? 'text-blue-500' : 'group-hover:text-blue-400' }}"></i>
                    <span class="ml-3 font-medium whitespace-nowrap transition-all duration-300" x-show="sidebarOpen">
                        Mata Pelajaran
                    </span>
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('tu.academic_years.index')" :active="request()->routeIs('tu.academic_years.*')"
                    class="group flex items-center px-2 py-3 rounded-lg transition-all duration-200 border-none cursor-pointer
    {{ request()->routeIs('tu.academic_years.*') ? 'text-blue-400' : 'text-slate-400 hover:text-white hover:translate-x-1' }}">
                    <i
                        class="fa-regular fa-calendar-check w-6 text-center text-lg transition-colors duration-200 
       {{ request()->routeIs('tu.academic_years.*') ? 'text-blue-500' : 'group-hover:text-blue-400' }}"></i>
                    <span class="ml-3 font-medium whitespace-nowrap transition-all duration-300" x-show="sidebarOpen">
                        Tahun Ajaran
                    </span>
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('tu.schedules.index')" :active="request()->routeIs('tu.schedules.*')"
                    class="group flex items-center px-2 py-3 rounded-lg transition-all duration-200 border-none cursor-pointer
    {{ request()->routeIs('tu.schedules.*') ? 'text-blue-400' : 'text-slate-400 hover:text-white hover:translate-x-1' }}">
                    <i
                        class="fa-solid fa-calendar-days w-6 text-center text-lg transition-colors duration-200 
       {{ request()->routeIs('tu.schedules.*') ? 'text-blue-500' : 'group-hover:text-blue-400' }}"></i>
                    <span class="ml-3 font-medium whitespace-nowrap transition-all duration-300" x-show="sidebarOpen">
                        Jadwal Pelajaran
                    </span>
                </x-responsive-nav-link>
            </div>
        @endif

        @if (Auth::user()->role == 'Guru')
            <div class="mt-6">
                <p class="px-2 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest whitespace-nowrap transition-opacity duration-300"
                    x-show="sidebarOpen">
                    Menu Guru
                </p>

                <x-responsive-nav-link :href="route('dashboard')"
                    class="group flex items-center px-2 py-3 rounded-lg transition-all duration-200 border-none cursor-pointer text-slate-400 hover:text-white hover:translate-x-1">

                    <i
                        class="fa-solid fa-pen-to-square w-6 text-center text-lg transition-colors duration-200 group-hover:text-blue-400"></i>

                    <span class="ml-3 font-medium whitespace-nowrap transition-all duration-300" x-show="sidebarOpen">
                        Input Nilai
                    </span>
                </x-responsive-nav-link>
            </div>
        @endif
    </div>

    <div class="p-4 bg-slate-950 border-t border-slate-800 flex-shrink-0">
        <div class="flex items-center gap-3 mb-4 overflow-hidden">
            <div
                class="flex-shrink-0 w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white text-sm font-bold shadow-md">
                {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
            </div>
            <div class="overflow-hidden transition-opacity duration-300" x-show="sidebarOpen">
                <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->username }}</p>
                <p class="text-[10px] text-slate-500 uppercase tracking-wide">{{ Auth::user()->role }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="group flex items-center justify-center w-full py-2 text-sm font-medium text-slate-400 hover:text-red-400 bg-slate-900 hover:bg-slate-800 rounded-lg transition-all border border-slate-800 hover:border-red-500/30">
                <i class="fa-solid fa-right-from-bracket transition-transform group-hover:-translate-x-1"></i>
                <span class="ml-2 whitespace-nowrap transition-all duration-300" x-show="sidebarOpen">Keluar</span>
            </button>
        </form>
    </div>
</aside>
