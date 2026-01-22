<template>
  <div
    class="quickview-overlay"
    @click.self="emit('close')"
    @keydown.esc="emit('close')"
    tabindex="0"
  >
    <div class="quickview-box">
      <button class="close-btn" @click="emit('close')">×</button>
      <div class="row">
        <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
          <div class="product-image">
            <div
              class="product_img_box zoom-container"
              @mousemove="handleZoom"
              @mouseleave="resetZoom"
            >
              <img
                ref="zoomImg"
                :src="mainImage"
                :alt="product.title"
                class="zoom-image"
              />
            </div>

            <div class="thumbnail-gallery">
              <div class="thumbnail-container">
                <div
                  v-for="(img, index) in uniqueThumbnails"
                  :key="index"
                  class="thumbnail-item"
                  @click="mainImage = img"
                  :class="{ active: mainImage === img }"
                >
                  <img :src="img" :alt="'Thumbnail ' + (index + 1)" />
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6">
          <div class="pr_detail">
            <div class="product_description">
              <h4 class="product_title">
                <router-link
                  :to="{
                    name: 'productdetail',
                    params: { slug: product.slug },
                  }"
                  >{{ product.title }}</router-link
                >
              </h4>
              <div class="product_price">
                <span class="price">৳{{ product.price }}</span>
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
                  >({{
                    product.star ? (product.star * 20).toFixed(0) + "%" : "N/A"
                  }})</span
                >
              </div>
              <div class="pr_desc">
                <p>
                  {{ product.short_desc }}
                </p>
              </div>
              <div class="product_sort_info">
                <ul>
                  <li>
                    <i class="linearicons-shield-check"></i> 1 Year
                    <router-link
                      :to="{
                        name: 'brand.products',
                        params: { slug: product?.brand?.slug },
                      }"
                      class="brand-link"
                    >
                      {{ product?.brand?.name }}
                    </router-link>
                    Warranty
                  </li>
                  <li><i class="linearicons-sync"></i> 30 Day Return Policy</li>
                  <li>
                    <i class="linearicons-bag-dollar"></i> Cash on Delivery
                    available
                  </li>
                </ul>
              </div>
              <div class="pr_switch_wrap" v-if="filteredColors.length">
                <span class="switch_lable">Color</span>
                <div class="product_color_switch">
                  <span
                    v-for="(c, idx) in filteredColors"
                    :key="idx"
                    :data-color="c"
                    :style="{ backgroundColor: c }"
                    @click="selectedColor = c"
                    :class="{ active: selectedColor === c }"
                  ></span>
                </div>
              </div>
              <div class="pr_switch_wrap" v-if="sizes.length">
                <span class="switch_lable">Size</span>
                <div class="product_size_switch">
                  <span
                    v-for="(s, idx) in sizes"
                    :key="idx"
                    @click="hasStockForSize(s) && (selectedSize = s)"
                    :class="{
                      active: selectedSize === s,
                      disabled: !hasStockForSize(s),
                    }"
                  >
                    {{ s }}
                  </span>
                </div>
              </div>
            </div>
            <hr />
            <div class="cart_extra">
              <div class="cart-product-quantity">
                <div class="quantity">
                  <input
                    type="button"
                    value="-"
                    class="minus"
                    @click="decreaseQuantity"
                  />
                  <input
                    type="number"
                    v-model.number="qty"
                    min="1"
                    class="qty"
                    size="4"
                    @change="validateQuantity"
                  />
                  <input
                    type="button"
                    value="+"
                    class="plus"
                    @click="increaseQuantity"
                  />
                </div>
              </div>
              <div class="cart_btn">
                <button
                  class="btn btn-fill-out btn-addtocart"
                  type="button"
                  @click.prevent="addToCartItem(product.id)"
                  :disabled="addingToCart || isOutOfStock"
                >
                  <i
                    :class="isOutOfStock ? 'icon-ban' : 'icon-basket-loaded'"
                  ></i>
                  <span v-if="isOutOfStock">Out of Stock</span>
                  <span v-else>
                    {{ addingToCart ? "Adding..." : "Add to cart" }}
                  </span>
                </button>
                <a class="add_compare" href="#"><i class="icon-shuffle"></i></a>
                <a
                  class="add_wishlist"
                  :class="{
                    'active-wish': wishlistStore.has(product.id),
                  }"
                  href="javascript:void(0)"
                  @click.prevent="wishlistStore.toggle(product.id)"
                  ><i class="icon-heart"></i
                ></a>
              </div>
            </div>
            <hr />
            <ul class="product-meta">
              <li>
                SKU: <a href="javascript:void(0)">{{ displaySku }}</a>
              </li>
              <li>
                Category:
                <router-link
                  :to="{
                    name: 'category.products',
                    params: { slug: product?.category?.slug },
                  }"
                  >{{ product.category?.name }}</router-link
                >
              </li>
              <li v-if="product.tags">
                Tags:
                <span v-for="t in product.tags" :key="t"> {{ t }} </span>
              </li>
            </ul>

            <div class="product_share">
              <span>Share:</span>
              <ul class="social_icons">
                <li>
                  <a href="#"><i class="ion-social-facebook"></i></a>
                </li>
                <li>
                  <a href="#"><i class="ion-social-twitter"></i></a>
                </li>
                <li>
                  <a href="#"><i class="ion-social-googleplus"></i></a>
                </li>
                <li>
                  <a href="#"><i class="ion-social-youtube-outline"></i></a>
                </li>
                <li>
                  <a href="#"><i class="ion-social-instagram-outline"></i></a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from "vue";
import quickViewManager from "../utils/quickViewManager";
import { useCartStore } from "../store/cart";
import { toast } from "vue3-toastify";
import { useWishlistStore } from "../store/wishList";

const props = defineProps({
  product: Object,
});

const emit = defineEmits(["close"]);

const cart = useCartStore();
const wishlistStore = useWishlistStore();

const mainImage = ref("");

const qty = ref(1);
const addingToCart = ref(false);

const decreaseQuantity = () => {
  if (qty.value > 1) {
    qty.value--;
  }
};

const increaseQuantity = () => {
  qty.value++;
};

const validateQuantity = () => {
  if (qty.value < 1) {
    qty.value = 1;
  }
};

const galleryArray = computed(() => {
  if (!props.product.gallery) return [];

  try {
    if (Array.isArray(props.product.gallery)) {
      return [...props.product.gallery];
    }
    return [];
  } catch (e) {
    console.error("Error getting gallery:", e);
    return [];
  }
});

const allUniqueImages = computed(() => {
  const images = new Set();

  if (props.product.image) {
    images.add(props.product.image);
  }

  if (galleryArray.value.length > 0) {
    galleryArray.value.forEach((img) => {
      if (img) {
        images.add(img);
      }
    });
  }

  return Array.from(images);
});

const uniqueThumbnails = computed(() => {
  return allUniqueImages.value.slice(0, 4);
});

watch(
  () => props.product,
  (newProduct) => {
    if (!newProduct) return;

    if (allUniqueImages.value.length > 0) {
      mainImage.value = allUniqueImages.value[0];
    }
  },
  { immediate: true }
);

const isOutOfStock = computed(() => {
  if (!props.product) return true;

  if (props.product.variations && props.product.variations.length > 0) {
    const hasAnyStock = props.product.variations.some((v) => v.stock > 0);

    return !hasAnyStock;
  }

  return props.product.stock <= 0;
});

const hasStockForSize = (size) => {
  if (props.product.variations?.length > 0) {
    return props.product.variations?.some(
      (v) => v.size === size && v.stock > 0
    );
  }

  return props.product?.stock > 0;
};

const selectedColor = ref(null);
const selectedSize = ref(null);
const displaySku = ref(props.product.sku ?? "N/A");

const selectedVariation = computed(() => {
  if (!selectedSize.value || !selectedColor.value) return null;

  return (
    props.product.variations?.find(
      (v) => v.size === selectedSize.value && v.color === selectedColor.value
    ) || null
  );
});

watch([selectedSize, selectedColor], () => {
  if (selectedVariation.value?.sku) {
    displaySku.value = selectedVariation.value.sku;
  } else {
    displaySku.value = props.product.sku ?? "N/A";
  }
});

const sizes = computed(() => {
  if (!props.product.variations) return [];

  const set = new Set();
  props.product.variations.forEach((v) => {
    if (v.size) set.add(v.size);
  });

  return Array.from(set);
});

const filteredColors = computed(() => {
  if (!selectedSize.value || !props.product.variations) return [];

  const set = new Set();

  props.product.variations.forEach((v) => {
    if (v.size === selectedSize.value && v.color && v.stock > 0) {
      set.add(v.color);
    }
  });

  return Array.from(set);
});

watch(selectedSize, () => {
  selectedColor.value = null;
});

const addToCartItem = async (productId) => {
  if (isOutOfStock.value) {
    toast.error("This product is out of stock");
    return;
  }

  if (sizes.value.length && !selectedSize.value) {
    toast.error("Please select a size");
    return;
  }

  if (filteredColors.value.length && !selectedColor.value) {
    toast.error("Please select a color");
    return;
  }

  addingToCart.value = true;

  await cart.addToCart({
    productId,
    qty: qty.value,
    size: selectedSize.value,
    color: selectedColor.value,
  });

  addingToCart.value = false;
};

const zoomImg = ref(null);

const handleZoom = (e) => {
  const img = zoomImg.value;
  if (!img) return;

  const rect = img.getBoundingClientRect();

  const x = ((e.clientX - rect.left) / rect.width) * 100;
  const y = ((e.clientY - rect.top) / rect.height) * 100;

  img.style.transformOrigin = `${x}% ${y}%`;
  img.style.transform = "scale(2)";
};

const resetZoom = () => {
  const img = zoomImg.value;
  if (!img) return;

  img.style.transformOrigin = "center center";
  img.style.transform = "scale(1)";
};

const canOpen = quickViewManager.open();
if (!canOpen) {
  handleClose();
}

const handleKeyDown = (e) => {
  if (e.key === "Escape") {
    handleClose();
  }
};

const handleClose = () => {
  quickViewManager.close();
  emit("close");
};

onMounted(() => {
  wishlistStore.loadWishlist();
  document.addEventListener("keydown", handleKeyDown);

  if (allUniqueImages.value.length > 0) {
    mainImage.value = allUniqueImages.value[0];
  }
});

onUnmounted(() => {
  document.removeEventListener("keydown", handleKeyDown);
  quickViewManager.close();
});
</script>

<style scoped>
.thumbnail-gallery {
  margin-top: 20px;
}

.thumbnail-container {
  display: flex;
  gap: 15px;
  flex-wrap: nowrap;
  overflow-x: auto;
  padding-bottom: 10px;
  justify-content: center;
}

.thumbnail-item {
  flex: 0 0 auto;
  width: 80px;
  height: 80px;
  border: 2px solid #ddd;
  border-radius: 8px;
  overflow: hidden;
  cursor: pointer;
  transition: all 0.3s ease;
  background: #fff;
}

.thumbnail-item:hover {
  border-color: #007bff;
  transform: translateY(-3px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.thumbnail-item.active {
  border-color: #007bff;
  border-width: 3px;
  box-shadow: 0 5px 20px rgba(0, 123, 255, 0.3);
}

.thumbnail-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.product_img_box {
  margin-bottom: 20px;
  border: 1px solid #eee;
  border-radius: 10px;
  overflow: hidden;
  padding: 25px;
  background: #f9f9f9;
  min-height: 350px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.product_img_box img {
  width: 100%;
  max-height: 400px;
  object-fit: contain;
  display: block;
}

.zoom-container {
  overflow: hidden;
  cursor: zoom-in;
}

.zoom-image {
  transition: transform 0.2s ease;
  width: 100%;
  height: auto;
}

.add_wishlist.active-wish i {
  color: #ff324d !important;
}

.quickview-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.7);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  animation: fadeIn 0.3s ease;
}

.quickview-box {
  background: #fff;
  width: 90%;
  max-width: 1000px;
  max-height: 90vh;
  overflow-y: auto;
  padding: 30px;
  border-radius: 12px;
  position: relative;
  animation: slideUp 0.3s ease;
}

.close-btn {
  position: absolute;
  top: 15px;
  right: 15px;
  font-size: 28px;
  cursor: pointer;
  background: none;
  border: none;
  color: #333;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  transition: background 0.3s;
  z-index: 10000;
}

.product_size_switch {
  display: flex;
  gap: 5px;
  flex-wrap: wrap;
}

.product_size_switch span.disabled {
  opacity: 0.4;
  pointer-events: none;
  text-decoration: line-through;
}

.brand-link {
  color: #ff324d;
  text-decoration: none;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.thumbnail-container::-webkit-scrollbar {
  height: 6px;
}

.thumbnail-container::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 3px;
}

.thumbnail-container::-webkit-scrollbar-thumb {
  background: #c1c1c1;
  border-radius: 3px;
}

.thumbnail-container::-webkit-scrollbar-thumb:hover {
  background: #a8a8a8;
}

@media (max-width: 768px) {
  .thumbnail-item {
    width: 70px;
    height: 70px;
  }

  .product_img_box {
    min-height: 250px;
    padding: 15px;
  }

  .zoom-container {
    cursor: default;
  }

  .zoom-image {
    transform: scale(1) !important;
  }

  .thumbnail-container {
    gap: 10px;
  }
}

@media (max-width: 576px) {
  .thumbnail-item {
    width: 60px;
    height: 60px;
  }

  .product_img_box {
    min-height: 200px;
    padding: 10px;
  }

  .thumbnail-container {
    justify-content: flex-start;
  }
}
</style>
