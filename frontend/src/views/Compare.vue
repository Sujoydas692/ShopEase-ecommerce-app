<template>
  <!-- START SECTION BREADCRUMB -->
  <div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
      <!-- STRART CONTAINER -->
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="page-title">
            <h1>Compare</h1>
          </div>
        </div>
        <div class="col-md-6">
          <ol class="breadcrumb justify-content-md-end">
            <li class="breadcrumb-item">
              <router-link to="/">Home</router-link>
            </li>
            <li class="breadcrumb-item active">Compare</li>
          </ol>
        </div>
      </div>
    </div>
    <!-- END CONTAINER-->
  </div>
  <!-- END SECTION BREADCRUMB -->

  <!-- START MAIN CONTENT -->
  <div class="main_content">
    <!-- START SECTION SHOP -->
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="compare_box">
              <div class="table-responsive">
                <table class="table table-bordered text-center">
                  <tbody v-if="compare.items.length">
                    <!-- Product Images -->
                    <tr class="pr_image">
                      <td
                        class="row_title"
                        style="color: #ff324d; font-size: 14px"
                      >
                        You can add max 4 products
                      </td>

                      <td
                        v-for="product in compare.items"
                        :key="product.id"
                        class="row_img"
                      >
                        <img :src="product.image" :alt="product.title" />
                      </td>
                    </tr>

                    <!-- Product Name -->
                    <tr class="pr_title">
                      <td class="row_title">Product Name</td>

                      <td
                        v-for="product in compare.items"
                        :key="product.id"
                        class="product_name"
                      >
                        <router-link
                          :to="{
                            name: 'productdetail',
                            params: { slug: product.slug },
                          }"
                        >
                          {{ product.title }}
                        </router-link>
                      </td>
                    </tr>

                    <!-- Price -->
                    <tr class="pr_price">
                      <td class="row_title">Price</td>

                      <td
                        v-for="product in compare.items"
                        :key="product.id"
                        class="product_price"
                      >
                        <div class="product_price">
                          <span class="price">৳{{ product?.price }}</span>
                          <del>৳55.25</del>
                          <div class="on_sale">
                            <span v-if="product?.discount">
                              <template
                                v-if="product.discount_type === 'percentage'"
                              >
                                {{ product?.discount }}% Off
                              </template>

                              <template
                                v-else-if="product.discount_type === 'fixed'"
                              >
                                ৳ {{ product?.discount }} Off
                              </template>
                            </span>
                          </div>
                        </div>
                      </td>
                    </tr>

                    <!-- Rating -->
                    <tr class="pr_rating">
                      <td class="row_title">Rating</td>

                      <td
                        v-for="product in compare.items"
                        :key="product.id"
                        class="row_rating"
                      >
                        <div class="rating_wrap">
                          <div class="rating">
                            <div
                              class="product_rate"
                              :style="{
                                width: ((product?.star ?? 0) / 5) * 100 + '%',
                              }"
                            ></div>
                          </div>
                          <span class="rating_num"
                            ><span class="rating_value">
                              {{
                                product?.star ? product.star.toFixed(1) : "N/A"
                              }} </span
                            >/5
                            <small
                              >({{ product?.review_count ?? 0 }} reviews)</small
                            ></span
                          >
                        </div>
                      </td>
                    </tr>
                    <!-- Stock -->
                    <tr class="pr_stock">
                      <td class="row_title">Item Availability</td>
                      <td
                        v-for="product in compare.items"
                        :key="product.id"
                        class="row_stock"
                      >
                        <span
                          :class="
                            compare.getProductStock(product) > 0
                              ? 'in-stock'
                              : 'out-stock'
                          "
                        >
                          {{
                            compare.getProductStock(product) > 0
                              ? "In Stock"
                              : "Out Of Stock"
                          }}
                        </span>
                      </td>
                    </tr>

                    <!-- Description -->
                    <tr class="description">
                      <td class="row_title">Description</td>

                      <td
                        v-for="product in compare.items"
                        :key="product.id"
                        class="row_text"
                      >
                        <p>{{ product.short_desc }}</p>
                      </td>
                    </tr>

                    <!-- Buy Button -->
                    <tr class="pr_add_to_cart">
                      <td class="row_title"></td>

                      <td
                        v-for="product in compare.items"
                        :key="product.id"
                        class="row_btn"
                      >
                        <router-link
                          :to="{
                            name: 'productdetail',
                            params: { slug: product.slug },
                          }"
                          class="btn btn-fill-out"
                        >
                          <i class="icon-basket-loaded"></i> Buy Now
                        </router-link>
                      </td>
                    </tr>

                    <!-- Remove -->
                    <tr class="pr_remove">
                      <td class="row_title"></td>

                      <td
                        v-for="product in compare.items"
                        :key="product.id"
                        class="row_remove"
                      >
                        <a
                          href="#"
                          @click.prevent="compare.removeFromCompare(product.id)"
                        >
                          <span>Remove</span>
                          <i class="fa fa-times"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>

                  <!-- Empty State -->
                  <tbody v-else>
                    <tr>
                      <td colspan="5" class="text-center py-5">
                        No products added to compare.
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END SECTION SHOP -->
  </div>
  <!-- END MAIN CONTENT -->
</template>
<script setup>
import { useRoute } from "vue-router";
import { useCompareStore } from "../store/compare";
import { onMounted, onUnmounted, watch } from "vue";

const compare = useCompareStore();
const route = useRoute();

const loadData = async () => {
  await compare.loadLiveData();
};

onMounted(() => {
  loadData();
});

watch(
  () => route.path,
  () => {
    if (route.path === "/compare") {
      loadData();
    }
  },
);
</script>
<style scoped>
.row_img {
  height: 350px;
}

.row_img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.compare_box table {
  table-layout: fixed;
  width: 100%;
}

.compare_box table td {
  width: 20%;
}
</style>
