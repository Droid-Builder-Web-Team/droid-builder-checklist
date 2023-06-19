<template>
    <div class="modal-header flex items-center justify-between">
        <h3>Add a new item</h3>
        <button class="flex content-center" @click="closeModal">
            <i class="fa-solid fa-x"></i>
        </button>
    </div>
    <div class="form-item">
        <label>Assign this item to a droid you're building:</label>
        <select>
            <option>You're not building any droids</option>
        </select>
    </div>
    <div class="form-item">
        <label>Item Description:</label>
        <textarea v-model="todoItem.text" placeholder="Patch Death Star Exhaust Port..."></textarea>
    </div>
    <button @click="showSuccessNotification">Show Success Notification</button>

    <button @click="saveModal">Save</button>
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
            }
        }
    },

    methods: {
        saveModal() {
            if (this.todoItem.text === '') {
                return;
            }

            axios.post('/api/todo/store', {
                todoItem: this.todoItem
            })
                .then(response => {
                    if (response.status === 201) {
                        this.todoItem.user_droid_id = ""
                        this.todoItem.text = "";
                        this.$emit("item-added"); // Emit the "item-added" event
                    }
                })
                .catch(error => {
                    console.log(error);
                })
        },

        handleButtonClick() {
            this.closeModal(); // Call the parent component's closeModal method
        },

        showSuccessNotification() {
            const toast = useToast(); // Access the useToast function
            toast.success('Custom notification message', {
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
    display: flex;
}

h3 {
    font-size: 1.5rem;
}
</style>
