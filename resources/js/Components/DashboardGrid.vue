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
    data() {
        return {
            items: [
                {
                    id: 1,
                    title: 'Active Builds',
                    content: 'You are currently working on: R2-D2, R5-D4, BB8',
                    x: 0,
                    y: 0,
                    w: 0,
                    h: 0
                },
                {id: 2, title: 'Todo List', content: 'Hurray! Nothing to do!', x: 1, y: 0, w: 0, h: 0},
                {id: 3, title: 'Notifications', content: 'No new notifications', x: 2, y: 0, w: 0, h: 0},
            ],
        };
    },

    mounted() {
        let grid = GridStack.init({column: 3});

        // Load the user's preset grid arrangement if it exists
        const savedGrid = Cookies.get('gridArrangement');
        const parsedGrid = savedGrid ? JSON.parse(savedGrid) : null;

        // Add missing blocks to the items array
        if (parsedGrid) {
            const existingCoordinates = this.items.map((item) => `${item.x}-${item.y}`);
            this.items = mapGridItems(parsedGrid, this.items);
            this.items.forEach((item) => {
                const element = document.querySelector(`[data-gs-x="${item.x}"][data-gs-y="${item.y}"]`);
                if (element) {
                    item.w = element.clientWidth;
                    item.h = element.clientHeight;
                }
            });

            parsedGrid.forEach((block) => {
                const coordinates = `${block.x}-${block.y}`;
                if (!existingCoordinates.includes(coordinates)) {
                    this.items.push({
                        id: block.id,
                        title: '',
                        content: '',
                        x: block.x,
                        y: block.y,
                        w: block.w,
                        h: block.h
                    });
                }
            });
        } else {
            // Set the default grid arrangement cookie
            this.items.forEach((item) => {
                const element = document.querySelector(`[data-gs-x="${item.x}"][data-gs-y="${item.y}"]`);
                if (element) {
                    item.w = element.getAttribute('data-gs-width');
                    item.h = element.getAttribute('data-gs-height');
                }
            });

            const serializedGrid = JSON.stringify(this.items);
            Cookies.set('gridArrangement', serializedGrid);
        }

        grid.load(this.items);

        // Save the user's grid arrangement to the cookie session
        grid.on('change', (event, changedItems) => {
            // Update the changed items with their new values
            changedItems.forEach((changedItem) => {
                const {x, y, title, content} = changedItem;
                const existingItem = this.items.find((item) => item.x === x && item.y === y);
                if (existingItem) {
                    existingItem.title = title;
                    existingItem.content = content;
                    existingItem.x = changedItem.x;
                    existingItem.y = changedItem.y;
                    existingItem.w = changedItem.w;
                    existingItem.h = changedItem.h;
                }
            });
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
                    'hover:shadow-light-shadow',
                    'transition',
                    'duration-500',
                    'sm:rounded-lg',
                    'cursor-move',
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
                    titleDiv.textContent = this.items[index].title;

                    const contentDiv = document.createElement('div');
                    contentDiv.classList.add('content', 'text-base', 'mt-2');
                    contentDiv.textContent = this.items[index].content;

                    // Append the title and content divs to the wrapperDiv
                    wrapperDiv.appendChild(titleDiv);
                    wrapperDiv.appendChild(contentDiv);
                }

                // Render the grid items
                this.updateGridUI(innerElement, this.items[index].title, this.items[index].content);
            });
        });
    },

    watch: {
        items: {
            deep: true,
            handler(newItems) {
                // Serialize and save only the updated items to the cookie
                const serializedGrid = JSON.stringify(mapGridItems(newItems));
                Cookies.set('gridArrangement', serializedGrid);
            }
        }
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
        id: item.id,
        title: item.title || '',
        content: item.content || '',
        x: item.x,
        y: item.y,
        w: item.w,
        h: item.h
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
