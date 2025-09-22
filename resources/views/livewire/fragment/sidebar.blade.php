<aside id="sidebar"
    class="w-64 bg-purple-600 text-gray-100 shadow dark:bg-gray-800 h-[calc(100vh-4rem)] p-4 fixed top-16 left-0 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-10 overflow-y-auto">
    @php
    $user = auth()->user();
    @endphp


    <!-- Super Administrator Section -->
    @if($user->roles()->where('name', 'super-admin')->exists())
    <div class="mt-2 pt-4  dark:border-gray-600">
        <h2 class="px-3 text-sm uppercase text-gray-200 mb-5 dark:text-gray-400">Administrator</h2>
        <a href="{{ route('admin-users') }}"
            class=" flex items-center gap-2 py-2 px-3 rounded hover:bg-purple-300 dark:hover:bg-gray-700 {{ request()->routeIs('admin-users') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
            </svg>

            Users
        </a>
        <a href="{{ route('admin-roles-permissions') }}"
            class="flex items-center gap-2 py-2 px-3 rounded hover:bg-purple-400 dark:hover:bg-gray-700 {{ request()->routeIs('admin-roles-permissions') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
            </svg>

            Roles & Permissions
        </a>
        <a href="{{ route('admin-schools') }}"
            class="flex items-center gap-2 py-2 px-3 rounded hover:bg-purple-400 dark:hover:bg-gray-700 {{ request()->routeIs('admin-schools') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
            </svg>


            Schools
        </a>
        <a href="{{ route('admin-session-manager') }}"
            class="flex items-center gap-2 py-2 px-3 rounded hover:bg-purple-400 dark:hover:bg-gray-700 {{ request()->routeIs('admin-session-manager') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
            </svg>

            Session Manager
        </a>
    </div>
    @elseif($user->roles()->where('name', 'school-admin')->exists())
    <nav>
        <a href="{{ route('school.admin.school') }}"
            class="flex items-center gap-2 py-2 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700 {{ request()->routeIs('school.admin.school') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
            </svg>
            School
        </a>
        <!-- Department with submenu -->
        <details class="group">
            <summary
                class="flex items-center justify-between w-full py-2 px-3 rounded cursor-pointer hover:bg-purple-500 dark:hover:bg-gray-700">
                <span class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 0h6m-9 4h12a2 2 0 002-2V7a2 2 0 00-2-2h-3.586a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 0011.586 2H6a2 2 0 00-2 2v16a2 2 0 002 2z" />
                    </svg>
                    Departments
                </span>
                <svg class="h-4 w-4 transform transition-transform group-open:rotate-90"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </summary>
            <div class="pl-8 mt-1 space-y-1">
                <a href="{{ route('school.admin.school.department') }}"
                    class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700 {{ request()->routeIs('school.admin.school.department') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">Departments</a>
                <a href="{{ route('school.admin.school.subject') }}"
                    class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700 {{ request()->routeIs('school.admin.school.subject') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">Subjects</a>
                <a href="{{ route('school.admin.school.department.subjects') }}"
                    class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700 {{ request()->routeIs('school.admin.school.department.subjects') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">Department
                    Subjects</a>
            </div>
        </details>

        <!-- Classes with submenu -->
        <details class="group">
            <summary
                class="flex items-center justify-between w-full py-2 px-3 rounded cursor-pointer hover:bg-purple-500 dark:hover:bg-gray-700">
                <span class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 0h6m-9 4h12a2 2 0 002-2V7a2 2 0 00-2-2h-3.586a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 0011.586 2H6a2 2 0 00-2 2v16a2 2 0 002 2z" />
                    </svg>
                    Classes
                </span>
                <svg class="h-4 w-4 transform transition-transform group-open:rotate-90"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </summary>
            <div class="pl-8 mt-1 space-y-1">
                <a href="{{  route('school.admin.school.classes') }}"
                    class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700 {{ request()->routeIs('school.admin.school.classes') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">
                    School classes</a>
                <a href="{{  route('school.admin.school.manage-weeks') }}"
                    class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700 {{ request()->routeIs('school.admin.school.manage-weeks') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">
                    Attendance Weeks</a>
                <a href="{{  route('school.admin.school.student.register') }}"
                    class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700 {{ request()->routeIs('school.admin.school.student.register') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">
                    Attendance</a>


            </div>
        </details>


        <!-- Students with submenu -->
        <details class="group">
            <summary
                class="flex items-center justify-between w-full py-2 px-3 rounded cursor-pointer hover:bg-purple-500 dark:hover:bg-gray-700">
                <span class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 0h6m-9 4h12a2 2 0 002-2V7a2 2 0 00-2-2h-3.586a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 0011.586 2H6a2 2 0 00-2 2v16a2 2 0 002 2z" />
                    </svg>
                    Students
                </span>
                <svg class="h-4 w-4 transform transition-transform group-open:rotate-90"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </summary>
            <div class="pl-8 mt-1 space-y-1">
                <a href="{{  route('school.admin.school.student.registration') }}"
                    class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700 {{ request()->routeIs('admin.school.student.registration') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">All
                    Student</a>

                <a href="#" class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700">
                    Activate as user</a>
                <a href="#" class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700">
                    Payments History</a>
                <a href="#" class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700">
                    Result</a>

            </div>
        </details>

        <!-- Teacher with submenu -->
        <details class="group">
            <summary
                class="flex items-center justify-between w-full py-2 px-3 rounded cursor-pointer hover:bg-purple-500 dark:hover:bg-gray-700">
                <span class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 0h6m-9 4h12a2 2 0 002-2V7a2 2 0 00-2-2h-3.586a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 0011.586 2H6a2 2 0 00-2 2v16a2 2 0 002 2z" />
                    </svg>
                    Teachers
                </span>
                <svg class="h-4 w-4 transform transition-transform group-open:rotate-90"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </summary>
            <div class="pl-8 mt-1 space-y-1">
                <a href="{{  route('school.admin.school.teacher.registration') }}"
                    class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700 {{ request()->routeIs('admin.school.teacher.registration') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">Register
                    Teacher</a>
                <a href="{{ route('school.admin.school.teacher.class') }}"
                    class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700 {{ request()->routeIs('school.admin.school.teacher.class') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">
                    Assign To Class</a>
                <a href="{{ route('school.admin.school.teacher.subjects') }}"
                    class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700
                 {{ request()->routeIs('school.admin.school.teacher.subjects') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">
                    Teacher's Subject
                </a>

                <a href="{{ route('school.admin.school.teacher.salary') }}"
                    class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700
                 {{ request()->routeIs('school.admin.school.teacher.salary') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">
                    Teacher's Salary</a>
                <a href="{{ route('school.admin.school.teacher.payment') }}"
                    class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700  {{ request()->routeIs('school.admin.school.teacher.payment') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">
                    Teachers' Payment</a>
                <a href="{{ route('school.admin.school.teacher.lesson-note') }}"
                    class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700  {{ request()->routeIs('school.admin.school.teacher.lesson-note') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">
                    Lesson Note</a>
               
                <a href="{{ route('school.admin.school.student.attendance') }}"
                    class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700 {{ request()->routeIs('school.admin.school.student.attendance') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">Student
                    Attendance</a>
                <a href="{{ route('school.admin.school.teacher.results') }}"
                    class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700 {{ request()->routeIs('school.admin.school.teacher.results') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">
                    Results </a>
                     <a href="{{ route('school.admin.school.result-info') }}"
                    class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700 {{ request()->routeIs('school.admin.school.result-info') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">
                    Results extra Info </a>



            </div>
        </details>

        <!-- Teacher with submenu -->
        <details class="group">
            <summary
                class="flex items-center justify-between w-full py-2 px-3 rounded cursor-pointer hover:bg-purple-500 dark:hover:bg-gray-700">
                <span class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 0h6m-9 4h12a2 2 0 002-2V7a2 2 0 00-2-2h-3.586a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 0011.586 2H6a2 2 0 00-2 2v16a2 2 0 002 2z" />
                    </svg>
                    Parents
                </span>
                <svg class="h-4 w-4 transform transition-transform group-open:rotate-90"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </summary>
            <div class="pl-8 mt-1 space-y-1">
                <a href="#" class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700">Register New
                    Student</a>
                <a href="#" class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700">Student
                    Classes</a>
                <a href="#" class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700">Student
                    Results</a>
                <a href="#" class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700">Student
                    Payments</a>
            </div>
        </details>

    </nav>
    <!-- School Settings -->
    <div class="mt-10 pt-4 border-t border-gray-300 dark:border-gray-600">
        <h2 class="px-3 text-sm uppercase text-gray-200 dark:text-gray-400">School Administrator</h2>

        <!-- Registration with submenu -->
        <details class="group">
            <summary
                class="flex items-center justify-between w-full py-2 px-3 rounded cursor-pointer hover:bg-purple-500 dark:hover:bg-gray-700">
                <span class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                    </svg>
                    School
                </span>
                <svg class="h-4 w-4 transform transition-transform group-open:rotate-90"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </summary>
            <div class="pl-8 mt-1 space-y-1">
                <a href="{{ route('school.admin.school.grades') }}"
                    class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700 {{ request()->routeIs('school.admin.school.grades') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">School
                    Grades</a>
                <a href="{{ route('school.admin.school.grades-keys') }}"
                    class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700 {{ request()->routeIs('school.admin.school.grades-keys') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">School
                    Grades Keys</a>
                <a href="{{ route('school.admin.school.affective') }}"
                    class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700 {{ request()->routeIs('school.admin.school.affective') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">School
                    Affective</a>

                <a href="{{ route('school.admin.school.psychomotor') }}"
                    class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700 {{ request()->routeIs('school.admin.school.psychomotor') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">School
                    Psychomotor</a>
                <a href="#" class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700">Teacher</a>
                <a href="#" class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700">Parent</a>

            </div>
        </details>
        <a href="#" class="flex items-center gap-2 py-2 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>

            Settings
        </a>
        <!-- Bills with submenu -->
        <details class="group">
            <summary
                class="flex items-center justify-between w-full py-2 px-3 rounded cursor-pointer hover:bg-purple-500 dark:hover:bg-gray-700">
                <span class="flex items-center gap-2">
                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>

                    Results settings
                </span>
                <svg class="h-4 w-4 transform transition-transform group-open:rotate-90"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>

            </summary>
            <div class="pl-8 mt-1 space-y-1">
                <a href="{{ route('school.admin.school.results-settings') }}"
                    class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700 {{ request()->routeIs('school.admin.school.results-settings') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">
                    Results Settings</a>
                <a href="{{ route('school.admin.school.weeks') }}"
                    class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700  {{ request()->routeIs('school.admin.school.weeks') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">
                    Set School Weeks Settings</a>
                <a href="{{ route('school.admin.school.manage-weeks') }}"
                    class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700  {{ request()->routeIs('school.admin.school.manage-weeks') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">
                    Set Attendance Weeks Settings</a>
            </div>
        </details>
        <!-- Users Roles and Permissions -->
        <details class="group">
            <summary
                class="flex items-center justify-between w-full py-2 px-3 rounded cursor-pointer hover:bg-purple-500 dark:hover:bg-gray-700">
                <span class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>

                    Users
                </span>
                <svg class="h-4 w-4 transform transition-transform group-open:rotate-90"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>

            </summary>
            <div class="pl-8 mt-1 space-y-1">
                <a href="#" class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700">School Users</a>
                <a href="#" class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700">Roles and
                    Permissions</a>

            </div>
        </details>

    </div>


    @elseif($user->roles()->where('name', 'class-teacher')->exists())

    <a href="{{ route('school.admin.school.class.teacher.attendance') }}"
        class="flex items-center gap-2 py-2 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700 {{ request()->routeIs('school.admin.school.class.teacher.attendance') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
        </svg>
        Attendance
    </a>
    <nav>

        <!-- Department with submenu -->
        <details class="group">
            <summary
                class="flex items-center justify-between w-full py-2 px-3 rounded cursor-pointer hover:bg-purple-500 dark:hover:bg-gray-700">
                <span class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 0h6m-9 4h12a2 2 0 002-2V7a2 2 0 00-2-2h-3.586a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 0011.586 2H6a2 2 0 00-2 2v16a2 2 0 002 2z" />
                    </svg>
                    Departments
                </span>
                <svg class="h-4 w-4 transform transition-transform group-open:rotate-90"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </summary>
            <div class="pl-8 mt-1 space-y-1">
                <a href="#"
                    class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700 {{ request()->routeIs('school.admin.school.department') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">Departments</a>
                <a href="#"
                    class="block py-1 px-3 rounded hover:bg-purple-500 dark:hover:bg-gray-700 {{ request()->routeIs('school.admin.school.subject') ? 'bg-purple-500 dark:bg-purple-500' : '' }}">Subjects</a>

            </div>
        </details>



    </nav>

    @elseif($user->roles()->where('name', 'teacher')->exists())

    @endif
</aside>