<x-guest-layout>

    <div class="relative flex px-6 py-6 items-top justify-between bg-gray-100 dark:bg-gray-900 sm:items-center ">
        <div class="logo">
            <a class=" block" href="{{ url('/') }}">
                <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
            </a>
        </div>
        @if (Route::has('login'))
            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                    @endif
                @endauth
            </div>
        @endif

    </div>


    <div class="gr-employeee-area">
        <div class="container mx-auto w-8/12">
            <div class="">
                <div class="">
                    <div class=" w-full gr-employee-title text-center">
                        <h1>Leader Board</h1>
                        <p>Let's win the race together!</p>
                    </div>
                    <div class="gr-employe-list-wrap w-full">
                        {{-- <h2>Employees <a href="/create-employee">Create Employee</a></h2> --}}
                        <div class="employee-list-header d-flex justify-content-between flex justify-between mb-4">
                            <div class="current-month">
                                <p> <span>{{ date('F, Y') }} </span></p>
                            </div>

                            <div class="previus-month-report-link">
                                <a href="{{ route('old-reports') }}">Check previous reports</a>
                            </div>

                        </div>
                        <ul>
                            @if (count($office_report) > 0)
                                @foreach ($office_report as $report)
                                    @php
                                        
                                        $total_points = $report->total_point;
                                        
                                        if ($total_points > 0) {
                                            $point_class = 'green';
                                        } elseif ($total_points < 0) {
                                            $point_class = 'red';
                                        } else {
                                            $point_class = 'yellow';
                                        }
                                    @endphp

                                    <li class="flex justify-between align-center">
                                        <div class="gr-employee-meta">
                                            <span class="gr-employee-point {{ $point_class }}"> {{ $total_points }}
                                            </span>
                                            <div class="employe-name">
                                                <h4>{{ $report->users->name }}</h4>
                                                <span class="last-updated">
                                                    {{ $leaderboard->splitName($leaderboard->getLastUpdatedData($report->user_id)->updated_by)[0] }}
                                                    updated
                                                    {{ $leaderboard->getTImeAgo(strtotime($leaderboard->getLastUpdatedData($report->user_id)->updated_at)) }}</span>
                                            </div>
                                        </div>


                                    </li>
                                @endforeach
                            @else
                                <li class="flex justify-between align-center">
                                    <div class="gr-employee-meta">

                                        <div class="employe-name">
                                            <h4>No data found</h4>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{ $office_report->links() }}

</x-guest-layout>
