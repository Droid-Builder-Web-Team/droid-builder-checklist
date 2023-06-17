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
import Cookies from 'js-cookie';

export default {
    mounted() {
        let items = [
            {title: 'Active Builds', content: 'You are currently working on: R2-D2, R5-D4, BB8', x: 0, y: 0},
            {title: 'Completed Builds', content: 'You have completed 10 Droids!', x: 1, y: 0},
            {title: 'Notifications', content: 'No new notifications', x: 2, y: 0},
        ];

        let grid = GridStack.init({column: 3});

        // Load the user's preset grid arrangement if it exists
        const savedGrid = Cookies.get('gridArrangement');
        const parsedGrid = savedGrid ? JSON.parse(savedGrid) : null;

        if (parsedGrid) {
            items = mapGridItems(parsedGrid, items);
        }

        // Add missing blocks to the items array
        if (parsedGrid) {
            const existingCoordinates = items.map((item) => `${item.x}-${item.y}`);
            parsedGrid.forEach((block) => {
                const coordinates = `${block.x}-${block.y}`;
                if (!existingCoordinates.includes(coordinates)) {
                    items.push({
                        title: '',
                        content: '',
                        x: block.x,
                        y: block.y,
                    });
                }
            });
        } else {
            // Set the default grid arrangement cookie
            const serializedGrid = JSON.stringify(items);
            Cookies.set('gridArrangement', serializedGrid);
        }

        grid.load(items);

        // Save the user's grid arrangement to the cookie session
        grid.on('change', (event, changedItems) => {
            // Create a copy of the original items array
            const updatedItems = items.slice();

            // Update the changed items with their new values
            changedItems.forEach((changedItem) => {
                const {x, y, title, content} = changedItem;
                const existingItem = updatedItems.find((item) => item.x === x && item.y === y);

                if (existingItem) {
                    existingItem.title = title;
                    existingItem.content = content;
                }
            });

            // Serialize and save only the updated items to the cookie
            const serializedGrid = JSON.stringify(mapGridItems(updatedItems));
            Cookies.set('gridArrangement', serializedGrid);
        });

        window.requestAnimationFrame(() => {
            const elements = Array.from(document.querySelectorAll('.grid-stack > .grid-stack-item')).sort((a, b) => {
                const aX = parseInt(a.getAttribute('data-gs-x'));
                const bX = parseInt(b.getAttribute('data-gs-x'));
                return aX - bX;
            });

            elements.forEach((element, index) => {
                element.classList.add('max-w-7xl', 'mx-auto', 'sm:px-2', 'lg:px-4');
                const innerElement = element.querySelector('.grid-stack-item-content');
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

                if (innerElement) {
                    const titleDiv = document.createElement('div');
                    titleDiv.classList.add('uppercase', 'underline', 'underline-offset-sm', 'font-bold', 'mb-2', 'text-white', 'title');
                    titleDiv.textContent = items[index].title;

                    const contentDiv = document.createElement('div');
                    contentDiv.classList.add('content', 'text-base', 'mt-2');
                    contentDiv.textContent = items[index].content;

                    // Append the title and content divs to the wrapperDiv
                    wrapperDiv.appendChild(titleDiv);
                    wrapperDiv.appendChild(contentDiv);
                }

                // Render the grid items
                this.updateGridUI(innerElement, items[index].title, items[index].content);
            });
        });
    },

    methods: {
        // Update the UI based on the grid arrangement
        updateGridUI(innerElement, title, content) {
            const titleElement = innerElement.querySelector('.title');
            const contentElement = innerElement.querySelector('.content');

            // Update the title and content
            titleElement.textContent = title;
            contentElement.textContent = content;
        },
    },
};

function mapGridItems(gridItems) {
    return gridItems.map((item) => ({
        title: item.title || '',
        content: item.content || '',
        x: item.x,
        y: item.y,
    }));
}
</script>

<style scoped>
.grid-stack-item {
    min-width: 600px;
    min-height: 800px;
    width: 100%;
    height: 100%;
}
</style>
