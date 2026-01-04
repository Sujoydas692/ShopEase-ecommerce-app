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
        <div class="row">
          <div class="col-12">
            <div class="table-responsive wishlist_table">
              <table class="table">
                <thead>
                  <tr>
                    <th class="product-thumbnail">Image</th>
                    <th class="product-name">Product</th>
                    <th class="product-price">Price</th>
                    <th class="product-stock-status">Stock Status</th>
                    <th class="product-add-to-cart"></th>
                    <th class="product-remove">Remove</th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="item in wishlist"
                    :key="item.id"
                    v-if="wishlist.length > 0"
                  >
                    <td class="product-thumbnail">
                      <a href="#"
                        ><img :src="item.product.image" alt="product1"
                      /></a>
                    </td>
                    <td class="product-name" data-title="Product">
                      <a href="#">{{ item.product.title }}</a>
                    </td>
                    <td class="product-price" data-title="Price">
                      ৳ {{ item.product.price }}
                    </td>
                    <td
                      class="product-stock-status"
                      data-title="Stock Status"
                      v-if="item.product.stock > 1"
                    >
                      <span class="badge rounded-pill text-bg-success"
                        >In Stock</span
                      >
                    </td>
                    <td
                      class="product-stock-status"
                      data-title="Stock Status"
                      v-else
                    >
                      <span class="badge rounded-pill text-bg-danger"
                        >Stock Out</span
                      >
                    </td>
                    <td class="product-add-to-cart">
                      <a href="javascript:void(0)" class="btn btn-fill-out"
                      @click.prevent="addToCartItem(item.product.id)"
                        ><i class="icon-basket-loaded"></i> Add to Cart</a
                      >
                    </td>
                    <td class="product-remove" data-title="Remove">
                      <a
                        href="javascript:void(0)"
                        @click.prevent="removeWishList(item.product.id)"
                        ><i class="ti-close"></i
                      ></a>
                    </td>
                  </tr>
                  <tr v-else>
                    <td colspan="7" class="text-center py-5">
                      <h1><strong>Opps!</strong></h1>
                      <h4>No products in wishlist</h4>
                    </td>
                  </tr>
                </tbody>
              </table>
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

const addToCartItem = (productId) => {
  cart.addToCart(productId);
};

onMounted(() => {
  loadWishlist();
});
</script>
<style scoped></style>
