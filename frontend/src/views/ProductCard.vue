<template>
  <div class="product">
    <div class="product_img">
      <router-link
        :to="{
          name: 'productdetail',
          params: { slug: product?.slug },
        }"
      >
        <img :src="product?.image" :alt="product?.title" />
      </router-link>
      <div class="product_action_box">
        <ul class="list_none pr_action_btn">
          <li class="add-to-cart">
            <a
              href="javascript:void(0)"
              @click.prevent="addToCartItem(product.id)"
              ><i class="icon-basket-loaded"></i> Add To Cart</a
            >
          </li>
          <li>
            <a href="javascript:void(0)" @click.prevent="openQuickView(product)"
              ><i class="icon-magnifier-add"></i
            ></a>
          </li>
          <li
            :class="{
              'active-wish': wishListStore.has(product.id),
            }"
          >
            <a
              href="javascript:void(0)"
              @click.prevent="wishListStore.toggle(product.id)"
              ><i class="icon-heart"></i
            ></a>
          </li>
        </ul>
      </div>
    </div>
    <div class="product_info">
      <h6 class="product_title">
        <router-link
          :to="{
            name: 'productdetail',
            params: { slug: product?.slug },
          }"
        >
          {{ product?.title }}
        </router-link>
      </h6>
      <div class="product_price">
        <span class="price">৳ {{ product?.price }}</span>
        <del>৳55.25</del>
        <div class="on_sale">
          <span v-if="product.discount">
            <template v-if="product.discount_type === 'percentage'">
              {{ product.discount }}% Off
            </template>

            <template v-else-if="product.discount_type === 'fixed'">
              ৳ {{ product.discount }} Off
            </template>
          </span>
        </div>
      </div>
      <div class="rating_wrap">
        <div class="rating">
          <div
            class="product_rate"
            :style="{
              width: ((product.star ?? 0) / 5) * 100 + '%',
            }"
          ></div>
        </div>
        <span class="rating_num"
          >{{ product.star ? product.star.toFixed(1) : "N/A" }}
          <small>({{ product.review_count ?? 0 }} reviews)</small></span
        >
      </div>
      <div class="pr_desc">
        <p>
          {{ product.short_desc }}
        </p>
      </div>
    </div>
    <!-- END SECTION SHOP -->
  </div>
  <Teleport to="#quickview-container">
    <ProductQuickView
      v-if="quickViewVisible"
      :product="quickViewProduct"
      @close="closeQuickView"
    />
  </Teleport>
  <!-- END MAIN CONTENT -->
</template>

<script setup>
import { ref, onMounted } from "vue";
import apiClient from "../lib/axiosClient";
import ProductQuickView from "./ProductQuickView.vue";
import { useCartStore } from "../store/cart";
import { useWishlistStore } from "../store/wishList";

defineProps({
  product: {
    type: Object,
    required: true,
  },
});

const cart = useCartStore();

const wishListStore = useWishlistStore();

const quickViewProduct = ref(null);
const quickViewVisible = ref(false);
const isOpening = ref(false);

const openQuickView = async (product) => {
  if (isOpening.value) return;

  isOpening.value = true;

  if (quickViewVisible.value) {
    closeQuickView();
    await new Promise((resolve) => setTimeout(resolve, 100));
  }

  try {
    const res = await apiClient.get(`/product/${product.slug}`);

    quickViewProduct.value = res.data.data;
    quickViewVisible.value = true;
  } catch (e) {
    console.error("Failed to load product for quick view", e);
  } finally {
    setTimeout(() => {
      isOpening.value = false;
    }, 300);
  }
};

const closeQuickView = () => {
  quickViewVisible.value = false;
  setTimeout(() => {
    quickViewProduct.value = null;
  }, 300);
};

const addToCartItem = async (productId) => {
  await cart.addToCart({
    productId,
  });
};

onMounted(() => {
  wishListStore.loadWishlist();
});
</script>

<style scoped>
.active-wish a i {
  padding: 9.5px 10px 10px 10px;
  background: #ff324d !important;
  color: #fff !important;
}
.active-cart a i {
  padding: 9.5px 10px 10px 10px;
  background: #ff324d !important;
  color: #fff !important;
}
.widget_categories li.active > a {
  color: #ff324d;
  font-weight: 600;
}
.product-card {
  border: 1px solid #eee;
  border-radius: 6px;
  transition: all 0.2s ease;
  background: #fff;
}

.product-card:hover {
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
  transform: translateY(-2px);
}

.product-img img {
  height: 180px;
  object-fit: cover;
}

.product-title {
  font-size: 14px;
  line-height: 1.3;
  height: 36px;
  overflow: hidden;
}
</style>
