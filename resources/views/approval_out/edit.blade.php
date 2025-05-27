<x-layout.default>
    <div class="panel">
        <div class="flex items-center justify-between mb-5">
            <h5 class="font-semibold text-lg dark:text-white-light">Edit Approval Out</h5>
        </div>
        <div class="mb-5">
            <form class="space-y-5" action="{{ route('approval-outs.update', $approval_out) }}" method="POST">
                @csrf
                @method('PUT')
                @include('approval_out._form', ['approval' => $approval_out])
            </form>
        </div>
    </div>
</x-layout.default>
