<template>
    <div>
        <div className="grid-stack my-4"></div>
    </div>
</template>

<script>
import 'gridstack/dist/gridstack.min.css';
import 'gridstack/dist/gridstack-extra.min.css';
import 'gridstack/dist/gridstack-all.js';
import {GridStack} from 'gridstack';

export default {
    mounted() {
        let items = [
            {title: 'Title 1', content: 'Content 1'},
            {title: 'Title 2', content: 'Content 2'},
            {title: 'Title 3', content: 'Content 3'},
        ];
        let grid = GridStack.init({column: 3});
        grid.load(items);

        this.$nextTick(() => {
            const elements = document.querySelectorAll('.grid-stack > .grid-stack-item');
            elements.forEach((element, index) => {
                element.classList.add('max-w-7xl', 'mx-auto', 'sm:px-2', 'lg:px-4');

                const innerElement = element.querySelector('.grid-stack-item-content');
                // the main cards
                innerElement.classList.add(
                    'bg-white',
                    'dark:bg-gray-900',
                    'overflow-hidden',
                    'shadow-light-shadow',
                    'hover:shadow-lighter-shadow',
                    'transition',
                    'duration-500',
                    'sm:rounded-lg',
                    'cursor-move'
                );

                // Clear the existing content
                innerElement.innerHTML = '';

                // Wrapper Div
                const wrapperDiv = document.createElement('div');
                wrapperDiv.classList.add(
                    'p-6',
                    'w-100',
                    'flex',
                    'flex-1',
                    'flex-col',
                    'gap-2',
                    'text-gray-900',
                    'dark:text-gray-100',
                    'text-base'
                );
                innerElement.appendChild(wrapperDiv);

                // Create a new <div> element for the title
                const titleDiv = document.createElement('div');
                titleDiv.classList.add('uppercase', 'underline', 'underline-offset-sm', 'font-bold', 'mb-2', 'text-white');
                titleDiv.textContent = items[index].title;

                // Create a new <div> element for the content
                const contentDiv = document.createElement('div');
                contentDiv.classList.add('content', 'text-base', 'mt-2');
                contentDiv.textContent = items[index].content;

                // Append the title and content divs to the wrapperDiv
                wrapperDiv.appendChild(titleDiv);
                wrapperDiv.appendChild(contentDiv);
            });
        });
    },
};
</script>

<style scoped>
.grid-stack-item {
    min-width: 600px;
    min-height: 800px;
    width: 100%;
    height: 100%;
}
</style>
