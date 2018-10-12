<template>
    <ul class="list-group">
        <li v-for="category in categories" :v-key="category.id" v-on:click="click(category.id)" :class="'list-group-item ' + (category.id === selected ? 'active': '')">
            {{ category.name }}
        </li>
    </ul>
</template>

<script>
    export default {
        name: "CategoryList",
        props: ['categories', 'onClick'],
        data: () => ({
            selected: null
        }),
        methods: {
            click(id) {
                this.selected = this.onClick(id);
            }
        }
    }
</script>

<style scoped>

</style>