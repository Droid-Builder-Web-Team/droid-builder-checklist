<template>
    <div class="col-span-2">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-light-shadow hover:shadow-lighter-shadow transition duration-500 sm:rounded-lg">
                <div class="p-6 w-100 flex flex-1 flex-col gap-2 text-gray-900 dark:text-gray-100 text-base">
                    <p class="uppercase underline underline-offset-sm font-bold mb-2">My Todo List</p>
                    <button v-if="!visible" @click="handleButtonClick">Add New Item</button>

                    <Teleport to="body">
                        <transition name="fade">
                            <div
                                v-show="visible"
                                class="modal-wrapper"
                                @click.self="closeModal"
                            >
                                <transition name="fade">
                                    <div v-show="open" class="todo-modal"
                                    >
                                        <add-todo-item-form
                                            v-show="open && visible"
                                            :closeModal="closeModal"
                                            @close="closeModal"
                                            @item-added="handleItemAdded"
                                        />
                                    </div>
                                </transition>
                            </div>
                        </transition>
                    </Teleport>
                    <ul v-if="userTodo.length > 0" class="custom-list--user-todo">
                        <li v-for="(item, index) in userTodo" :key="index"
                            class="flex items-center justify-evenly even:bg-gray-600 odd:bg-gray-800"
                            v-on:itemchanged="$emit('reloadlist')"
                            v-on:reloadlist="fetchUserTodo()">
                            <span class="list-item">{{ item.text }}</span>
                            <span v-if="item.user_droid_id !== null">{{ item.user_droid.mainframe_droid.name }}</span>
                            <span v-else>Not assigned to a build</span>
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
                    <div v-else><p>Hurray! You have nothing to do!</p></div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import AddTodoItemForm from "@/Components/AddTodoItemForm.vue";

export default {
    components: {
        AddTodoItemForm,
    },

    data() {
        return {
            userTodo: [],
            open: false,
            visible: false,
        };
    },

    mounted() {
        this.fetchUserTodo();
    },
    methods: {
        fetchUserTodo() {
            // Make your API fetch here to get user to do list and related droids
            // Once you have the response, assign the relevant droids data to userDroids
            fetch('/api/todo-list')
                .then(response => response.json())
                .then(data => {
                    this.userTodo = data;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        handleItemAdded() {
            this.fetchUserTodo(); // Fetch the updated list of items
        },

        handleButtonClick() {
            setTimeout(() => {
                this.modalVisible();
                this.modalOpen();
            }, 10);
        },

        modalVisible() {
            this.visible = true;
            document.body.style.overflow = 'hidden';
        },

        modalOpen() {
            this.open = true;
        },

        closeModal() {
            this.visible = false;
            this.open = false;
            document.body.style.overflow = '';

        },
    },
    transitions: {
        fade: {
            enterActiveClass: 'fade-enter-active',
            leaveActiveClass: 'fade-leave-active',
        },
    },
};
</script>

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

body.modal-open {
    overflow: hidden;
}

.modal-wrapper {
    width: 100%;
    height: 100vh;
    min-height: 50vh;
    overflow-y: auto;
    background-color: rgba(153, 162, 200, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    z-index: 1;
    top: 0;
    left: 0;
}

.todo-modal {
    min-height: 50%;
    min-width: 50%;
    background-color: #1a202c;
    color: #cbd5e0;
    z-index: 1024;
    margin-inline: auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding-inline: 2rem;
    pointer-events: auto;
}

.fade-enter-active,
.fade-leave-active {
    transition-property: opacity;
    transition-duration: 500ms;
    transition-timing-function: ease-in-out;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}
</style>
