<x-layout.default>
    <div class="panel">
        <div class="flex items-center justify-between mb-5">
            <h5 class="font-semibold text-lg dark:text-white-light">New Approval Out</h5>
        </div>
        <div class="mb-5">
            <form class="space-y-5" action="{{ route('approval-outs.store') }}" method="POST">
                @csrf
                @include('approval_out._form')
            </form>
        </div>
    </div>
</x-layout.default>
