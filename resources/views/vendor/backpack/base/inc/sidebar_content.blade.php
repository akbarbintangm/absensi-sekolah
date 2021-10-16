<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i
            class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

@if (backpack_user()->hasRole('Admin'))
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i>
            Authentication</a>
        <ul class="nav-dropdown-items">
            <li class="nav-item"><a class="nav-link"
                    href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i>
                    <span>Users</span></a></li>
            <li class="nav-item"><a class="nav-link"
                    href="{{ backpack_url('role') }}"><i class="nav-icon la la-id-badge"></i>
                    <span>Roles</span></a></li>
            {{-- <li class="nav-item"><a class="nav-link"
                    href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i>
                    <span>Permissions</span></a></li> --}}
        </ul>
    </li>
    {{-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('sekolah') }}'><i
                class='nav-icon la la-school'></i> Sekolah</a></li> --}}
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('pelajaran') }}'><i
                class='nav-icon lab la-readme'></i> Pelajaran</a></li>
    {{-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('metode-belajar') }}'><i
                class='nav-icon la la-shapes'></i> Metode belajar</a></li> --}}
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('kelas') }}'><i
                class='nav-icon la la-book-open'></i> Kelas</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('jadwal') }}'><i
                class='nav-icon la la-calendar'></i> Jadwal</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('log') }}'><i
                class='nav-icon la la-terminal'></i> Logs</a></li>
@endif

@if (backpack_user()->hasAnyRole('Admin', 'Guru'))
@endif

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('pembelajaran') }}'><i
            class='nav-icon la la-chalkboard-teacher'></i> Kelas Pembelajaran</a></li>

@if (!backpack_user()->hasAnyRole('Admin'))
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('tugas') }}'><i
                class='nav-icon la la-tasks'></i> Tugas dan Materi</a></li>
    {{-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('rapot') }}'><i
                    class='nav-icon la la-chart-line'></i> Rapot</a></li> --}}
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('pengumpulan-tugas') }}'><i
                class='nav-icon la la-pen-square'></i> Pengumpulan tugas</a></li>
@endif

@if (backpack_user()->hasAnyRole('Guru'))
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('nilai') }}'><i
                class='nav-icon la la-book-reader'></i> Nilai</a></li>

@endif
