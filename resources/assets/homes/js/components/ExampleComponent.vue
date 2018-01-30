<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Example Component</div>

                    <div class="panel-body">
                        I'm an example component!
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<tab-container class="tab-container" v-model="sub_menu" swipeable>
    <mt-tab-container-item id="home">
        <home-index></home-index>
    </mt-tab-container-item>
    <mt-tab-container-item id="trading">
        <order-index :state=1></order-index>
    </mt-tab-container-item>
    <mt-tab-container-item id="has_been_completed">
        <order-index :state=2></order-index>
    </mt-tab-container-item>
    <mt-tab-container-item id="integral_exchange">
        <integral-exchange></integral-exchange>
    </mt-tab-container-item>
    <mt-tab-container-item id="integral_query">
        <integral-query></integral-query>
    </mt-tab-container-item>
    <mt-tab-container-item id="personal_info">
        <personal-info></personal-info>
    </mt-tab-container-item>
    <mt-tab-container-item id="skin_info">
        <skin-info></skin-info>
    </mt-tab-container-item>
</tab-container>