<template>
    <LoadingComponent :props="loading" />
    <div v-if="demo === 'true' || demo === 'TRUE' || demo === 'True' || demo === '1' || demo === 1"
        class="mb-4 bg-red-100 p-2 pl-4  rounded">
        <h2 class="mb-1">{{ $t('label.reminder') }}</h2>
        <p>{{ $t('label.data_reset') }}</p>
    </div>

    <div class="mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between gap-6">
                <div>
                    <h3 class="font-semibold text-2xl text-primary">{{ visitorMessage() }}</h3>
                    <h4 class="font-medium text-lg text-gray-700">{{ authInfo.name }}</h4>
                </div>
                <div class="flex-1">
                    <div class="flex justify-end items-center gap-4 flex-wrap">
                        <div class="flex items-center gap-3 bg-gray-50 rounded-md px-4 py-2 shadow-sm">
                            <div class="text-sm text-gray-500">{{ $t('label.total_sales') }}</div>
                            <div class="font-semibold text-gray-900">{{ total_sales || '-' }}</div>
                        </div>
                        <div class="flex items-center gap-3 bg-gray-50 rounded-md px-4 py-2 shadow-sm">
                            <div class="text-sm text-gray-500">{{ $t('label.total_orders') }}</div>
                            <div class="font-semibold text-gray-900">{{ total_orders || '-' }}</div>
                        </div>
                        <div class="flex items-center gap-3 bg-gray-50 rounded-md px-4 py-2 shadow-sm">
                            <div class="text-sm text-gray-500">{{ $t('label.total_customers') }}</div>
                            <div class="font-semibold text-gray-900">{{ total_customers || '-' }}</div>
                        </div>
                        <button @click="refreshHeader" class="db-btn-fill primary db-btn-sm">{{ $t('label.refresh') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--========OVERVIEW START=============-->
    <OverviewComponent />
    <!--========OVERVIEW END=============-->
    <div class="row gap-6">
        <!--========SALES SUMMARY START=============-->
        <SalesSummaryComponent />
        <!--========SALES SUMMARY END=============-->

        <!--========CUSTOMER STATS START=============-->
        <CustomerStatsComponent />
        <!--========CUSTOMER STATS END=============-->

        <!--========FEATURED ITEMS START=============-->
        <FeaturedItemsComponent />
        <!--========FEATURED ITEMS END=============-->

        <!--========MOST POPULAR ITEMS START=============-->
        <MostPopularItemsComponent />
        <!--========MOST POPULAR ITEMS END=============-->
    </div>
</template>

<script>
import LoadingComponent from "../components/LoadingComponent";
import OverviewComponent from "./OverviewComponent";
import FeaturedItemsComponent from "./FeaturedItemsComponent";
import MostPopularItemsComponent from "./MostPopularItemsComponent";
import SalesSummaryComponent from "./SalesSummaryComponent";
import CustomerStatsComponent from "./CustomerStatsComponent";
import ENV from "../../../config/env";

export default {
    name: "DashboardComponent",
    components: {
        LoadingComponent,
        OverviewComponent,
        FeaturedItemsComponent,
        MostPopularItemsComponent,
        SalesSummaryComponent,
        CustomerStatsComponent
    },
    data() {
        return {
            loading: {
                isActive: false,
            },
            demo: ENV.DEMO
            ,
            total_sales: null,
            total_orders: null,
            total_customers: null,
        };
    },
    computed: {
        authInfo: function () {
            return this.$store.getters.authInfo;
        }
    },
    methods: {
        visitorMessage: function () {
            let greet;
            let myDate = new Date();
            let hrs = myDate.getHours();
            if (hrs < 12) {
                greet = this.$t('message.good_morning');
            } else if (hrs >= 12 && hrs <= 17) {
                greet = this.$t('message.good_afternoon');
            } else if (hrs >= 17 && hrs <= 24) {
                greet = this.$t('message.good_evening');
            }
            return greet;
        }
        ,
        refreshHeader: function () {
            this.loading.isActive = true;
            const date = { first_date: this.first_date || '', last_date: this.last_date || '' };
            // fetch totals (reuse dashboard store actions)
            this.$store.dispatch('dashboard/totalSales', date).then(res => {
                this.total_sales = res.data.data.total_sales;
            }).catch(() => {});
            this.$store.dispatch('dashboard/totalOrders', date).then(res => {
                this.total_orders = res.data.data.total_orders;
            }).catch(() => {});
            this.$store.dispatch('dashboard/totalCustomers', date).then(res => {
                this.total_customers = res.data.data.total_customers;
            }).catch(() => {}).finally(() => {
                this.loading.isActive = false;
            });
        }
    }
}
</script>
