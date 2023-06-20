<template>
    <div class="col-span-2">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-light-shadow hover:shadow-lighter-shadow transition duration-500 sm:rounded-lg">
                <div class="p-6 w-100 flex flex-1 flex-col gap-2 text-gray-900 dark:text-gray-100 text-base">
                    <p class="uppercase underline underline-offset-sm text-center font-bold mb-2">My Todo List</p>
                    <button
                        v-if="!visible"
                        class="w-fit mx-auto my-2 px-6 py-1 flex items-center gap-3 group transition-colors text-gray-100 border border-gray-100 rounded hover:bg-gray-100 hover:text-gray-900 active:bg-gray-100 focus:outline-none focus:ring" @click="handleButtonClick">Add New Item<i
                        class="fa-solid fa-plus group-hover:rotate-45"></i></button>


                    <Teleport to="body">
                        <transition name="fade">
                            <div
                                v-show="visible"
                                class="modal-wrapper"
                                @click.self="closeModal"
                            >
                                <div v-show="open"
                                     class="todo-modal bg-white dark:bg-gray-800 shadow-light-shadow hover:shadow-lighter-shadow transition duration-500 sm:rounded-lg">
                                    <add-todo-item-form
                                        v-show="open && visible"
                                        :closeModal="closeModal"
                                        @close="closeModal"
                                        @item-added="handleItemAdded"
                                    />
                                </div>
                            </div>
                        </transition>
                    </Teleport>
                    <ul v-if="userTodo.length > 0" class="custom-list--user-todo text-center">
                        <li v-for="(item, index) in userTodo" :key="index"
                            class="grid grid-cols-3 items-center justify-evenly even:bg-gray-600 odd:bg-gray-800"
                            v-on:itemchanged="$emit('reloadlist')"
                            v-on:reloadlist="fetchUserTodo()">
                            <span class="list-item">{{ item.text }}</span>
                            <span v-if="item.user_droid_id !== null">{{ item.user_droid.mainframe_droid.name }}</span>
                            <span v-else>Not assigned to a build</span>
                            <div class="button-wrapper flex flex-row justify-center gap-4">
                                <button @click="completeTodoItem(item.id)" @item-updated="handleItemUpdated">
                                    <i class="fa-solid fa-square-check transition-colors text-2xl hover:text-green-500"></i>
                                </button>
                                <confirm-delete :item="item" :refresh="fetchUserTodo" @delete="deleteTodoItem(item.id)">
                                    <!-- Customize the confirmation message or UI elements here if needed -->
                                </confirm-delete>
                            </div>
                        </li>
                    </ul>
                    <div v-else><p class="text-center">Hurray! You have nothing to do!</p></div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import AddTodoItemForm from "@/Components/AddTodoItemForm.vue";
import ConfirmDelete from "@/Components/ConfirmDelete.vue";
import {useToast} from "vue-toastification";
import axios from "axios";


export default {
    components: {
        AddTodoItemForm,
        ConfirmDelete,
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

        completeTodoItem(todoItemId) {
            axios.put(`/api/todo/${todoItemId}`, {
                completed: 1,
            })
                .then(response => {
                    if (response.status === 201) {
                        this.$emit("item-changed");
                        this.fetchUserTodo();
                        const toast = useToast(); // Access the useToast function
                        toast.success('Item Successfully Completed', {
                            position: 'top-right',
                            timeout: 3000,
                            transition: 'fade'
                        });
                    }
                })
                .catch(error => {
                    const toast = useToast(); // Access the useToast function
                    toast.error('There was a problem completing this item!' + ' ' + error, {
                        position: 'top-right',
                        timeout: 3000,
                        transition: 'fade'
                    });
                })
        },

        handleItemUpdated() {
            this.fetchUserTodo(); // Fetch the updated list of items
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
    flex-wrap: wrap;
    flex-direction: column;
    gap: 0.5rem;
}

.custom-list li {
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
