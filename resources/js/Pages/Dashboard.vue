<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import GreetingMessage from '@/Components/GreetingMessage.vue';
import QuotesAPI from "@/Components/QuotesAPI.vue";
</script>

<template>
    <Head title="Dashboard"></Head>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-center">
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

        <div class="grid grid-cols-4 gap-2">
            <div>
                <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 w-100 flex flex-1 flex-col gap-2 text-gray-900 dark:text-gray-100 text-base">
                            <p class="uppercase">Active Builds</p>
                            <span class="text-xl">10</span>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 w-100 flex flex-1 flex-col gap-2 text-gray-900 dark:text-gray-100 text-base">
                            <p class="uppercase">Completed Builds</p>
                            <span class="text-xl">5</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row-span-3 col-span-2">
                <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100 text-base flex flex-1 gap-2 flex-col">
                            <p class="uppercase">Notifications</p>
                            <ul>
                                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sem.</li>
                                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sem.</li>
                                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sem.</li>
                                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sem.</li>
                                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sem.</li>
                                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sem.</li>
                                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sem.</li>
                                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sem.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


