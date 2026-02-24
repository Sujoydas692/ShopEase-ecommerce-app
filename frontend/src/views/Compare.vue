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
                        v-for="(product, index) in slots"
                        :key="index"
                        class="row_img"
                        :ref="(el) => (searchRefs[index] = el)"
                      >
                        <div v-if="product">
                          <img :src="product.image" :alt="product.title" />
                        </div>
                        <div v-else class="search-container">
                          <form @submit.prevent="() => {}">
                            <div class="input-group">
                              <input
                                class="form-control"
                                placeholder="Search product..."
                                type="text"
                                v-model="searchQueries[index]"
                                @input="searchProducts(index)"
                              />
                            </div>
                          </form>

                          <!-- SEARCH RESULT -->
                          <ul
                            v-if="
                              showResults[index] && searchResults[index]?.length
                            "
                            class="search_result_list"
                          >
                            <li
                              class="product_click"
                              v-for="product in searchResults[index]"
                              :key="product.id"
                              @click="addToCompare(product, index)"
                            >
                              <img :src="product.image" />
                              <div>
                                <p class="title">{{ product.title }}</p>
                                <span class="price">৳ {{ product.price }}</span>
                              </div>
                            </li>
                          </ul>

                          <div
                            v-if="
                              showResults[index] &&
                              !searchResults[index]?.length &&
                              searchQueries[index]
                            "
                            class="search_empty"
                          >
                            No product found
                          </div>
                        </div>
                      </td>
                    </tr>

                    <!-- Product Name -->
                    <tr class="pr_title">
                      <td class="row_title">Product Name</td>

                      <td
                        v-for="(product, index) in slots"
                        :key="index"
                        class="product_name"
                      >
                        <div v-if="product">
                          <router-link
                            :to="{
                              name: 'productdetail',
                              params: { slug: product.slug },
                            }"
                          >
                            {{ product.title }}
                          </router-link>
                        </div>
                      </td>
                    </tr>

                    <!-- Price -->
                    <tr class="pr_price">
                      <td class="row_title">Price</td>

                      <td
                        v-for="(product, index) in slots"
                        :key="index"
                        class="product_price"
                      >
                        <div v-if="product" class="product_price">
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
                        v-for="(product, index) in slots"
                        :key="index"
                        class="row_rating"
                      >
                        <div v-if="product" class="rating_wrap">
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
                        v-for="(product, index) in slots"
                        :key="index"
                        class="row_stock"
                      >
                        <span
                          v-if="product"
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
                        v-for="(product, index) in slots"
                        :key="index"
                        class="row_text"
                      >
                        <p v-if="product">{{ product.short_desc }}</p>
                      </td>
                    </tr>

                    <!-- Buy Button -->
                    <tr class="pr_add_to_cart">
                      <td class="row_title"></td>

                      <td
                        v-for="(product, index) in slots"
                        :key="index"
                        class="row_btn"
                      >
                        <div v-if="product">
                          <router-link
                            :to="{
                              name: 'productdetail',
                              params: { slug: product.slug },
                            }"
                            class="btn btn-fill-out"
                          >
                            <i class="icon-basket-loaded"></i> Buy Now
                          </router-link>
                        </div>
                      </td>
                    </tr>

                    <!-- Remove -->
                    <tr class="pr_remove">
                      <td class="row_title"></td>

                      <td
                        v-for="(product, index) in slots"
                        :key="index"
                        class="row_remove"
                      >
                        <div v-if="product">
                          <a
                            href="#"
                            @click.prevent="
                              compare.removeFromCompare(product.id)
                            "
                          >
                            <span>Remove</span>
                            <i class="fa fa-times"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                  </tbody>

                  <!-- Empty State -->
                  <tbody v-else>
                    <tr>
                      <td colspan="5" class="text-center py-5">
                        <div class="empty-compare">
                          <i class="linearicons-equalizer"></i>
                          <h4>No products to compare</h4>
                          <p>
                            Add products to compare their specifications side by
                            side
                          </p>
                          <router-link to="/" class="btn btn-fill-out">
                            Continue Shopping
                          </router-link>
                        </div>
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
import { ref, computed, onMounted, onBeforeUnmount, watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useCompareStore } from "../store/compare";
import apiClient from "../lib/axiosClient";
import { toast } from "vue3-toastify";

const compare = useCompareStore();
const route = useRoute();
const router = useRouter();

const maxSlots = 4;

const slots = computed(() => {
  const filled = [...compare.items];
  while (filled.length < maxSlots) {
    filled.push(null);
  }
  return filled;
});

const searchQueries = ref(["", "", "", ""]);
const searchResults = ref([[], [], [], []]);
const showResults = ref([false, false, false, false]);
const totalResults = ref([0, 0, 0, 0]);
const searchRefs = ref([]);
let searchTimeouts = {};

const searchProducts = (index) => {
  clearTimeout(searchTimeouts[index]);

  if (!searchQueries.value[index]?.trim()) {
    searchResults.value[index] = [];
    totalResults.value[index] = 0;
    showResults.value[index] = false;
    return;
  }

  searchTimeouts[index] = setTimeout(async () => {
    try {
      const compareIds = compare.items.map((item) => item.id);

      const res = await apiClient.get("/products/search", {
        params: {
          q: searchQueries.value[index],
          exclude_ids: compareIds.join(","),
        },
      });

      const filteredItems = res.data.data.items.filter(
        (item) => !compareIds.includes(item.id),
      );

      searchResults.value[index] = filteredItems;
      totalResults.value[index] = res.data.data.total;
      showResults.value[index] = true;
    } catch (e) {
      console.error("Search failed", e);
    }
  }, 400);
};

const addToCompare = (product, index) => {
  if (compare.items.some((item) => item.id === product.id)) {
    toast.warning("Product already in compare list!");
    return;
  }

  if (compare.items.length >= maxSlots) {
    toast.warning(`You can only compare up to ${maxSlots} products!`);
    return;
  }

  compare.addToCompare(product);

  searchQueries.value[index] = "";
  searchResults.value[index] = [];
  showResults.value[index] = false;
};

const removeProduct = (productId, index) => {
  compare.removeFromCompare(productId);

  searchQueries.value[index] = "";
  searchResults.value[index] = [];
  showResults.value[index] = false;
};

const handleClickOutside = (e) => {
  searchRefs.value.forEach((ref, index) => {
    if (ref && !ref.contains(e.target)) {
      showResults.value[index] = false;
    }
  });
};

const loadData = async () => {
  await compare.loadLiveData();
};

onMounted(() => {
  loadData();
  document.addEventListener("click", handleClickOutside);
});

onBeforeUnmount(() => {
  document.removeEventListener("click", handleClickOutside);
  Object.values(searchTimeouts).forEach(clearTimeout);
});

watch(
  () => route.path,
  () => {
    if (route.path === "/compare") {
      loadData();
      searchQueries.value = ["", "", "", ""];
      searchResults.value = [[], [], [], []];
      showResults.value = [false, false, false, false];
    }
  },
);
</script>

<style scoped>
.row_img {
  height: 350px;
  position: relative;
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

/* Search container styles */
.search-container {
  position: relative;
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  padding: 10px;
}

.input-group {
  width: 100%;
}

.form-control {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 14px;
}

.form-control:focus {
  outline: none;
  border-color: #ff324d;
  box-shadow: 0 0 0 0.2rem rgba(255, 50, 77, 0.25);
}

/* Search results dropdown */
.search_result_list {
  position: absolute;
  top: 60px;
  left: 10px;
  right: 10px;
  background: #fff;
  border: 1px solid #eee;
  border-radius: 4px;
  z-index: 1000;
  max-height: 250px;
  overflow-y: auto;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.search_result_list li {
  display: flex;
  gap: 10px;
  padding: 10px;
  border-bottom: 1px solid #f1f1f1;
}

.search_result_list .product_click {
  cursor: pointer;
}

.search_result_list li:hover {
  background: #f9f9f9;
}

.search_result_list img {
  width: 40px;
  height: 40px;
  object-fit: cover;
  border-radius: 4px;
}

.search_result_list .title {
  font-size: 14px;
  margin: 0;
  font-weight: 500;
}

.search_result_list .price {
  font-size: 13px;
  color: #ff324d;
  font-weight: 600;
}

.search_result_header {
  position: sticky;
  top: 0;
  z-index: 5;
  background: #f9f9f9;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 12px;
  font-size: 13px;
  font-weight: 500;
  border-bottom: 1px solid #eee;
}

.search_result_header .result_info {
  color: #555;
}

.search_empty {
  position: absolute;
  top: 60px;
  left: 10px;
  right: 10px;
  background: #fff;
  padding: 15px;
  border: 1px solid #eee;
  border-radius: 4px;
  font-size: 14px;
  text-align: center;
  color: #999;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* Remove button for products */
.remove-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  width: 30px;
  height: 30px;
  background: rgba(255, 255, 255, 0.9);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #ff324d;
  text-decoration: none;
  transition: all 0.3s ease;
}

.remove-btn:hover {
  background: #ff324d;
  color: #fff;
}

/* Empty state styles */
.empty-compare {
  padding: 40px 20px;
  text-align: center;
}

.empty-compare i {
  font-size: 60px;
  color: #ddd;
  margin-bottom: 20px;
}

.empty-compare h4 {
  font-size: 20px;
  margin-bottom: 10px;
  color: #333;
}

.empty-compare p {
  color: #999;
  margin-bottom: 20px;
}

.empty-compare .btn {
  padding: 10px 30px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .row_img {
    height: 300px;
  }

  .search_result_list {
    max-height: 200px;
  }
}
</style>
