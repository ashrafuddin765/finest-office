<x-app-layout>
    {{-- @flasher_render --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Previous reports') }}
            </h2>
     
        </div>
    </x-slot>




    <div class="gr-employeee-area">
        <div class="container mx-auto w-8/12">
            <div class="">
                <div class="">
                    <div class=" w-full gr-employee-title text-center">
                        <h1>Previous Reports</h1>
                        <p>Let's win the race together!</p>
                    </div>
                    <div class="gr-employe-list-wrap w-full flex">
                        {{-- <h2>Employees <a href="/create-employee">Create Employee</a></h2> --}}
                        <div class="employee-list-header flex justify-between mb-4 w-3/12">

                            <form action="" method="GET" class="property-searchform">
                                @csrf
                                <div class="search-wrapper w-full justify-between">
                                    <div class="field-wrap  w-full">
                                        <label for="employee">All Employees</label>
                                        <select name="employee" class="border-0 focus:ring-0 w-full mb-2 mt-1">
                                            <option value="">Select Employee</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ request('employee') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="field-wrap  w-full">
                                        <label for="month">Months</label>
                                        <select name="month" class="border-0 focus:ring-0 w-full mb-2 mt-1">
                                            <option value="">Select Month</option>
                                            @for ($m = 1; $m <= 12; $m++)
                                                <option value="{{ $m }}"
                                                    {{ request('month') == $m ? 'selected' : '' }}>
                                                    {{ date('F', mktime(0, 0, 0, $m, 1, date('Y'))) }}</option>
                                            @endfor;
                                        </select>
                                    </div>

                                </div>
                                <div class=" search-wrapper flex justify-between r">
                                    <button type="submit" class="btn">Filter</button>
                                </div>
                            </form>


                        </div>
                        <div class="data-table-wrapper pl-9 flex w-full">

                            <table class=" bg-white table-auto w-full">

                                <thead>
                                    <th class="border px-4 py-2">Date</th>
                                    <th class="border px-4 py-2">Point</th>
                                    <th class="border px-4 py-2">Approved by</th>
                                </thead>
                                <tbody>
                                    @foreach ($reports as $item)
                                        @php
                                            if ($item->points > 0 && $item->points <= 2):
                                                $point_class = 'text-green-500';
                                            elseif ($item->points < 0):
                                                $point_class = 'text-red-500';
                                            else:
                                                $point_class = 'text-yellow-400';
                                            endif;
                                        @endphp

                                        <tr>
                                            <td class="border px-4 py-2 ">
                                                {{ date('d/m/Y', strtotime($item->updated_at)) }}
                                            </td>
                                            <td class="border px-4 py-2 font-bold {{ $point_class }}">{{ $item->points }}</td>
                                            <td class="border px-4 py-2">{{ $item->updated_by }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>




</x-app-layout>
