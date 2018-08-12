<template>
<div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-6">
                    <h4>Products</h4>
                </div>
                <div class="col-lg-6">
                    <div class="form-group float-right">
                        <router-link :to="{name: 'products-create'}" class="btn btn-primary">Create new product</router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <template v-if="products.length > 0">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity in stock</th>
                        <th>Price per item</th>
                        <th width="200">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(product, key) in products" :key="key">
                        <td>{{ product.name }}</td>
                        <td>{{ product.quantity }}</td>
                        <td>$ {{ product.price }}</td>
                        <td>
                            <router-link :to="{name: 'products-edit', params: {id: product.id}}" class="btn btn-xs btn-primary">
                                Edit
                            </router-link>
                            <a href="#" class="btn btn-xs btn-danger" v-on:click="deleteEntry(product.id, key)">
                                Delete
                            </a>
                        </td>
                    </tr>
                    <tr class="table-success">
                        <td colspan="2">Total Value:
                        </td>
                        <td id="total"> <b>$ {{ getTotalValue() }}</b></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            </template>
            <template v-else>
                <h2>No products created!</h2>
            </template>

        </div>
    </div>

</div>
</template>

<script>
export default {
    data: function () {
        return {
            products: []
        }
    },
    mounted() {
        var app = this;
        axios.get('/api/products')
            .then(function (resp) {
                app.products = resp.data;
            })
            .catch(function (resp) {
                alert("Could not load products");
            });
    },
    methods: {
        getTotalValue() {
            let total = 0;
            for (let index = 0; index < this.products.length; index++) {
                total += this.products[index].quantity * this.products[index].price;
            }
            return total.toFixed(2);
        },
        deleteEntry(id, index) {
            if (confirm("Do you really want to delete it?")) {
                var app = this;
                axios.delete('/api/products/' + id)
                    .then(function (resp) {
                        if (resp.data.code == 200) {

                            app.$notify.success({
                                title: 'Success',
                                message: resp.data.message
                            });

                            app.products.splice(index, 1);
                        } else {
                            app.$notify.error({
                                title: 'Error',
                                message: resp.data.message
                            });
                        }
                    })
                    .catch(function (resp) {
                        app.$notify.error({
                            title: 'Error',
                            message: 'There was an error'
                        });
                    });
            }
        }
    }
}
</script>