<template>
  <!-- START SECTION BREADCRUMB -->
  <div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
      <!-- STRART CONTAINER -->
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="page-title">
            <h1>Shopping Cart</h1>
          </div>
        </div>
        <div class="col-md-6">
          <ol class="breadcrumb justify-content-md-end">
            <li class="breadcrumb-item">
              <router-link to="/">Home</router-link>
            </li>
            <li class="breadcrumb-item active">Shopping Cart</li>
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
            <div class="table-responsive shop_cart_table">
              <table class="table">
                <thead>
                  <tr>
                    <th class="product-thumbnail">Image</th>
                    <th class="product-name">Product</th>
                    <th class="product-name">Size</th>
                    <th class="product-name">Color</th>
                    <th class="product-price">Price</th>
                    <th class="product-quantity">Quantity</th>
                    <th class="product-subtotal">Total</th>
                    <th class="product-remove">Remove</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if="cart.carts.length === 0">
                    <td colspan="8" class="text-center py-4">
                      <h4>Your cart is empty!</h4>
                    </td>
                  </tr>
                  <tr v-for="item in cart.carts" :key="item.id">
                    <td class="product-thumbnail">
                      <a href="#"
                        ><img :src="item.product.image" alt="product1"
                      /></a>
                    </td>
                    <td class="product-name" data-title="Product">
                      <a href="#">{{ item.product.title }}</a>
                    </td>
                    <td class="product-name" data-title="Size">
                      <span v-if="item.size">{{ item.size }}</span>
                      <span v-else>-</span>
                    </td>

                    <td class="product-name" data-title="Color">
                      <span v-if="item.color">{{ item.color }}</span>
                      <span v-else>-</span>
                    </td>
                    <td class="product-price" data-title="Price">
                      ৳ {{ item.product.price }}
                    </td>
                    <td class="product-quantity" data-title="Quantity">
                      <div class="quantity">
                        <input
                          type="button"
                          value="-"
                          class="minus"
                          @click="updateQty(item, 'decrease')"
                        />
                        <input
                          type="number"
                          v-model.number="item.qty"
                          min="1"
                          class="qty"
                          size="4"
                          @change="updateQty(item)"
                        />
                        <input
                          type="button"
                          value="+"
                          class="plus"
                          @click="updateQty(item, 'increase')"
                        />
                      </div>
                    </td>
                    <td class="product-subtotal" data-title="Total">
                      ৳ {{ (item.qty * item.product.price).toFixed(2) }}
                    </td>
                    <td class="product-remove" data-title="Remove">
                      <a
                        href="javascript:void(0)"
                        @click="removeCartItem(item.id)"
                        ><i class="ti-close"></i
                      ></a>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="8" class="px-0">
                      <div class="row g-0 align-items-center">
                        <div class="col-lg-4 col-md-6 mb-3 mb-md-0">
                          <div class="coupon field_form input-group">
                            <input
                              type="text"
                              value=""
                              class="form-control form-control-sm"
                              placeholder="Enter Coupon Code.."
                            />
                            <div class="input-group-append">
                              <button
                                class="btn btn-fill-out btn-sm"
                                type="submit"
                              >
                                Apply Coupon
                              </button>
                            </div>
                          </div>
                        </div>
                        <div
                          class="col-lg-8 col-md-6 text-start text-md-end"
                          v-if="cart.carts.length === 0"
                        >
                          <button
                            class="btn btn-line-fill btn-sm"
                            @click="clearCart"
                            type="submit"
                            disabled
                          >
                            Clear Cart
                          </button>
                        </div>
                        <div
                          class="col-lg-8 col-md-6 text-start text-md-end"
                          v-else
                        >
                          <button
                            class="btn btn-line-fill btn-sm"
                            @click="clearCart"
                            type="submit"
                          >
                            Clear Cart
                          </button>
                        </div>
                      </div>
                    </td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="medium_divider"></div>
            <div class="divider center_icon">
              <i class="ti-shopping-cart-full"></i>
            </div>
            <div class="medium_divider"></div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="heading_s1 mb-3">
              <h6>Calculate Shipping</h6>
            </div>
            <form class="field_form shipping_calculator">
              <div class="form-row">
                <div class="form-group col-lg-12 mb-3">
                  <div class="custom_select">
                    <select
                      v-model="cart.selectedDistrict"
                      class="form-control"
                      @change="onDistrictChange($event)"
                    >
                      <option value="0">Select District...</option>
                      <option
                        v-for="d in cart.districts"
                        :key="d.id"
                        :value="d.id"
                      >
                        {{ d.name }}
                      </option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-lg-12 mb-3">
                  <div class="custom_select">
                    <select
                      v-model="cart.selectedUpazila"
                      @change="cart.setUpazila(cart.selectedUpazila)"
                      class="form-control"
                    >
                      <option value="0">Select Thana/Upazila...</option>
                      <option
                        v-for="u in cart.upazilas"
                        :key="u.id"
                        :value="u.id"
                      >
                        {{ u.name }}
                      </option>
                    </select>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="col-md-6">
            <div class="border p-3 p-md-4">
              <div class="heading_s1 mb-3">
                <h6>Cart Totals</h6>
              </div>
              <div class="table-responsive">
                <table class="table">
                  <tbody>
                    <tr>
                      <td class="cart_total_label">Cart Subtotal</td>
                      <td class="cart_total_amount">৳ {{ cart.subtotal }}</td>
                    </tr>
                    <tr>
                      <td class="cart_total_label">Shipping</td>
                      <td class="cart_total_amount">
                        {{
                          cart.selectedDistrict && cart.shippingCharge
                            ? `৳ ${cart.shippingCharge}`
                            : "Free Shipping"
                        }}
                      </td>
                    </tr>
                    <tr>
                      <td class="cart_total_label">Total</td>
                      <td class="cart_total_amount">
                        <strong>৳ {{ cart.grandTotal }}</strong>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <router-link
                to="/dashboard/checkout"
                class="btn btn-fill-out"
                :class="{ disabled: cart.carts.length === 0 }"
                >Proceed To CheckOut</router-link
              >
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
import { onMounted } from "vue";
import { useAuth } from "../../store/auth";
import { useCartStore } from "../../store/cart";

const auth = useAuth();
const cart = useCartStore();

const updateQty = (item, type) => {
  cart.updateCartQty(item.id, type);
};

const removeCartItem = (id) => {
  cart.removeCart(id);
};

const clearCart = () => {
  cart.flashCart();
};

const onDistrictChange = (event) => {
  const districtId = event.target.value;

  cart.setDistrict(districtId);
  cart.loadUpazila(districtId);
};

onMounted(() => {
  if (auth.isAuthenticated) {
    cart.loadCartFromLocal();
    cart.loadCart();
    cart.loadDistricts();
    cart.loadLocationFromLocal();
    if (cart.selectedDistrict) {
      cart.loadUpazila(cart.selectedDistrict);
    }
  }
});
</script>
<style scoped></style>
