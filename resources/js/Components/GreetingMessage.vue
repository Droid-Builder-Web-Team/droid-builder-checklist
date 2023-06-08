<script>
export default {
    computed: {
        greeting() {
            const currentTime = new Date();
            const hour = currentTime.getHours();
            let greeting = '';

            if (hour >= 5 && hour < 12) {
                greeting = 'Good Morning';
            } else if (hour >= 12 && hour < 18) {
                greeting = 'Good Afternoon';
            } else {
                greeting = 'Good Evening';
            }

            return greeting;
        }
    }
}
</script>

<template>
    {{ greeting }},
</template>

<style scoped>

</style>
