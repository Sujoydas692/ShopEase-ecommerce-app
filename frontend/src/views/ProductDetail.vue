<template>
  <!-- START SECTION BREADCRUMB -->
  <div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
      <!-- STRART CONTAINER -->
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="page-title">
            <h1>Product Detail</h1>
          </div>
        </div>
        <div class="col-md-6">
          <ol class="breadcrumb justify-content-md-end">
            <li class="breadcrumb-item">
              <router-link to="/">Home</router-link>
            </li>
            <li class="breadcrumb-item active">Product Detail</li>
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
          <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
            <div class="product-image">
              <div
                class="product_img_box zoom-container"
                @mousemove="handleZoom"
                @mouseleave="resetZoom"
              >
                <img
                  ref="zoomImg"
                  :key="mainImage"
                  :src="mainImage"
                  :alt="product?.title"
                  class="zoom-image"
                />
              </div>
              <div class="thumbnail-gallery">
                <div class="thumbnail-container">
                  <div
                    v-for="img in uniqueThumbnails"
                    :key="img"
                    class="thumbnail-item"
                    @click="mainImage = img"
                    :class="{ active: mainImage === img }"
                  >
                    <img :src="img" />
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
                      params: { slug: product?.slug },
                    }"
                    >{{ product?.title }}</router-link
                  >
                </h4>
                <div class="product_price">
                  <span class="price">৳{{ product?.price }}</span>
                  <del>৳55.25</del>
                  <div class="on_sale">
                    <span v-if="product?.discount">
                      <template v-if="product.discount_type === 'percentage'">
                        {{ product?.discount }}% Off
                      </template>

                      <template v-else-if="product.discount_type === 'fixed'">
                        ৳ {{ product?.discount }} Off
                      </template>
                    </span>
                  </div>
                </div>
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
                    >{{ product?.star ? product.star.toFixed(1) : "N/A" }}
                    <small
                      >({{ product?.review_count ?? 0 }} reviews)</small
                    ></span
                  >
                </div>
                <div class="pr_desc">
                  <p>
                    {{ product?.short_desc }}
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
                      Brand Warranty
                    </li>
                    <li>
                      <i class="linearicons-sync"></i> 30 Day Return Policy
                    </li>
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
                  <a class="add_compare" href="#"
                    ><i class="icon-shuffle"></i
                  ></a>
                  <a
                    class="add_wishlist"
                    :class="{
                      'active-wish': wishListStore?.has(product?.id),
                    }"
                    href="javascript:void(0)"
                    @click.prevent="wishListStore.toggle(product.id)"
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
                    >{{ product?.category?.name }}</router-link
                  >
                </li>
                <li v-if="product?.tags">
                  Tags:
                  <span v-for="t in product?.tags" :key="t"> {{ t }} </span>
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
        <div class="row">
          <div class="col-12">
            <div class="large_divider clearfix"></div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="tab-style3">
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                  <a
                    class="nav-link active"
                    id="Description-tab"
                    data-bs-toggle="tab"
                    href="#Description"
                    role="tab"
                    aria-controls="Description"
                    aria-selected="true"
                    >Description</a
                  >
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link"
                    id="Reviews-tab"
                    data-bs-toggle="tab"
                    href="#Reviews"
                    role="tab"
                    aria-controls="Reviews"
                    aria-selected="false"
                    >Reviews ({{ product?.review_count }})</a
                  >
                </li>
              </ul>
              <div class="tab-content shop_info_tab">
                <div
                  class="tab-pane fade show active"
                  id="Description"
                  role="tabpanel"
                  aria-labelledby="Description-tab"
                >
                  <p>
                    {{ product?.details?.description }}
                  </p>
                </div>
                <div
                  class="tab-pane fade"
                  id="Reviews"
                  role="tabpanel"
                  aria-labelledby="Reviews-tab"
                >
                  <div class="comments">
                    <h5 class="product_tab_title">
                      ({{ product?.review_count }}) Review'(s) For
                      <span>{{ product?.title }}</span>
                    </h5>
                    <ul class="list_none comment_list mt-4">
                      <li v-for="review in product?.reviews" :key="review.id">
                        <div class="comment_block">
                          <div class="rating_wrap">
                            <div class="rating">
                              <div
                                class="product_rate"
                                :style="{
                                  width: (review.rating / 5) * 100 + '%',
                                }"
                              ></div>
                            </div>
                          </div>
                          <p class="customer_meta">
                            <span class="review_author">{{ review.name }}</span>
                            <span class="comment-date">{{
                              formatDate(review.created_at)
                            }}</span>
                          </p>
                          <div class="description">
                            <p>
                              {{ review.comment }}
                            </p>
                          </div>
                        </div>
                      </li>
                      <li v-if="!product?.reviews?.length">
                        <p>No reviews yet.</p>
                      </li>
                    </ul>
                  </div>
                  <div class="review_form field_form">
                    <h5>Add a review</h5>
                    <form class="row mt-3" @submit.prevent="submitReview">
                      <div class="form-group col-12 mb-3">
                        <div class="star_rating">
                          <span
                            v-for="i in 5"
                            :key="i"
                            @click="reviewForm.rating = i"
                          >
                            <i
                              :class="[
                                i <= reviewForm.rating
                                  ? 'fas fa-star'
                                  : 'far fa-star',
                              ]"
                            ></i>
                          </span>
                        </div>
                      </div>
                      <div class="form-group col-12 mb-3">
                        <textarea
                          v-model="reviewForm.comment"
                          placeholder="Your review *"
                          class="form-control"
                          rows="4"
                        ></textarea>
                      </div>
                      <div class="form-group col-md-6 mb-3">
                        <input
                          v-model="reviewForm.name"
                          placeholder="Enter Name *"
                          class="form-control"
                        />
                      </div>
                      <div class="form-group col-md-6 mb-3">
                        <input
                          v-model="reviewForm.email"
                          placeholder="Enter Email *"
                          class="form-control"
                          type="email"
                        />
                      </div>

                      <div class="form-group col-12 mb-3">
                        <button
                          type="submit"
                          class="btn btn-fill-out"
                          name="submit"
                          value="Submit"
                        >
                          Submit Review
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="small_divider"></div>
            <div class="divider"></div>
            <div class="medium_divider"></div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="heading_s1">
              <h3>Related Products</h3>
            </div>
            <div
              v-if="related_products?.length"
              class="releted_product_slider carousel_slider owl-carousel owl-theme"
            >
              <div class="item" v-for="rp in related_products" :key="rp.id">
                <div class="product">
                  <div class="product_img">
                    <router-link
                      :to="{
                        name: 'productdetail',
                        params: { slug: rp?.slug },
                      }"
                    >
                      <img :src="rp?.image" :alt="rp?.title" />
                    </router-link>
                    <div class="product_action_box">
                      <ul class="list_none pr_action_btn">
                        <li class="add-to-cart">
                          <a
                            href="javascript:void(0)"
                            @click.prevent="addToCartItemOne(rp.id)"
                            ><i class="icon-basket-loaded"></i> Add To Cart</a
                          >
                        </li>
                        <li>
                          <a
                            href="javascript:void(0)"
                            @click.prevent="openQuickView(rp)"
                            ><i class="icon-magnifier-add"></i
                          ></a>
                        </li>
                        <li
                          :class="{
                            'active-wish': wishListStore.has(rp.id),
                          }"
                        >
                          <a
                            href="javascript:void(0)"
                            @click.prevent="wishListStore.toggle(rp.id)"
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
                          params: { slug: rp?.slug },
                        }"
                      >
                        {{ rp?.title }}
                      </router-link>
                    </h6>
                    <div class="product_price">
                      <span class="price">৳ {{ rp?.price }}</span>
                      <del>৳55.25</del>
                      <div class="on_sale">
                        <span v-if="rp?.discount">
                          <template v-if="rp?.discount_type === 'percentage'">
                            {{ rp?.discount }}% Off
                          </template>

                          <template v-else-if="rp?.discount_type === 'fixed'">
                            ৳ {{ rp?.discount }} Off
                          </template>
                        </span>
                      </div>
                    </div>
                    <div class="rating_wrap">
                      <div class="rating">
                        <div
                          class="product_rate"
                          :style="{
                            width: ((rp?.star ?? 0) / 5) * 100 + '%',
                          }"
                        ></div>
                      </div>
                      <span class="rating_num"
                        >{{ rp?.star ? rp?.star.toFixed(1) : "N/A" }}
                        <small
                          >({{ rp?.review_count ?? 0 }} reviews)</small
                        ></span
                      >
                    </div>
                    <div class="pr_desc">
                      <p>
                        {{ rp?.short_desc }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END SECTION SHOP -->
  </div>
  <!-- END MAIN CONTENT -->
  <Teleport to="#quickview-container">
    <product-quick-view
      v-if="quickViewVisible"
      :product="quickViewProduct"
      @close="closeQuickView"
    />
  </Teleport>
</template>
<script setup>
import { ref, computed, onMounted, watch } from "vue";
import { useRoute } from "vue-router";
import { useCartStore } from "../store/cart";
import { toast } from "vue3-toastify";
import apiClient from "../lib/axiosClient";
import { useWishlistStore } from "../store/wishList";
import ProductQuickView from "./ProductQuickView.vue";

const cart = useCartStore();
const route = useRoute();
const wishListStore = useWishlistStore();
const product = ref(null);
const loading = ref(true);

const related_products = ref([]);

const reviewForm = ref({
  rating: 0,
  comment: "",
  name: "",
  email: "",
});

const submitReview = async () => {
  if (!reviewForm.value.rating) {
    toast.error("Please select a rating");
    return;
  }

  try {
    await apiClient.post(
      `/products/${product.value.id}/reviews`,
      reviewForm.value,
    );

    toast.success("Review submitted");

    await loadProduct();
    reviewForm.value = {
      rating: 0,
      comment: "",
      name: "",
      email: "",
    };
  } catch (e) {
    toast.error("Failed to submit review");
  }
};

const formatDate = (date) => {
  return new Date(date).toLocaleDateString("en-US", {
    year: "numeric",
    month: "long",
    day: "numeric",
  });
};

const loadRelatedProducts = async () => {
  if (!product.value?.id) return;

  const res = await apiClient.get(`/products/${product.value.id}/related`);

  related_products.value = res.data.data;
};

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

const loadProduct = async () => {
  try {
    const res = await apiClient.get(`/product/${route.params.slug}`);
    product.value = res.data.data;
    await loadRelatedProducts();
  } catch (e) {
    console.error(e);
  } finally {
    loading.value = false;
  }
};

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
  if (!product.value?.gallery) return [];

  try {
    if (Array.isArray(product.value?.gallery)) {
      return [...product.value?.gallery];
    }
    return [];
  } catch (e) {
    console.error("Error getting gallery:", e);
    return [];
  }
});

const allUniqueImages = computed(() => {
  const images = new Set();

  if (product.value?.image) {
    images.add(product.value?.image);
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

const selectedColor = ref(null);
const selectedSize = ref(null);
const displaySku = ref(product.value?.sku ?? "N/A");

const selectedVariation = computed(() => {
  if (!selectedSize.value || !selectedColor.value) return null;

  return (
    product.value.variations?.find(
      (v) => v.size === selectedSize.value && v.color === selectedColor.value,
    ) || null
  );
});

const isOutOfStock = computed(() => {
  if (!product.value) return true;

  if (product.value.variations && product.value.variations.length > 0) {
    const hasAnyStock = product.value.variations.some((v) => v.stock > 0);

    return !hasAnyStock;
  }

  return product.value.stock <= 0;
});

const hasStockForSize = (size) => {
  if (product.value.variations?.length > 0) {
    return product.value.variations?.some(
      (v) => v.size === size && v.stock > 0,
    );
  }

  return product.value?.stock > 0;
};

watch([selectedSize, selectedColor], () => {
  if (selectedVariation.value?.sku) {
    displaySku.value = selectedVariation.value.sku;
  } else {
    displaySku.value = product.value?.sku ?? "N/A";
  }
});

const sizes = computed(() => {
  if (!product.value?.variations) return [];

  const set = new Set();
  product.value?.variations.forEach((v) => {
    if (v.size) set.add(v.size);
  });

  return Array.from(set);
});

const filteredColors = computed(() => {
  if (!selectedSize.value || !product.value.variations) return [];

  const set = new Set();

  product.value.variations.forEach((v) => {
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

const addToCartItemOne = async (productId) => {
  await cart.addToCart({
    productId,
  });
};

watch(allUniqueImages, (images) => {
  if (images.length && !mainImage.value) {
    mainImage.value = images[0];
  }
});

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

watch(related_products, (val) => {
  if (val?.length) {
    setTimeout(() => {
      const el = $(".releted_product_slider");

      if (el.hasClass("owl-loaded")) {
        el.trigger("destroy.owl.carousel");
        el.removeClass("owl-loaded");
        el.find(".owl-stage-outer").children().unwrap();
      }

      el.owlCarousel({
        loop: true,
        margin: 20,
        nav: false,
        dots: true,
        responsive: {
          0: { items: 1 },
          480: { items: 2 },
          768: { items: 3 },
          1199: { items: 4 },
        },
      });
    }, 100);
  }
});

onMounted(() => {
  loadProduct();
  wishListStore.loadWishlist();
});

watch(
  () => route.params.slug,
  async (newSlug, oldSlug) => {
    if (newSlug !== oldSlug) {
      loading.value = true;
      product.value = null;
      mainImage.value = null;
      related_products.value = [];

      await loadProduct();

      window.scrollTo({ top: 0, behavior: "smooth" });
    }
  },
);
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

.brand-link {
  color: #ff324d;
  text-decoration: none;
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

  .thumbnail-container {
    gap: 10px;
  }

  .zoom-container {
    cursor: default;
  }

  .zoom-image {
    transform: scale(1) !important;
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
