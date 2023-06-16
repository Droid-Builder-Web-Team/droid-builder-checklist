<template>
    <div>
        <div class="grid-stack"></div>
    </div>
</template>

<script>
import 'gridstack/dist/gridstack.min.css';
import 'gridstack/dist/gridstack-all.js';
import {GridStack} from "gridstack";

export default {
    mounted() {
        let items = [
            {content: 'my first widget'},
            {w: 2, content: 'another longer widget!'}
        ];
        let grid = GridStack.init();
        console.log(items);
        grid.load(items);
    }
};

</script>

<style scoped>
.grid-stack {
    background: #FAFAD2;
}

.grid-stack-item-content {
    background-color: #18BC9C;
}
</style>
