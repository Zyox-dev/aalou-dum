<x-layout.default>
    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="javascript:;" class="text-primary hover:underline">User</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Profile</span>
            </li>
        </ul>
        <div class="pt-5">
            <!-- Stack -->
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Update Basic Info</h5>

                </div>
                <div class="mb-5">
                    <form class="space-y-5" method="POST" action={{ route('profile.update') }}>
                        @csrf
                        <div>
                            <input type="text" name='name' placeholder="Enter Your Name"
                                value="{{ $user->name }}" class="form-input" />
                            @error('name')
                                <span class="text-danger text-[11px] inline-block mt-1">
                                    {{ $message }}</span>
                            @enderror

                        </div>
                        <div>
                            <input type="email" name="email" value={{ $user->email }}
                                placeholder="Enter Your Email" class="form-input" />
                            @error('email')
                                <span class="text-danger text-[11px] inline-block mt-1">
                                    {{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary !mt-6">Submit</button>
                    </form>
                </div>

            </div>
        </div>

        <div class="pt-5">
            <!-- Stack -->
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Update Password</h5>

                </div>
                <div class="mb-5">
                    <form class="space-y-5" method="POST" action={{ route('profile.update_password') }}>
                        @csrf
                        <div>
                            <input type="password" name="password_old" placeholder="Enter Your old Password"
                                class="form-input" />
                            @error('password_old')
                                <span class="text-danger text-[11px] inline-block mt-1">
                                    {{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <input type="password" name="password" placeholder="Enter New Password"
                                class="form-input" />
                            @error('password')
                                <span class="text-danger text-[11px] inline-block mt-1">
                                    {{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <input type="password" name="password_confirmation" placeholder="Enter New Password Again"
                                class="form-input" />
                            @error('password_confirmation')
                                <span class="text-danger text-[11px] inline-block mt-1">
                                    {{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary !mt-6">Submit</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-layout.default>
