<x-app-layout>
    {{-- @flasher_render --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Leaderboard') }}
            </h2>
        </div>
    </x-slot>




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

                            {{-- @if ('admin' == Auth::user()->role)
                                <div class="create-employee-link">
                                    <a href="{{ route('dashboard.create') }}">Create New Employee</a>
                                </div>

                                <div class="previus-month-report-link">
                                    <a href="{{ route('reset-leaderboard') }}"
                                        onclick="return confirm('Do you want to delete this location?')">Reset all</a>
                                </div>
                            @endif --}}
                        </div>
                        <ul>
                            @if (count($office_report) > 0):
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
                                        {{-- @if ($report->user_id === Auth::user()->id || 'admin' == Auth::user()->role)

                                        <form action="{{ route('dashboard.store', $report->user_id) }}" method="POST"
                                            class="update-form">
                                            @csrf
                                            @method('post')
                                            <div class="edit-field-wrap">
                                                <input type="hidden" name="updated_by"
                                                    value="{{ Auth::user()->name }}">
                                                <input type="hidden" name="points" value="{{ $total_points }}">
                                                <input type="hidden" name="user_id" value="{{ $report->user_id }}">
                                                <input type="number" value="0" step="0.5" name="points"
                                                    class='edit-point'>
                                                <input type="submit" value="Submit">
                                            </div>
                                        </form>
                                    @endif --}}

                                    </li>
                                @endforeach
                                @else:
                                <li class="flex justify-between align-center">
                                    <div class="gr-employee-meta">
                                        <span class="gr-employee-name">
                                            <h4>No data found</h4>
                                        </span>
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


</x-app-layout>
