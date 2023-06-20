<template>
    <div>
        <button class="delete-button" @click="showConfirmationDialog()">
            <i class="fa-solid fa-trash transition-colors text-2xl hover:text-red-500"></i>
        </button>
        <transition name="fade">
            <div v-if="showDialog" class="modal-wrapper">
                <div
                    class="modal-content bg-white dark:bg-gray-800 shadow-light-shadow hover:shadow-lighter-shadow transition duration-500 sm:rounded-lg">
                    <p>{{ confirmationMessage }}</p>
                    <div class="button-wrapper">
                        <button @click="confirmDelete()">
                            <i class="fa-solid fa-square-check transition-colors text-2xl hover:text-green-500"></i>
                        </button>
                        <button @click="cancelDelete">
                            <i class="fa-solid fa-square-xmark transition-colors text-2xl hover:text-red-500"></i>
                        </button>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
import {useToast} from "vue-toastification";

export default {
    data() {
        return {
            showDialog: false,
            confirmationMessage: "Are you sure you want to delete this item?",
        };
    },
    props: {
        item: {
            type: String, // Adjust the type according to your item ID's data type
            required: true,
        },
        refresh: {
            type: Function, // Specify the prop type as a function
            required: true,
        },
    },
    methods: {
        showConfirmationDialog() {
            this.showDialog = true;
        },
        confirmDelete() {
            const todoItemId = this.item.id;
            this.$emit("item-deleted");
            axios.delete(`/api/todo/${todoItemId}`)
            this.showDialog = false;
            this.refresh(); // Fetch the updated list of items
            const toast = useToast(); // Access the useToast function
            toast.success('This item has been successfully deleted.', {
                position: 'top-right',
                timeout: 3000,
                transition: 'fade',
            });
        },
        cancelDelete() {
            this.showDialog = false;
        },
    },
};
</script>

<style scoped>
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

.modal-content {
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

.button-wrapper {
    display: flex;
    justify-content: flex-end;
    margin-top: 1rem;
}

.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.3s;
}

.modal-enter,
.modal-leave-to {
    opacity: 0;
}

.delete-button {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
}

.fa-square-check,
.fa-square-xmark {
    font-size: 2rem;
}
</style>
