<template>
    <Head title="Dashboard"></Head>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg text-center">
                    <div class="pt-6 text-2xl text-gray-900 dark:text-gray-100">
                        <GreetingMessage/>
                        {{ $page.props.auth.user.name }}.
                    </div>

                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <QuotesAPI/>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg text-center">
                <DashboardGrid/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import GreetingMessage from '@/Components/GreetingMessage.vue';
import QuotesAPI from "@/Components/QuotesAPI.vue";
import DashboardGrid from "@/Components/DashboardGrid.vue";
</script>

<style scoped>
ul {
    list-style-type: circle;
    padding-left: 1rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.vue-grid-layout {
    background: #eee;
}

.vue-grid-item:not(.vue-grid-placeholder) {
    background: #ccc;
    border: 1px solid black;
}

.vue-grid-item .resizing {
    opacity: 0.9;
}

.vue-grid-item .static {
    background: #cce;
}

.vue-grid-item .text {
    font-size: 24px;
    text-align: center;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    margin: auto;
    height: 100%;
    width: 100%;
}

.vue-grid-item .no-drag {
    height: 100%;
    width: 100%;
}

.vue-grid-item .minMax {
    font-size: 12px;
}

.vue-grid-item .add {
    cursor: pointer;
}

.vue-draggable-handle {
    position: absolute;
    width: 20px;
    height: 20px;
    top: 0;
    left: 0;
    background: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='10' height='10'><circle cx='5' cy='5' r='5' fill='#999999'/></svg>") no-repeat;
    background-position: bottom right;
    padding: 0 8px 8px 0;
    background-repeat: no-repeat;
    background-origin: content-box;
    box-sizing: border-box;
    cursor: pointer;
}
</style>
