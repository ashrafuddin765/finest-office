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
                        <h1>Pending Point Request</h1>
                        <p>Let's win the race together!</p>
                    </div>
                    <div class="gr-employe-list-wrap w-full">
                        {{-- <h2>Employees <a href="/create-employee">Create Employee</a></h2> --}}
                        <div class="employee-list-header d-flex justify-content-between flex justify-between mb-4">
                            <div class="current-month">
                                <p> <span>{{ date('F, Y') }} </span></p>
                            </div>

                            <div class="previus-month-report-link">
                                <a href="{{ route('approve-all') }}"
                                    onclick="return confirm('Do you want to approve all pending request?')">Approve
                                    all</a>
                            </div>

                        </div>
                        <ul>
                            @if (count($office_report) > 0)
                                @foreach ($office_report as $report)
                                    @php
                                        $isRequestedSameDay = $self_obj->isRequestedSameDay($report->user_id, date('Y-m-d', strtotime($report->created_at)))->count() > 1;
                                        $total_points = $report->points;

                                        if ($total_points > 0 && $total_points <= 2) {
                                            $point_class = 'green';
                                        } elseif ($total_points < 0) {
                                            $point_class = 'red';
                                        } else {
                                            $point_class = 'yellow';
                                        }

                                        $point_class = $isRequestedSameDay ? 'orange' : $point_class;

                                        @endphp

                                    <li class="flex justify-between align-center">
                                        <div class="gr-employee-meta ">
                                            <span class="gr-employee-point  {{ $point_class }}"> {{ $total_points }}
                                            </span>
                                            <div class="employe-name">
                                                <h4>{{ $report->users->name }}</h4>
                                                <span class="last-updated">
                                                    {{-- {{ $leaderboard->splitName($report['updated_by'])[0] }} --}}
                                                    Requsted
                                                    {{ $self_obj->getTImeAgo(strtotime($report['updated_at'])) }}</span>
                                            </div>
                                        </div>

                                        @if ($report->user_id === Auth::user()->id || 'admin' == Auth::user()->role)
                                            <form action="{{ route('dashboard.update', $report->id) }}" method="post"
                                                class="update-form">
                                                @csrf
                                                @method('put')
                                                <div class="edit-field-wrap">


                                                    <input
                                                        class="bg-green-600 font-bold py-2 px-4 text-sm rounded text-white"
                                                        type="submit" value="Approve" name="approve">
                                                    <input
                                                        class="bg-red-500 font-bold inline py-2 px-4 text-sm rounded text-white"
                                                        type="submit" value="Reject" name="reject">
                                                </div>
                                            </form>
                                        @endif

                                    </li>
                                @endforeach
                            @else
                                <li class="flex justify-between align-center">
                                    <div class="gr-employee-meta">
                                        <span class="gr-employee-name">
                                            No Pending Request
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
