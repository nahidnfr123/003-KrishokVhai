<template>
    <div
        class="d-flex mb-1 text-left text-sm rounded shadow justify-content-start align-items-center bg-white"
        :class="[{'cursor-move':draggable}, AddClass]"
        :id="taskData.id"
        :taskId="taskData.id"
        :draggable="draggable"
        @dragstart="dragStart($event, taskData.todo_id)"
        @dragend="dragEnd"
        @dragover.stop>
        <span v-if="taskData.status == 'completed'">
            <svg class="p-0.5 w-5 h-5 stroke-current text-green-500 dark:text-green-300 feather feather-check-circle" xmlns="http://www.w3.org/2000/svg"
                 style="height: 20px; width: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
               <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
               <polyline points="22 4 12 14.01 9 11.01"></polyline>
           </svg>
        </span>
        <span v-else-if="taskData.status == 'doing'">
            <svg class="w-5 h-5 stroke-current text-yellow-600 dark:text-yellow-400" style="height: 20px; width: 20px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"/>
              <rect x="9" y="3" width="6" height="4" rx="2"/>
              <path d="M9 14l2 2l4 -4"/>
            </svg>
        </span>
        <span v-else>
            <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" style="height: 20px; width: 20px;" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
        </span>

        <slot/>

    </div>
</template>

<script>

export default {
    name: 'DraggableItem',
    props: ['taskData', 'draggable', 'AddClass'],
    data() {
        return {}
    },
    methods: {
        dragStart: (e, todoId) => {
            e.dataTransfer.dropEffect = 'move';
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('todo_Id', todoId);
            // Hide item once a item is being dragged ...
            const target = e.target;
            e.dataTransfer.setData('card_id', target.id);
            setTimeout(() => {
                target.style.display = "none";
            }, e);
        },
        dragEnd: e => {
            // This is required for bringing back items if dropped in wrong place ....
            const target = e.target;
            setTimeout(() => {
                target.style.display = "flex";
            }, e);
        }
    },
}
</script>
