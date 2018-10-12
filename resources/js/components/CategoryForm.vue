<template>
    <form v-on:submit.prevent="saveCategory">
        <div class="form-group">
            <label for="name">Category name</label>
            <input id="name" v-model="category.name" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="type">Category type</label>
            <select id="type" v-model="category.type" class="form-control">
                <option value="1">Income</option>
                <option value="2">Expanse</option>
            </select>
        </div>
        <div class="form-group">
            <label for="icon">Category icon</label>
            <input id="icon" v-model="category.icon" class="form-control"/>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <button v-if="categoryId !== null" type="submit" class="btn btn-danger" v-on:click.prevent="deleteCategory">Delete (Can't be undone)</button>
    </form>
</template>

<script>
    import axios from 'axios'

    export default {
        name: "CategoryForm",
        props: ['categoryId', 'onSave', 'onDelete'],
        data: () => ({
            category: {
                name: '',
                type: 1,
                icon: '',
            }
        }),
        methods: {
            saveCategory () {
                let path = '/category';
                let request = null
                if (this.categoryId == null) {
                    request = axios.post(path + '/' + this.categoryId, this.category)
                } else {
                    request = axios.put(path + '/' + this.categoryId, this.category)
                }
                request.then(() => {
                    this.onSave()
                })
            },
            deleteCategory () {
                axios.delete('/category/' + this.categoryId).then(() => {
                    this.onDelete()
                })
            }
        },
        watch:{
            categoryId () {
                if (this.categoryId !== null) {
                    axios.get('/category/' + this.categoryId).then(value => {
                        value = value.data
                        this.category.name = value.name
                        this.category.type = value.type
                        this.category.icon = value.icon
                        console.log(value)
                    })
                } else {
                    this.category.name = ''
                    this.category.type = 1
                    this.category.icon = ''
                }
            }
        }
    }
</script>

<style scoped>

</style>