<template>
  <!-- START HEADER -->
  <header class="header_wrap fixed-top header_with_topbar">
    <div class="top-header">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6">
            <div
              class="d-flex align-items-center justify-content-center justify-content-md-start"
            >
              <ul class="contact_detail text-center text-lg-start">
                <li>
                  <i class="ti-mobile"></i
                  ><a href="tel:01654578654">
                    <span>01654578654</span>
                  </a>
                </li>
                <li>
                  <i class="ti-email"></i
                  ><a href="mailto:subirdasujoy@gmail.com">
                    <span>subirdasujoy@gmail.com</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-md-6">
            <div class="text-center text-md-end">
              <ul class="header_list">
                <li>
                  <a href="compare.html"
                    ><i class="ti-control-shuffle"></i><span>Compare</span></a
                  >
                </li>
                <li v-if="auth.isAuthenticated">
                  <router-link to="/dashboard/my-account"
                    ><i class="ti-user"></i><span>My Account</span></router-link
                  >
                </li>
                <li v-if="!auth.isAuthenticated">
                  <a href="javascript:void(0)" @click.prevent="myAccount"
                    ><i class="ti-user"></i><span>My Account</span></a
                  >
                </li>
                <li v-if="!auth.isAuthenticated">
                  <router-link to="/login"
                    ><i class="ti-power-off"></i><span>Login</span></router-link
                  >
                </li>
                <li v-if="auth.isAuthenticated">
                  <a href="javascript:void(0)" @click.prevent="logout"
                    ><i class="ti-power-off"></i><span>Logout</span></a
                  >
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="bottom_header dark_skin main_menu_uppercase">
      <div class="container">
        <nav class="navbar navbar-expand-lg">
          <router-link class="navbar-brand" to="/">
            <img
              class="logo_light"
              src="/assets/images/logo_light.png"
              alt="logo"
            />
            <img
              class="logo_dark"
              src="/assets/images/logo_dark.png"
              alt="logo"
            />
          </router-link>
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-expanded="false"
          >
            <span class="ion-android-menu"></span>
          </button>
          <div
            class="collapse navbar-collapse justify-content-end"
            id="navbarSupportedContent"
          >
            <div class="category-col">
              <div class="categories_wrap">
                <button
                  type="button"
                  aria-expanded="false"
                  class="categories_btn"
                  @click="toggleCategory"
                >
                  <i class="linearicons-menu"></i><span>All Category </span>
                </button>
                <div
                  id="navCatContent"
                  class="nav_cat navbar nav"
                  :class="{ show: isCategoryOpen }"
                >
                  <ul>
                    <li
                      v-for="category in categories"
                      :key="category.id"
                      class="dropdown dropdown-mega-menu"
                    >
                      <div class="category-row">
                        <router-link
                          class="category-link"
                          :to="{
                            name: 'category.products',
                            params: { slug: category.slug },
                          }"
                        >
                          <i :class="category.image"></i>
                          <span>{{ category.name }}</span>
                          <div
                            class="dropdown-toggle-icon"
                            data-bs-toggle="dropdown"
                          >
                            <i class="linearicons-chevron-right"></i>
                          </div>
                        </router-link>
                      </div>
                      <div class="dropdown-menu">
                        <ul>
                          <li v-for="brand in category.brands" :key="brand.id">
                            <router-link
                              class="dropdown-item nav-link nav_item"
                              :to="{
                                name: 'brand.products',
                                params: { slug: brand.slug },
                              }"
                            >
                              {{ brand.name }}
                            </router-link>
                          </li>
                        </ul>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="product_search_form">
              <form>
                <div class="input-group">
                  <div class="input-group-prepend"></div>
                  <input
                    class="form-control"
                    placeholder="Search Product..."
                    required=""
                    type="text"
                  />
                  <button type="submit" class="search_btn">
                    <i class="linearicons-magnifier"></i>
                  </button>
                </div>
              </form>
            </div>
          </div>
          <ul class="navbar-nav attr-nav align-items-center">
            <li v-if="auth.isAuthenticated">
              <router-link to="/dashboard/wish-list" class="nav-link"
                ><i class="linearicons-heart"></i
                ><span class="wishlist_count" v-if="wishlistStore.count >= 0">{{
                  wishlistStore.count
                }}</span></router-link
              >
            </li>
            <li v-if="!auth.isAuthenticated">
              <a
                href="javascript:void(0)"
                @click.prevent="wishListShow"
                class="nav-link"
                ><i class="linearicons-heart"></i
                ><span class="wishlist_count">0</span></a
              >
            </li>
            <li class="dropdown cart_dropdown">
              <a
                class="nav-link cart_trigger"
                href="javascript:void(0)"
                data-bs-toggle="dropdown"
                ><i class="linearicons-cart"></i
                ><span
                  class="cart_count"
                  v-if="auth.isAuthenticated && cart.totalQty >= 0"
                  >{{ cart.totalQty }}</span
                >
                <span class="cart_count" v-if="!auth.isAuthenticated"
                  >0</span
                ></a
              >
              <div
                class="cart_box dropdown-menu dropdown-menu-right"
                v-if="auth.isAuthenticated"
              >
                <ul class="cart_list" v-if="cart.carts.length > 0">
                  <li v-for="item in cart.carts" :key="item.id">
                    <a
                      href="javascript:void(0)"
                      @click="removeCartItem(item.id)"
                      class="item_remove"
                      ><i class="ion-close"></i
                    ></a>
                    <router-link
                      :to="{
                        name: 'productdetail',
                        params: { slug: item.product.slug },
                      }"
                    >
                      <img :src="item.product.image" alt="cart_thumb1" />

                      <div>
                        <div class="fw-semibold">
                          {{ item.product.title }}
                        </div>

                        <div
                          v-if="item.size || item.color"
                          class="text-muted"
                          style="font-size: 13px"
                        >
                          {{ item.size ?? "" }}
                          <span v-if="item.size && item.color"> - </span>
                          {{ item.color ?? "" }}
                        </div>
                      </div>
                    </router-link>
                    <span class="cart_quantity">
                      {{ item.qty }} x
                      <span class="cart_amount">
                        <span class="price_symbole">৳</span></span
                      >{{ item.product.price }}</span
                    >
                  </li>
                </ul>
                <ul v-else>
                  <li>
                    <span class="text-center d-block py-3"
                      >No items in cart!</span
                    >
                  </li>
                </ul>
                <div class="cart_footer">
                  <p class="cart_total">
                    <strong>Subtotal:</strong>
                    <span class="cart_price">
                      <span class="price_symbole">৳</span></span
                    >{{ cart.subtotal }}
                  </p>
                  <p class="cart_buttons">
                    <router-link
                      to="/dashboard/carts"
                      class="btn btn-fill-line rounded-0 view-cart"
                      >View Cart</router-link
                    >
                  </p>
                </div>
              </div>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </header>
  <!-- END HEADER -->
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
import { useAuth } from "../../store/auth";
import { useCartStore } from "../../store/cart";
import { toast } from "vue3-toastify";
import { useRouter } from "vue-router";
import apiClient from "../../lib/axiosClient";
import { useWishlistStore } from "../../store/wishList";

const auth = useAuth();
const cart = useCartStore();
const router = useRouter();
const wishlistStore = useWishlistStore();

const categories = ref([]);
const brands = ref([]);

const removeCartItem = (id) => {
  cart.removeCart(id);
};

onMounted(() => {
  if (auth.isAuthenticated) {
    cart.loadCartFromLocal();
    cart.loadCart();
  }
});

onMounted(async () => {
  try {
    const [categoryRes, brandRes] = await Promise.all([
      apiClient.get("/categories"),
      apiClient.get("/brands"),
    ]);

    categories.value = categoryRes.data.data;
    brands.value = brandRes.data.data;
  } catch (error) {
    console.error("Menu load failed", error);
  }
});

const wishListShow = () => {
  toast.warning("You need to login first!");

  setTimeout(() => {
    router.push("/login");
    return;
  }, 2000);
};

const myAccount = () => {
  toast.warning("You need to login first!");

  setTimeout(() => {
    router.push("/login");
    return;
  }, 2000);
};

const logout = () => {
  auth.logout();
};

const isCategoryOpen = ref(false);
const isMobile = ref(false);

const checkMobile = () => {
  isMobile.value = window.innerWidth <= 991;
};

const toggleCategory = () => {
  if (isMobile.value) {
    isCategoryOpen.value = !isCategoryOpen.value;
  }
};

onMounted(() => {
  checkMobile();
  window.addEventListener("resize", checkMobile);
});

onBeforeUnmount(() => {
  window.removeEventListener("resize", checkMobile);
});
</script>
<style scoped>
#navbarSupportedContent {
  gap: 10px;
}
.categories_btn {
  padding: 14px 12px;
  min-width: 160px;
}

.categories_btn span {
  margin-left: 6px;
}
.category-col {
  flex: 0 0 auto;
  margin-left: 5px;
}
.categories_wrap {
  position: relative;
}
#navCatContent {
  position: absolute;
  top: 100%;
  left: 0;
  width: 280px;
  background: #fff;
  opacity: 0;
  visibility: hidden;
  transform: translateY(10px);
  transition: all 0.2s ease;
  z-index: 999;
}

@media (min-width: 992px) {
  .categories_wrap:hover #navCatContent {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
  }
}

#navCatContent.show {
  opacity: 1;
  visibility: visible;
  transform: translateY(0);
}

.category-row {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px 14px;
  gap: 10px;
}

.category-link {
  display: flex;
  align-items: center;
  gap: 8px;
  color: #292b2c;
  text-decoration: none;
  flex: 1;
}

.category-link span {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.dropdown-toggle-icon {
  width: 28px;
  height: 28px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}

.dropdown-toggle-icon i {
  font-size: 12px !important;
  font-weight: 900 !important;
}
</style>
