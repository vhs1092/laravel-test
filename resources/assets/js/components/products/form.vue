<template>
<div>

    <div class="card">
        <div class="card-header">
            <router-link to="/" class="btn btn-danger">Back</router-link>
        </div>
        <div class="card-body">
            <div class="form-group col-lg-6">
                <el-form :model="products" :rules="rules" ref="products" label-width="200px" class="demo-products">
                    <el-form-item label="Product name" prop="name">
                        <el-input v-model="products.name"></el-input>
                    </el-form-item>
                    <el-form-item label="Quantity in stock" prop="quantity">
                        <el-input-number v-model="products.quantity" :min="1"></el-input-number>
                    </el-form-item>
                    <el-form-item label="Price per item" prop="price">
                        <money v-model="products.price" class="el-input__inner" v-bind="money"></money>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="saveForm('products')">Save</el-button>
                    </el-form-item>
                </el-form>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            products: {
                name: "",
                quantity: 0,
                price: 0
            },
            money: {
                decimal: '.',
                thousands: ',',
                prefix: '$ ',
                precision: 2,
                masked: false
            },
            rules: {
                name: [{
                        required: true,
                        message: 'Please input Activity name',
                        trigger: 'blur'
                    },
                    {
                        min: 3,
                        message: 'Length should be 3',
                        trigger: 'blur'
                    }
                ],
                quantity: [{
                        type: 'number',
                        required: true,
                        message: 'Please input the quantity',
                        trigger: 'blur'
                    }

                ],
                price: [{
                        required: true,
                        message: 'Please input the price',
                        trigger: 'blur'
                    }

                ]
            }

        };
    },
    mounted() {
        var app = this;
        let id = this.$route.params.id;
        if (id !== undefined) {
            //edit
            app.$loading({
                fullscreen: true
            });

            axios.get('/api/products/' + id)
                .then(function (resp) {
                    app.products = resp.data;
                    app.$loading({
                        fullscreen: true
                    }).close();
                })
                .catch(function (resp) {
                    app.$notify.error({
                        title: 'Error',
                        message: 'There was an error'
                    });
                });
        }
    },
    methods: {
        saveForm(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    var app = this;
                    var ProductData = app.products;
                    var productId = this.$route.params.id;
                    app.$loading({
                        fullscreen: true
                    });
                    if (productId === undefined) {
                        //* Create product
                        axios
                            .post("/api/products", ProductData)
                            .then(function (resp) {
                                if (resp.data.code == 200) {
                                    app.$notify.success({
                                        title: 'Success',
                                        message: resp.data.message
                                    });
                                    app.$loading({
                                        fullscreen: true
                                    }).close();
                                    app.$router.push({
                                        name: 'products'
                                    });
                                } else {
                                    app.$loading({
                                        fullscreen: true
                                    }).close();
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
                    } else {
                        //* Edit Product
                        axios
                            .put("/api/products/" + productId, ProductData)
                            .then(function (resp) {
                                if (resp.data.code == 200) {
                                    app.$notify.success({
                                        title: 'Success',
                                        message: resp.data.message
                                    });
                                    app.$loading({
                                        fullscreen: true
                                    }).close();
                                    app.$router.push({
                                        name: 'products'
                                    });
                                } else {
                                    app.$loading({
                                        fullscreen: true
                                    }).close();
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
                } else {
                    console.log('error submit!!');
                    return false;
                }
            });

        }
    }
};
</script>