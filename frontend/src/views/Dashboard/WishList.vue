<template>
  <!-- START SECTION BREADCRUMB -->
  <div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
      <!-- STRART CONTAINER -->
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="page-title">
            <h1>Wishlist</h1>
          </div>
        </div>
        <div class="col-md-6">
          <ol class="breadcrumb justify-content-md-end">
            <li class="breadcrumb-item">
              <router-link to="/">Home</router-link>
            </li>
            <li class="breadcrumb-item active">Wishlist</li>
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
        <div class="row shop_container">
          <div
            class="col-lg-3 col-md-4 col-6"
            v-for="item in wishlist"
            :key="item.id"
            v-if="wishlist.length > 0"
          >
            <div class="product">
              <div class="wishlist-img-wrapper">
                <router-link
                  :to="{
                    name: 'productdetail',
                    params: { slug: item.product.slug },
                  }"
                  ><img :src="item.product.image" alt="product1"
                /></router-link>
              </div>
              <div class="product_info wishlist-info">
                <div class="product-remove" data-title="Remove">
                  <a
                    href="javascript:void(0)"
                    @click.prevent="removeWishList(item.product.id)"
                    ><i class="ti-trash"></i
                  ></a>
                </div>
                <h6 class="product_title">
                  <router-link
                    :to="{
                      name: 'productdetail',
                      params: { slug: item.product.slug },
                    }"
                    >{{ item.product.title }}</router-link
                  >
                </h6>
                <div class="product_price">
                  <span class="price">৳ {{ item.product.price }}</span>
                </div>
                <div class="rating_wrap">
                  <div class="rating">
                    <div
                      class="product_rate"
                      :style="{
                        width: ((item.product.star ?? 0) / 5) * 100 + '%',
                      }"
                    ></div>
                  </div>
                  <span class="rating_num"
                    >({{
                      item.product.star
                        ? (item.product.star * 20).toFixed(0) + "%"
                        : "N/A"
                    }})</span
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-if="wishlist.length === 0" class="col-12 text-center">
          <hr />
          <br>
          <h2>Your wishlist is empty!</h2>
          <br>
          <hr />
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
  <!-- END MAIN CONTENT -->
</template>

<script setup>
import { ref, onMounted } from "vue";
import apiClient from "../../lib/axiosClient";
import { useAuth } from "../../store/auth";
import { useRouter } from "vue-router";
import { toast } from "vue3-toastify";
import { useCartStore } from "../../store/cart";

const auth = useAuth();
const cart = useCartStore();

const router = useRouter();
const wishlist = ref(JSON.parse(localStorage.getItem("wishlist")) || []);

const saveToLocalStorage = () => {
  localStorage.setItem("wishlist", JSON.stringify(wishlist.value));
};

const loadWishlist = async () => {
  if (!auth.isAuthenticated) {
    return;
  }
  try {
    const { data } = await apiClient.get("/wish-list");

    wishlist.value = data.data;
    saveToLocalStorage();
  } catch (error) {
    console.error("Failed to load wishlist", error);
  }
};

const removeWishList = async (productId) => {
  try {
    const { data } = await apiClient.post("remove/wish-list", {
      product_id: productId,
    });

    toast.success(
      Array.isArray(data?.message) ? data.message[0] : data?.message
    );

    wishlist.value = wishlist.value.filter(
      (item) => item.product_id !== productId
    );

    saveToLocalStorage();
  } catch (error) {
    toast.error(error.response?.data?.message || "Failed to remove wishlist");
  }
};

onMounted(() => {
  loadWishlist();
});
</script>
<style scoped>
.wishlist-info {
  position: relative;
}

.wishlist-info .product-remove {
  position: absolute;
  bottom: 8px;
  right: 8px;
  z-index: 5;
}

.wishlist-info .product-remove a i {
  width: 28px;
  height: 28px;
  color: #ff324d;
  border-radius: 10%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 15px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
  transition: all 0.2s ease;
}

.wishlist-info .product-remove a:hover i {
  background: #ff324d;
  color: #fff;
  transform: scale(1.1);
}
</style>
