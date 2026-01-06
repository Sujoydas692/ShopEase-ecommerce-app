<template>
  <!-- START SECTION BREADCRUMB -->
  <div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
      <!-- STRART CONTAINER -->
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="page-title">
            <h1>Checkout</h1>
          </div>
        </div>
        <div class="col-md-6">
          <ol class="breadcrumb justify-content-md-end">
            <li class="breadcrumb-item">
              <router-link to="/">Home</router-link>
            </li>
            <li class="breadcrumb-item active">Checkout</li>
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
          <div class="col-lg-12">
            <div class="toggle_info">
              <span
                ><i class="fas fa-tag"></i>Have a coupon?
                <a
                  href="#coupon"
                  data-bs-toggle="collapse"
                  class="collapsed"
                  aria-expanded="false"
                  >Click here to enter your code</a
                ></span
              >
            </div>
            <div class="panel-collapse collapse coupon_form" id="coupon">
              <div class="panel-body">
                <p>If you have a coupon code, please apply it below.</p>
                <div class="coupon field_form input-group">
                  <input
                    type="text"
                    value=""
                    class="form-control"
                    placeholder="Enter Coupon Code.."
                  />
                  <div class="input-group-append">
                    <button class="btn btn-fill-out btn-sm" type="submit">
                      Apply Coupon
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="medium_divider"></div>
            <div class="divider center_icon">
              <i class="linearicons-credit-card"></i>
            </div>
            <div class="medium_divider"></div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="heading_s1">
              <h4>Billing Details</h4>
            </div>
            <form method="post">
              <div class="form-group mb-3">
                <input
                  type="text"
                  class="form-control"
                  v-model="formData.first_name"
                  required
                  placeholder="First name *"
                />
              </div>
              <div class="form-group mb-3">
                <input
                  type="text"
                  class="form-control"
                  v-model="formData.last_name"
                  required
                  placeholder="Last name *"
                />
              </div>

              <div class="form-group mb-3">
                <input
                  type="text"
                  class="form-control"
                  v-model="formData.email"
                  required
                  placeholder="Email address *"
                />
              </div>
              <div class="form-group mb-3">
                <input
                  type="text"
                  class="form-control"
                  v-model="formData.phone"
                  required
                  placeholder="Phone *"
                />
              </div>
              <div class="form-group mb-3">
                <div class="custom_select">
                  <select
                    class="form-control"
                    v-model="formData.district_id"
                    @change="updateDistrict"
                    :disabled="false"
                  >
                    <option value="">Select District...</option>
                    <option
                      v-for="d in cartStore.districts"
                      :key="d.id"
                      :value="d.id"
                    >
                      {{ d.name }}
                    </option>
                  </select>
                </div>
              </div>

              <div class="form-group mb-3">
                <div class="custom_select">
                  <select
                    class="form-control"
                    v-model="formData.upazila_id"
                    @change="updateUpazila"
                    :disabled="false"
                  >
                    <option value="">Select Thana/Upazila...</option>
                    <option
                      v-for="u in cartStore.upazilas"
                      :key="u.id"
                      :value="u.id"
                    >
                      {{ u.name }}
                    </option>
                  </select>
                </div>
              </div>
              <div class="form-group mb-3">
                <input
                  type="text"
                  class="form-control"
                  v-model="formData.address"
                  required
                  placeholder="Address *"
                />
              </div>
              <div class="form-group mb-3">
                <input
                  type="text"
                  class="form-control"
                  v-model="formData.postal_code"
                  placeholder="Postcode / ZIP"
                />
              </div>
            </form>
          </div>
          <div class="col-md-6">
            <div class="order_review">
              <div class="heading_s1">
                <h4>Your Orders</h4>
              </div>
              <div class="table-responsive order_table">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Product</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in cartStore.carts" :key="item.id">
                      <td>
                        <div>
                          <div class="fw-semibold">
                            {{ item.product.title }}
                            <span class="product-qty">x {{ item.qty }}</span>
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
                      </td>
                      <td>
                        ৳ {{ (item.product.price * item.qty).toFixed(2) }}
                      </td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>SubTotal</th>
                      <td class="product-subtotal">
                        ৳ {{ cartStore.subtotal }}
                      </td>
                    </tr>
                    <tr>
                      <th>Shipping</th>
                      <td>
                        <span v-if="cartStore.shippingCharge > 0"
                          >৳ {{ cartStore.shippingCharge }}</span
                        >
                        <span v-else>Free Shipping</span>
                      </td>
                    </tr>
                    <tr>
                      <th>Total</th>
                      <td class="product-subtotal">
                        ৳ {{ cartStore.grandTotal }}
                      </td>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <div class="payment_method">
                <div class="heading_s1">
                  <h4>Payment</h4>
                </div>
                <div class="payment_option">
                  <div class="custome-radio">
                    <input
                      class="form-check-input"
                      required=""
                      type="radio"
                      name="payment_option"
                      id="exampleRadios3"
                      value="cod"
                      v-model="formData.payment_method"
                    />
                    <label class="form-check-label" for="exampleRadios3"
                      >Cash On Delivery</label
                    >
                    <p data-method="option3" class="payment-text">
                      There are many variations of passages of Lorem Ipsum
                      available, but the majority have suffered alteration.
                    </p>
                  </div>
                  <div class="custome-radio">
                    <input
                      class="form-check-input"
                      type="radio"
                      name="payment_option"
                      id="exampleRadios4"
                      value="ssl"
                      v-model="formData.payment_method"
                    />
                    <label class="form-check-label" for="exampleRadios4"
                      >SSL Commerz</label
                    >
                    <p data-method="option4" class="payment-text">
                      Please send your cheque to Store Name, Store Street, Store
                      Town, Store State / County, Store Postcode.
                    </p>
                  </div>
                </div>
              </div>
              <a
                href="javascript:void(0)"
                @click.prevent="placeOrder"
                class="btn btn-fill-out btn-block"
              >
                {{ checkout.loading ? "Processing..." : "Place Order" }}
              </a>
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
import { onMounted, watch } from "vue";
import { useCheckoutStore } from "@/store/checkout";
import { useCartStore } from "@/store/cart";
import { useAuth } from "../../store/auth";
import { toast } from "vue3-toastify";

const checkout = useCheckoutStore();
const cartStore = useCartStore();
const auth = useAuth();

const formData = checkout.formData;

onMounted(async () => {
  await cartStore.loadDistricts();
  cartStore.loadLocationFromLocal();
  await checkout.loadCustomerProfile();

  formData.district_id = cartStore.selectedDistrict || "";

  if (cartStore.selectedDistrict) {
    await cartStore.loadUpazila(cartStore.selectedDistrict);
    formData.upazila_id = cartStore.selectedUpazila || "";
  }

  if (auth.user?.email) {
    formData.email = auth.user.email;
  }
});

watch(
  () => formData.district_id,
  (newVal) => {
    if (newVal) {
      cartStore.loadUpazila(newVal);
      formData.upazila_id = "";
    }
  }
);

const updateDistrict = () => {
  cartStore.setDistrict(formData.district_id);
  cartStore.loadUpazila(formData.district_id);
};

const updateUpazila = () => {
  cartStore.setUpazila(formData.upazila_id);
};

const placeOrder = async () => {
  if (!formData.first_name || !formData.last_name || !formData.phone) {
    toast.error("Please fill required fields!");
    return;
  }

  const districtId = Number(formData.district_id);
  const upazilaId = Number(formData.upazila_id);

  const payload = {
    first_name: formData.first_name,
    last_name: formData.last_name,
    email: formData.email,
    phone: formData.phone,
    district_id: districtId,
    upazila_id: upazilaId,
    district:
      cartStore.districts.find((d) => d.id === districtId)?.name || null,
    upazila: cartStore.upazilas.find((u) => u.id === upazilaId)?.name || null,
    address: formData.address,
    postal_code: formData.postal_code,
    payment_method: formData.payment_method,
    products: cartStore.carts.map((item) => ({
      product_id: item.product.id,
      qty: item.qty,
      price: item.product.price,
    })),
    subtotal: cartStore.subtotal,
    shipping: cartStore.shippingCharge,
    total: cartStore.grandTotal,
  };

  checkout.processCheckout(payload);
};
</script>
<style scoped></style>
