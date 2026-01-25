<template>
  <!-- START SECTION BREADCRUMB -->
  <div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
      <!-- STRART CONTAINER -->
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="page-title">
            <h1>
              Search result for:
              <strong v-if="route.query.q" class="search-text"
                >"{{ route.query.q }}"</strong
              >
            </h1>
          </div>
        </div>
      </div>
    </div>
    <!-- END CONTAINER-->
  </div>
  <!-- END SECTION BREADCRUMB -->
  <section class="container py-4">
    <!-- Loading -->
    <div v-if="loading" class="text-center py-5">Loading...</div>

    <!-- Products -->
    <div v-else>
      <div v-if="products.length" class="row">
        <div
          class="col-lg-3 col-md-4 col-6 mb-4"
          v-for="product in products"
          :key="product.id"
        >
          <ProductCard :product="product" />
        </div>
      </div>

      <div v-else class="text-center py-5">No products found</div>

      <!-- Pagination -->
      <Pagination
        v-if="pagination.last_page > 1"
        :meta="pagination"
        @page-changed="fetchProducts"
      />
    </div>
  </section>
</template>

<script setup>
import { ref, watch } from "vue";
import { useRoute } from "vue-router";
import apiClient from "../lib/axiosClient";
import ProductCard from "./ProductCard.vue";
import Pagination from "../components/Pagination.vue";

const route = useRoute();

const products = ref([]);
const loading = ref(false);

const pagination = ref({
  current_page: 1,
  last_page: 1,
  total: 0,
  from: 0,
  to: 0,
});

const fetchProducts = async (page = 1) => {
  if (!route.query.q) return;

  loading.value = true;

  try {
    const res = await apiClient.get("/products/search-paginate", {
      params: {
        q: route.query.q,
        page,
      },
    });

    const data = res.data.data;

    products.value = data.data;
    pagination.value = {
      current_page: data.current_page,
      last_page: data.last_page,
      total: data.total,
      from: data.from,
      to: data.to,
    };
  } catch (e) {
    console.error("Search load failed", e);
  } finally {
    loading.value = false;
  }
};

watch(
  () => route.query.q,
  () => fetchProducts(1),
  { immediate: true },
);
</script>
<style scoped>
.search-text {
  text-transform: none !important;
}
</style>
