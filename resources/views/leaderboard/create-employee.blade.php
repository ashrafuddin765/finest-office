<x-app-layout>
    {{-- @flasher_render --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Leaderboard') }}
            </h2>
        </div>
    </x-slot>




    <div class="create-employee-area gr-login-area">
        <div class="container w-5/12">
            <div class=" ">
                <div class="">
                    <div class="gr-employee-title text-center">
                        <h1>Register new Employee</h1>
                    </div>
                    <form action="{{ route('dashboard.store') }}" method="POST" class="create-employee-form">
                        @csrf
                        <div class="form-group">
                            <label class="block mb-1" for="name">Name</label>
                            <input class="block mb-3 w-full" type="text" value="{{old('name')}}" name="name" id="name" placeholder="Emplyee name" class="form-control">
                            <span style="color:red">{{$errors->first('name')}}</span>
                        </div>
                        <div class="form-group">
                            <label class="block mb-1" for="point">Point</label>
                            <input type="text" name="points" class="block mb-3 w-full" id="points" placeholder="Point" value="{{old('point')}}" class="form-control">
                            <span style="color:red">{{$errors->first('points')}}</span>
                        </div>
           
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Create" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



</x-app-layout>
