<template>
    <div class="modal-header grid grid-cols-2">
        <h3>Add a new item</h3>
        <button class="justify-self-end close-button transition-colors" @click="closeModal">
            <i class="fa-solid fa-x"></i>
        </button>
    </div>

    <div class="form-item">
        <label>Assign this item to a droid you're building:</label>
        <select v-model="todoItem.user_droid_id" name="user_droid_id">
            <option>You're not building any droids</option>
        </select>
    </div>
    <div class="form-item">
        <label>Item Description:</label>
        <textarea v-model="todoItem.text" name="text" placeholder="Patch Death Star Exhaust Port..."></textarea>
    </div>

    <div class="button-wrapper">
        <button
            class="inline-block px-6 py-1 transition-colors text-gray-100 border border-gray-100 rounded hover:bg-gray-100 hover:text-gray-900 active:bg-gray-100 focus:outline-none focus:ring"
            @click="closeModal">Cancel
        </button>
        <button
            class="inline-block px-6 py-1 transition-colors text-gray-100 border border-gray-100 rounded hover:bg-gray-100 hover:text-gray-900 active:bg-gray-100 focus:outline-none focus:ring"
            @click="saveModal">Save
        </button>
    </div>
</template>

<script>
import {useToast} from 'vue-toastification'; // Import the useToast function

export default {
    props: ["userTodo", "closeModal"],

    data() {
        return {
            todoItem: {
                user_droid_id: null,
                text: '',
            },
        }
    },

    methods: {
        saveModal() {
            if (!this.todoItem.user_droid_id && this.todoItem.text === '') {
                let error = 'You cannot submit an empty form.';
                this.showFailureNotification(error);
            } else {
                axios.post('/api/todo/store', {
                    todoItem: this.todoItem
                })
                    .then(response => {
                        if (response.status === 201) {
                            this.todoItem.user_droid_id = ""
                            this.todoItem.text = "";
                            this.$emit("item-added"); // Emit the "item-added" event
                            this.showSuccessNotification();
                        }
                    })
                    .catch(error => {
                        this.showFailureNotification(error);
                    })
            }
        },
        handleButtonClick() {
            this.closeModal(); // Call the parent component's closeModal method
        },

        showSuccessNotification() {
            const toast = useToast(); // Access the useToast function
            toast.success('Item Successfully Added', {
                position: 'top-right',
                timeout: 3000,
                transition: 'fade'
            });
        },

        showFailureNotification(error) {
            const toast = useToast(); // Access the useToast function
            toast.error('There was a problem adding this item!' + ' ' + error, {
                position: 'top-right',
                timeout: 3000,
                transition: 'fade'
            });
        }
    }
};
</script>

<style>
.form-item {
    padding-block: 1rem;
    display: flex;
    flex-direction: column;
    width: 100%;
}

.modal-header {
    width: 100%;
}

h3 {
    font-size: 1.5rem;
}

.button-wrapper {
    padding-top: 1rem;
    display: flex;
    gap: 2rem;
}

.close-button:hover svg path {
    fill: #9ca3af;
}
</style>
