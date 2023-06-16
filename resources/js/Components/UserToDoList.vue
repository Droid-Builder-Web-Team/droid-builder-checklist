<script>
export default {
    data() {
        return {
            items: [
                'ToDo List Item',
                'ToDo List Item',
                'ToDo List Item',
                'ToDo List Item',
                'ToDo List Item',
                'ToDo List Item',
                'ToDo List Item',
                'ToDo List Item',
            ]
        };
    },

    computed: {
        currentNumber() {
            return this.items.length > 0 ? 1 : 0;
        }
    }
};
</script>

<template>
    <div class="col-span-2">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-light-shadow hover:shadow-lighter-shadow transition duration-500 sm:rounded-lg">
                <div class="p-6 w-100 flex flex-1 flex-col gap-2 text-gray-900 dark:text-gray-100 text-base">
                    <p class="uppercase underline underline-offset-sm font-bold mb-2">My Todo List</p>
                    <ul class="custom-list">
                        <li v-for="(item, index) in items" :key="index"
                            class="flex items-center even:bg-gray-600 odd:bg-gray-800">
                            <span class="list-number">{{ index + 1 }}.</span>
                            <span class="list-item">{{ item }}</span>
                            <div class="button-wrapper flex flex-row gap-4">
                                <button>
                                    <i class="fa-solid fa-square-check transition-colors text-2xl hover:text-green-500"></i>
                                </button>
                                <button>
                                    <i class="fa-solid fa-trash transition-colors text-2xl hover:text-red-500"></i>
                                </button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.custom-list {
    padding-left: 1rem;
    list-style-type: none;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.custom-list li {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.list-number {
    font-weight: bold;
}

.list-item {
    flex-grow: 1;
}
</style>
