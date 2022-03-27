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
                    {{-- make winner button --}}

                    {{-- check user role is admin --}}
                    @if (Auth::user()->role == 'admin')
                        <div class="employee-list-header flex justify-end mb-4">
                            <div class="search-wrapper flex justify-between r">
                                <a href="{{ route('select-winner') }}" class="btn">Get a Winner</a>
                            </div>
                        </div>
                    @endif
                    <div class="gr-employe-list-wrap w-full flex">

                        <div class="data-table-wrapper flex w-full">
                            <table class=" bg-white table-auto w-full">

                                <thead>
                                    <th class="border px-4 py-2">Month</th>
                                    <th class="border px-4 py-2">Name</th>
                                    <th class="border px-4 py-2">Point</th>
                                </thead>
                                <tbody>

                                    @foreach ($winner as $item)
                                        @php
                                            
                                            // $date = date('d-m-Y', strtotime($item->created_at));
                                            // $isRequestedSameDay = $self_obj->isRequestedSameDay($item->user_id, date('Y-m-d', strtotime($item->created_at)))->count() > 1;
                                            // $date_class = $isRequestedSameDay ? 'text-orange-500' : '';
                                            

                                                $point_class = 'text-green-500';
                                         
                                            
                                        @endphp

                                        <tr class="">
                                            <td class="border px-4 py-2 ">
                                                {{ date('M - Y', strtotime($item->created_at)) }}
                                            </td>
                                            <td class="border px-4 py-2 ">
                                                {{ $item->users->name }}
                                            </td>
                                            <td class="border px-4 py-2 font-bold {{ $point_class }}">
                                                {{ $item->points }}</td>
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
