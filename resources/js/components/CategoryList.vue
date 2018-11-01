<template>
    <ul class="list-group">
        <li v-for="category in categories" :v-key="category.id" v-on:click="click(category.id)" :class="'list-group-item ' + (category.id === categoryId ? 'active': '')">
            {{ category.name }}
        </li>
    </ul>
</template>

<script>
    export default {
        name: "CategoryList",
        props: ['categories', 'onClick', 'categoryId'],
        methods: {
            click(id) {
                this.onClick(id);
            }
        },
        watch: {
            categoryId() {
                // console.log(this.selected, id, this.categoryId)
            }
        }
    }
</script>

<style scoped>

</style>