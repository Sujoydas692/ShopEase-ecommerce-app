<template>

    <Header></Header>
    <Banner v-if="showBanner"></Banner>

        <slot></slot>

    <Footer></Footer>

</template>

<script setup>
import { computed } from "vue";
import { useRoute } from "vue-router";
import Header from './Header.vue';
import Banner from './Banner.vue';
import Footer from './Footer.vue';

const route = useRoute();

const hideBannerRoutes = ["login", "myaccount", "productdetail", "wishlist", "carts", "checkout", "ordercomplete", "category.products", "brand.products"];

const showBanner = computed(() => !hideBannerRoutes.includes(route.name));

</script>