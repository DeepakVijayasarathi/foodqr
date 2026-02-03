<template>
    <LoadingComponent :props="loading" />
    <div class="col-12 xl:col-6">
        <div class="db-card">
            <div class="db-card-header">
                <div class="db-card-title">{{ $t('label.most_popular_items') }}</div>
            </div>
            <div class="db-card-body">
                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <li v-if="popular_items.length > 0" v-for="popular_item in popular_items" :key="popular_item"
                        class="w-full flex rounded-xl overflow-hidden bg-white shadow-sm hover:shadow-md transition-shadow">
                        <img class="w-24 h-24 object-cover" :src="popular_item.thumb" alt="product">
                        <div class="py-3 px-4 flex flex-col justify-between overflow-hidden">
                            <h4 class="text-sm font-medium truncate">{{ popular_item.name }}</h4>
                            <h5 class="text-xs font-medium text-indigo-600 truncate">{{ popular_item.category_name }}</h5>
                            <h6 class="text-sm font-bold text-gray-800">{{ popular_item.currency_price }}</h6>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import LoadingComponent from "../components/LoadingComponent";
export default {
    name: "MostPopularItemsComponent",
    components: { LoadingComponent },
    data() {
        return {
            loading: {
                isActive: false,
            },
            popular_items: {},
        };
    },
    mounted() {
        this.popularItems();
    },
    methods: {
        popularItems: function () {
            this.loading.isActive = true;
            this.$store.dispatch('dashboard/mostPopularItems').then(res => {
                this.popular_items = res.data.data;
                this.loading.isActive = false;
            }).catch((err) => {
                this.loading.isActive = false;
            });
        },
    },
}
</script>
