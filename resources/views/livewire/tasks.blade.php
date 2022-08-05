<div>
    <ul wire:sortable="updateOrder" class="grid grid-rows gap-4">
        @foreach ($tasks as $task)
        <li wire:sortable.item="{{ $task->id }}" wire:key="task-{{ $task->id }}" wire:sortable.handle class="w-full cursor-move bg-white px-2 py-4 inline-flex justify-between rounded-lg border">
            <div>
                <h4 class="pl-2">{{ $task->display_order }}. {{ $task->description }}</h4>
            </div>
            <button wire:click="removeTask({{ $task->id }})" class="mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-all hover:text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </li>
        @endforeach
    </ul>
</div>
