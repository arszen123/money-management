<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Categories income</div>

                <div class="card-body">
                    <wallet-list :wallets="wallets"/>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Categories expense</div>

                <div class="card-body">
                    <wallet-form />
                </div>
            </div>
            <div class="card">
                <div class="card-header">Categories</div>

                <div class="card-body">
                    <category-form :category-id="categoryId" :on-save="onSave" :on-delete="onDelete"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import WalletList from "./WalletList";
    import WalletForm from "./WalletForm";
    export default {
        name: "WalletView",
        components: {WalletForm, WalletList},
        props: ['wallets'],

    }
</script>

<style scoped>

</style>