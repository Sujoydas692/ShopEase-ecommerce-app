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
                  <router-link to="/dashboard/wish-list"
                    ><i class="ti-heart"></i><span>Wishlist</span></router-link
                  >
                </li>
                <li v-if="!auth.isAuthenticated">
                  <a href="javascript:void(0)" @click.prevent="wishListShow"
                    ><i class="ti-heart"></i><span>Wishlist</span></a
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
            <ul class="navbar-nav">
              <li class="dropdown">
                <router-link class="nav-link" to="/">Home</router-link>
              </li>
              <li class="dropdown dropdown-mega-menu">
                <a
                  class="dropdown-toggle nav-link"
                  href="#"
                  data-bs-toggle="dropdown"
                  >Products</a
                >
                <div class="dropdown-menu">
                  <ul class="mega-menu d-lg-flex">
                    <li class="mega-menu-col col-lg-3">
                      <ul>
                        <li class="dropdown-header">Categories</li>
                        <li v-for="category in categories" :key="category.id">
                          <router-link
                            class="dropdown-item nav-link nav_item"
                            :to="{
                              name: 'category.products',
                              params: { slug: category.slug },
                            }"
                            >{{ category.name }}</router-link
                          >
                        </li>
                      </ul>
                    </li>
                    <li class="mega-menu-col col-lg-3">
                      <ul>
                        <li class="dropdown-header">Brands</li>
                        <li v-for="brand in brands" :key="brand.id">
                          <router-link
                            class="dropdown-item nav-link nav_item"
                            :to="{
                              name: 'brand.products',
                              params: { slug: brand.slug },
                            }"
                            >{{ brand.name }}</router-link
                          >
                        </li>
                      </ul>
                    </li>
                    <li class="mega-menu-col col-lg-3">
                      <ul>
                        <li class="dropdown-header">Highlights</li>
                        <li>
                          <router-link
                            class="dropdown-item nav-link nav_item"
                            to="/"
                            >New Arrivals</router-link
                          >
                        </li>
                        <li>
                          <a
                            class="dropdown-item nav-link nav_item"
                            href="shop-product-detail-left-sidebar.html"
                            >Best Selling</a
                          >
                        </li>
                        <li>
                          <a
                            class="dropdown-item nav-link nav_item"
                            href="shop-product-detail-right-sidebar.html"
                            >Featured</a
                          >
                        </li>
                      </ul>
                    </li>
                    <li class="mega-menu-col col-lg-3">
                      <div class="header_banner">
                        <div class="header_banner_content">
                          <div class="shop_banner">
                            <div class="banner_img overlay_bg_40">
                              <img
                                src="/assets/images/shop_banner.jpg"
                                alt="shop_banner"
                              />
                            </div>
                            <div class="shop_bn_content">
                              <h5 class="text-uppercase shop_subtitle">
                                Special Offer
                              </h5>
                              <h3 class="text-uppercase shop_title">
                                Up to 30% Off
                              </h3>
                              <router-link
                                to="/"
                                class="btn btn-white rounded-0 btn-sm text-uppercase"
                              >
                                Shop Now
                              </router-link>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="dropdown dropdown-mega-menu">
                <a
                  class="dropdown-toggle nav-link"
                  href="#"
                  data-bs-toggle="dropdown"
                  >Shop</a
                >
                <div class="dropdown-menu">
                  <ul class="mega-menu d-lg-flex">
                    <li class="mega-menu-col col-lg-9">
                      <ul class="d-lg-flex">
                        <li class="mega-menu-col col-lg-4">
                          <ul>
                            <li class="dropdown-header">Shop Page Layout</li>
                            <li>
                              <a
                                class="dropdown-item nav-link nav_item"
                                href="shop-list.html"
                                >shop List view</a
                              >
                            </li>
                            <li>
                              <a
                                class="dropdown-item nav-link nav_item"
                                href="shop-list-left-sidebar.html"
                                >shop List Left Sidebar</a
                              >
                            </li>
                            <li>
                              <a
                                class="dropdown-item nav-link nav_item"
                                href="shop-list-right-sidebar.html"
                                >shop List Right Sidebar</a
                              >
                            </li>
                            <li>
                              <a
                                class="dropdown-item nav-link nav_item"
                                href="shop-left-sidebar.html"
                                >Left Sidebar</a
                              >
                            </li>
                            <li>
                              <a
                                class="dropdown-item nav-link nav_item"
                                href="shop-right-sidebar.html"
                                >Right Sidebar</a
                              >
                            </li>
                            <li>
                              <a
                                class="dropdown-item nav-link nav_item"
                                href="shop-load-more.html"
                                >Shop Load More</a
                              >
                            </li>
                          </ul>
                        </li>
                        <li class="mega-menu-col col-lg-4">
                          <ul>
                            <li class="dropdown-header">Other Pages</li>
                            <li>
                              <a
                                class="dropdown-item nav-link nav_item"
                                href="shop-cart.html"
                                >Cart</a
                              >
                            </li>
                            <li>
                              <a
                                class="dropdown-item nav-link nav_item"
                                href="checkout.html"
                                >Checkout</a
                              >
                            </li>
                            <li>
                              <a
                                class="dropdown-item nav-link nav_item"
                                href="my-account.html"
                                >My Account</a
                              >
                            </li>
                            <li>
                              <a
                                class="dropdown-item nav-link nav_item"
                                href="wishlist.html"
                                >Wishlist</a
                              >
                            </li>
                            <li>
                              <a
                                class="dropdown-item nav-link nav_item"
                                href="compare.html"
                                >compare</a
                              >
                            </li>
                            <li>
                              <a
                                class="dropdown-item nav-link nav_item"
                                href="order-completed.html"
                                >Order Completed</a
                              >
                            </li>
                          </ul>
                        </li>
                        <li class="mega-menu-col col-lg-4">
                          <ul>
                            <li class="dropdown-header">Product Pages</li>
                            <li>
                              <a
                                class="dropdown-item nav-link nav_item"
                                href="shop-product-detail.html"
                                >Default</a
                              >
                            </li>
                            <li>
                              <a
                                class="dropdown-item nav-link nav_item"
                                href="shop-product-detail-left-sidebar.html"
                                >Left Sidebar</a
                              >
                            </li>
                            <li>
                              <a
                                class="dropdown-item nav-link nav_item"
                                href="shop-product-detail-right-sidebar.html"
                                >Right Sidebar</a
                              >
                            </li>
                            <li>
                              <a
                                class="dropdown-item nav-link nav_item"
                                href="shop-product-detail-thumbnails-left.html"
                                >Thumbnails Left</a
                              >
                            </li>
                          </ul>
                        </li>
                      </ul>
                    </li>
                    <li class="mega-menu-col col-lg-3">
                      <div class="header_banner">
                        <div class="header_banner_content">
                          <div class="shop_banner">
                            <div class="banner_img overlay_bg_40">
                              <img
                                src="/assets/images/shop_banner.jpg"
                                alt="shop_banner"
                              />
                            </div>
                            <div class="shop_bn_content">
                              <h5 class="text-uppercase shop_subtitle">
                                New Collection
                              </h5>
                              <h3 class="text-uppercase shop_title">
                                Sale 30% Off
                              </h3>
                              <a
                                href="#"
                                class="btn btn-white rounded-0 btn-sm text-uppercase"
                                >Shop Now</a
                              >
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </li>
              <li>
                <a class="nav-link nav_item" href="contact.html">Contact Us</a>
              </li>
            </ul>
          </div>
          <ul class="navbar-nav attr-nav align-items-center">
            <li>
              <a href="javascript:;" class="nav-link search_trigger"
                ><i class="linearicons-magnifier"></i
              ></a>
              <div class="search_wrap">
                <span class="close-search"
                  ><i class="ion-ios-close-empty"></i
                ></span>
                <form>
                  <input
                    type="text"
                    placeholder="Search"
                    class="form-control"
                    id="search_input"
                  />
                  <button type="submit" class="search_icon">
                    <i class="ion-ios-search-strong"></i>
                  </button>
                </form>
              </div>
              <div class="search_overlay"></div>
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
import { ref, onMounted } from "vue";
import { useAuth } from "../../store/auth";
import { useCartStore } from "../../store/cart";
import { toast } from "vue3-toastify";
import { useRouter } from "vue-router";
import apiClient from "../../lib/axiosClient";

const auth = useAuth();
const cart = useCartStore();
const router = useRouter();

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
</script>
