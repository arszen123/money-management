<template>
    <form v-on:submit.prevent="saveCategory">
        <div class="form-group">
            <label for="name">Category name</label>
            <input id="name" v-model="category.name" class="form-control"/>
            <div v-if="errors.name !== null" class="invalid-feedback">{{ errors.name }}</div>
        </div>
        <div class="form-group">
            <label for="icon">Category icon</label>
            <input id="icon" v-model="category.icon" class="form-control"/>
            <div v-if="errors.icon !== null" class="invalid-feedback">{{ errors.icon }}</div>
        </div>
        <div class="form-group" v-if="categoryId === null">
            <label for="type">Category type</label>
            <select id="type" v-model="category.type" class="form-control">
                <option value="1">Income</option>
                <option value="2">Expanse</option>
            </select>
            <div v-if="errors.type !== null" class="invalid-feedback">{{ errors.type }}</div>
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
            },
            errors: {
                name: null,
                type: null,
                icon: null,
            }
        }),
        methods: {
            saveCategory () {
                let path = '/category';
                let request = null
                if (this.categoryId == null) {
                    request = axios.post(path, this.category)
                } else {
                    request = axios.put(path + '/' + this.categoryId, this.category)
                }
                request.then(() => {
                    this.$emit('save');
                    this.$notify({
                        group: 'notification',
                        title: 'Saved!',
                        text: 'Category saved successfully!',
                        type: 'success'
                    });
                }).catch(reason => {
                    let errors = reason.response.data.errors
                    this.errors = {
                        name: null,
                        type: null,
                        icon: null,
                    };
                    for (let error in errors) {
                        this.errors[error] = errors[error][0];
                    }
                })
            },
            deleteCategory () {
                axios.delete('/category/' + this.categoryId).then(() => {
                    this.$emit('delete');
                    this.$notify({
                        group: 'notification',
                        title: 'Deleted!',
                        text: 'Category deleted successfully!',
                        type: 'error'
                    });
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
    .invalid-feedback {
        display: inherit;
    }
</style>