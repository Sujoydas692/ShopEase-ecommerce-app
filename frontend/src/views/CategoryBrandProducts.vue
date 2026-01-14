<template>
  <!-- START SECTION BREADCRUMB -->
  <div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
      <!-- STRART CONTAINER -->
      <div class="row align-items-center">
        <div class="col-md-6">
          <div v-if="routeName === 'category.products'" class="page-title">
            <h1>{{ category?.name }}</h1>
          </div>
          <div v-if="routeName === 'brand.products'" class="page-title">
            <h1>{{ brand?.name }}</h1>
          </div>
        </div>
        <div class="col-md-6">
          <ol class="breadcrumb justify-content-md-end">
            <li class="breadcrumb-item">
              <router-link to="/">Home</router-link>
            </li>
            <li v-if="routeName === 'category.products'" class="breadcrumb-item active">Category</li>
            <li v-if="routeName === 'brand.products'" class="breadcrumb-item active">Brand</li>
            <li v-if="routeName === 'category.products'" class="breadcrumb-item active">
              {{ category?.name }}
            </li>
            <li v-if="routeName === 'brand.products'" class="breadcrumb-item active">
              {{ brand?.name }}
            </li>
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
          <div class="col-lg-9">
            <template v-if="routeName === 'category.products'">
              <div class="row shop_container">
                <div
                  v-for="product in sections.category.products"
                  :key="product?.id"
                  class="col-md-4 col-6"
                >
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
                            <a
                              href="javascript:void(0)"
                              @click.prevent="openQuickView(product)"
                              ><i class="icon-magnifier-add"></i
                            ></a>
                          </li>
                          <li
                            :class="{
                              'active-wish': wishlist.includes(product.id),
                            }"
                          >
                            <a
                              href="javascript:void(0)"
                              @click.prevent="addToWish(product.id)"
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
                            <template
                              v-if="product.discount_type === 'percentage'"
                            >
                              {{ product.discount }}% Off
                            </template>

                            <template
                              v-else-if="product.discount_type === 'fixed'"
                            >
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
                            product.star
                              ? (product.star * 20).toFixed(0) + "%"
                              : "N/A"
                          }})</span
                        >
                      </div>
                      <div class="pr_desc">
                        <p>
                          {{ product.short_desc }}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <Pagination
                v-if="sections.category.meta.last_page > 1"
                :meta="sections.category.meta"
                @page-changed="loadCategoryProducts"
              />
            </template>
            <template v-if="routeName === 'brand.products'">
              <div class="row shop_container">
                <div
                  v-for="product in sections.brand.products"
                  :key="product?.id"
                  class="col-md-4 col-6"
                >
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
                            <a
                              href="javascript:void(0)"
                              @click.prevent="openQuickView(product)"
                              ><i class="icon-magnifier-add"></i
                            ></a>
                          </li>
                          <li
                            :class="{
                              'active-wish': wishlist.includes(product.id),
                            }"
                          >
                            <a
                              href="javascript:void(0)"
                              @click.prevent="addToWish(product.id)"
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
                            <template
                              v-if="product.discount_type === 'percentage'"
                            >
                              {{ product.discount }}% Off
                            </template>

                            <template
                              v-else-if="product.discount_type === 'fixed'"
                            >
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
                            product.star
                              ? (product.star * 20).toFixed(0) + "%"
                              : "N/A"
                          }})</span
                        >
                      </div>
                      <div class="pr_desc">
                        <p>
                          {{ product.short_desc }}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <Pagination
                v-if="sections.brand.meta.last_page > 1"
                :meta="sections.brand.meta"
                @page-changed="loadBrandProducts"
              />
            </template>
          </div>

          <div class="col-lg-3 order-lg-first mt-4 pt-2 mt-lg-0 pt-lg-0">
            <div class="sidebar">
              <div class="widget">
                <h5 class="widget_title">Categories</h5>
                <ul class="widget_categories">
                  <li
                    v-for="category in categories"
                    :key="category.id"
                    :class="{
                      active:
                        routeName === 'category.products' &&
                        category.slug === currentSlug,
                    }"
                  >
                    <router-link
                      :to="{
                        name: 'category.products',
                        params: { slug: category.slug },
                      }"
                      >{{ category.name }}</router-link
                    >
                  </li>
                </ul>
              </div>
              <div class="widget">
                <h5 class="widget_title">Brands</h5>
                <ul class="widget_categories">
                  <li
                    v-for="brand in brands"
                    :key="brand.id"
                    :class="{
                      active:
                        routeName === 'brand.products' &&
                        brand.slug === currentSlug,
                    }"
                  >
                    <router-link
                      :to="{
                        name: 'brand.products',
                        params: { slug: brand.slug },
                      }"
                      >{{ brand.name }}</router-link
                    >
                  </li>
                </ul>
              </div>
              <div class="widget">
                <div class="shop_banner">
                  <div class="banner_img overlay_bg_20">
                    <img
                      src="/assets/images/sidebar_banner_img.jpg"
                      alt="sidebar_banner_img"
                    />
                  </div>
                  <div class="shop_bn_content2 text_white">
                    <h5 class="text-uppercase shop_subtitle">New Collection</h5>
                    <h3 class="text-uppercase shop_title">Sale 30% Off</h3>
                    <a
                      href="#"
                      class="btn btn-white rounded-0 btn-sm text-uppercase"
                      >Shop Now</a
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END SECTION SHOP -->

    <!-- START SECTION SUBSCRIBE NEWSLETTER -->
    <div class="section bg_default small_pt small_pb">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6">
            <div class="heading_s1 mb-md-0 heading_light">
              <h3>Subscribe Our Newsletter</h3>
            </div>
          </div>
          <div class="col-md-6">
            <div class="newsletter_form">
              <form>
                <input
                  type="text"
                  required=""
                  class="form-control rounded-0"
                  placeholder="Enter Email Address"
                />
                <button
                  type="submit"
                  class="btn btn-dark rounded-0"
                  name="submit"
                  value="Submit"
                >
                  Subscribe
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- START SECTION SUBSCRIBE NEWSLETTER -->
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
import { ref, reactive, onMounted, watch, computed } from "vue";
import { useRoute, useRouter } from "vue-router";
import apiClient from "../lib/axiosClient";
import Pagination from "../components/Pagination.vue";
import ProductQuickView from "./ProductQuickView.vue";
import { useCartStore } from "../store/cart";
import { toast } from "vue3-toastify";
import { useAuth } from "../store/auth";

const auth = useAuth();
const cart = useCartStore();

const router = useRouter();
const wishlist = ref([]);

const route = useRoute();
const slug = ref(route.params.slug);

const routeName = computed(() => route.name);

const currentSlug = computed(() => route.params.slug);

const category = ref(null);
const categories = ref([]);
const brand = ref(null);
const brands = ref([]);

const loading = ref(true);

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

const sections = reactive({
  category: { products: [], meta: {}, links: [] },
  brand: { products: [], meta: {}, links: [] },
});

const loadCategoryProducts = async (page = 1) => {
  loading.value = true;
  try {
    const res = await apiClient.get(
      `/products/category/${route.params.slug}?page=${page}`
    );

    const paginated = res.data.data;

    sections.category.products = paginated.data ?? [];

    sections.category.meta = {
      current_page: paginated.current_page,
      last_page: paginated.last_page,
      per_page: paginated.per_page,
      total: paginated.total,
      from: paginated.from,
      to: paginated.to,
    };

    sections.category.links = {
      prev: paginated.prev_page_url,
      next: paginated.next_page_url,
    };
  } catch (error) {
    console.error(error);
  } finally {
    loading.value = false;
  }
};

const loadBrandProducts = async (page = 1) => {
  loading.value = true;
  try {
    const res = await apiClient.get(
      `/products/brand/${route.params.slug}?page=${page}`
    );

    const paginated = res.data.data;

    sections.brand.products = paginated.data ?? [];

    sections.brand.meta = {
      current_page: paginated.current_page,
      last_page: paginated.last_page,
      per_page: paginated.per_page,
      total: paginated.total,
      from: paginated.from,
      to: paginated.to,
    };

    sections.brand.links = {
      prev: paginated.prev_page_url,
      next: paginated.next_page_url,
    };
  } catch (error) {
    console.error(error);
  } finally {
    loading.value = false;
  }
};

const loadCategories = async () => {
  const res = await apiClient.get("/categories");
  categories.value = res.data.data;
};

const loadCategory = async () => {
  try {
    const res = await apiClient.get(`/category/${slug.value}`);
    category.value = res.data.data;
  } catch (e) {
    console.error(e);
  }
};

const loadBrands = async () => {
  const res = await apiClient.get("/brands");
  brands.value = res.data.data;
};

const loadBrand = async () => {
  try {
    const res = await apiClient.get(`/brand/${slug.value}`);
    brand.value = res.data.data;
  } catch (e) {
    console.error(e);
  }
};

const loadWishlist = async () => {
  if (!auth.isAuthenticated) {
    return;
  }
  try {
    const { data } = await apiClient.get("/wish-list");

    wishlist.value = data.data.map((item) => item.product_id);
  } catch (error) {
    console.error("Failed to load wishlist", error);
  }
};

const addToWish = async (productId) => {
  if (!auth.isAuthenticated) {
    toast.warning("You need to login first!");

    setTimeout(() => {
      router.push("/login");
      return;
    }, 2000);
  } else {
    try {
      const { data } = await apiClient.post("add/wish-list", {
        product_id: productId,
      });

      toast.success(
        Array.isArray(data?.message) ? data.message[0] : data?.message
      );

      if (wishlist.value.includes(productId)) {
        wishlist.value = wishlist.value.filter((id) => id !== productId);
      } else {
        wishlist.value.push(productId);
      }
    } catch (error) {
      toast.error(error.response?.data?.message || "Failed to add to wishlist");
    }
  }
};
const addToCartItem = async (productId) => {
  await cart.addToCart({
    productId,
  });
};

onMounted(() => {
  loadCategories();
  loadBrands();
  loadWishlist();

  if (routeName.value === "category.products") {
    loadCategory();
    loadCategoryProducts();
    sections.brand.products = [];
  }

  if (routeName.value === "brand.products") {
    loadBrand();
    loadBrandProducts();
    sections.category.products = [];
  }
});

watch(
  () => route.params.slug,
  (newSlug) => {
    slug.value = newSlug;

    if (routeName.value === "category.products") {
      loadCategoryProducts(1);
      loadCategory();
      sections.brand.products = [];
    }

    if (routeName.value === "brand.products") {
      loadBrandProducts(1);
      loadBrand();
      sections.category.products = [];
    }
  }
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
.widget_categories li.active > a {
  color: #ff324d;
  font-weight: 600;
}
</style>
