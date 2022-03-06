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
                    <div class="gr-employe-list-wrap w-full">
                        {{-- <h2>Employees <a href="/create-employee">Create Employee</a></h2> --}}
                        <div class="employee-list-header d-flex justify-content-between flex justify-between mb-4">


           
                        </div>
                        <ul>
                            @foreach ($files as $file)

                                <li class="flex justify-between align-center">
                                    <div class="gr-employee-meta">
                                        <div class="employe-name">
                                            <a href="{{ $file['url'] }}">
                                                <h4>{{ $file['filename'] }}</h4>
                                            </a>
                                        </div>
                                    </div>

                

                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>




</x-app-layout>
