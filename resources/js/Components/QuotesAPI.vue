<template>
    <div v-if="quote" class="flex justify-center gap-4">
        <i class="fa-solid fa-quote-left"></i>
        <p><span class="italic">{{ quote.text }}</span> - {{ quote.author }}</p>
        <i class="fa-solid fa-quote-right"></i>
    </div>
    <div v-else>
        Loading quote...
    </div>
</template>

<script>
export default {
    data() {
        return {
            quote: null,
        };
    },
    mounted() {
        this.fetchQuote();
    },
    methods: {
        fetchQuote() {
            fetch("https://type.fit/api/quotes")
                .then((response) => response.json())
                .then((data) => {
                    const randomIndex = Math.floor(Math.random() * data.length);
                    this.quote = data[randomIndex];
                })
                .catch((error) => {
                    console.error("Error fetching quote:", error);
                });
        },
    },
};
</script>

<style scoped>
</style>
