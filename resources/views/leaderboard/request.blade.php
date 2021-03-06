<x-app-layout>
    {{-- @flasher_render --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Point request') }}
            </h2>
            <div class="min-w-max">
                <a class="fullwidth-btn" href="{{ route('dashboard.create') }}">Add new Page</a>
            </div>
        </div>
    </x-slot>




    <div class="create-employee-area gr-login-area">
        <div class="container w-5/12">
            <div class=" ">
                <div class="">
                    <div class="gr-employee-title text-center">
                        <h1>Request Point</h1>
                        <span class="text-red-500">You have requested {{ $request_count. '/2'}}</span>
                    </div>
                    <form action="{{ route('dashboard.store') }}" method="POST" class="create-employee-form">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <label class="block mb-1" for="point">Point</label>
                            <input type="text" name="points" class="block mb-3 w-full" id="points" placeholder="Point"
                                value="{{ old('point') }}" class="form-control">
                            <span style="color:red">{{ $errors->first('points') }}</span>
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
