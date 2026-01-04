<template>
  <!-- START SECTION BREADCRUMB -->
  <div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
      <!-- STRART CONTAINER -->
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="page-title">
            <h1>My Account</h1>
          </div>
        </div>
        <div class="col-md-6">
          <ol class="breadcrumb justify-content-md-end">
            <li class="breadcrumb-item">
              <router-link to="/">Home</router-link>
            </li>
            <li class="breadcrumb-item active">My Account</li>
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
          <div class="col-lg-3 col-md-4">
            <div class="dashboard_menu">
              <ul class="nav nav-tabs flex-column" role="tablist">
                <li class="nav-item">
                  <a
                    class="nav-link active"
                    id="dashboard-tab"
                    data-bs-toggle="tab"
                    href="#dashboard"
                    role="tab"
                    aria-controls="dashboard"
                    aria-selected="false"
                    ><i class="ti-layout-grid2"></i>Dashboard</a
                  >
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link"
                    id="orders-tab"
                    data-bs-toggle="tab"
                    href="#orders"
                    role="tab"
                    aria-controls="orders"
                    aria-selected="false"
                    ><i class="ti-shopping-cart-full"></i>Orders</a
                  >
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link"
                    id="address-tab"
                    data-bs-toggle="tab"
                    href="#address"
                    role="tab"
                    aria-controls="address"
                    aria-selected="true"
                    ><i class="ti-location-pin"></i>My Address</a
                  >
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="javascript:void(0)" @click.prevent="logout"
                    ><i class="ti-lock"></i>Logout</a
                  >
                </li>
              </ul>
            </div>
          </div>
          <div class="col-lg-9 col-md-8">
            <div class="tab-content dashboard_content">
              <div
                class="tab-pane fade active show"
                id="dashboard"
                role="tabpanel"
                aria-labelledby="dashboard-tab"
              >
                <div class="card">
                  <div class="card-header">
                    <h3>Dashboard</h3>
                  </div>
                  <div class="card-body">
                    <p>
                      From your account dashboard. you can easily check &amp;
                      view your
                      <a
                        href="javascript:void(0)"
                        @click="switchTab('orders')"
                        >recent orders</a
                      >, manage your
                      <a
                        href="javascript:void(0)"
                        @click="switchTab('address')"
                        >shipping and billing addresses</a
                      >
                      and can
                      <a
                        href="javascript:void(0)"
                        @click.prevent="logout"
                        >logout</a
                      >
                       from your account.
                    </p>
                  </div>
                </div>
              </div>
              <div
                class="tab-pane fade"
                id="orders"
                role="tabpanel"
                aria-labelledby="orders-tab"
              >
                <div class="card">
                  <div class="card-header">
                    <h3>Orders</h3>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Order</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="order in orders" :key="order.id">
                            <td>{{ order.invoice_no }}</td>
                            <td>
                              {{ formatDate(order.created_at) }}
                            </td>
                            <td>{{ order.status }}</td>
                            <td>
                              ৳{{ order.payable }} for
                              {{
                                order.products?.reduce(
                                  (total, p) => total + p.quantity,
                                  0
                                )
                              }}
                              items
                            </td>
                            <td>
                              <a href="#" class="btn btn-fill-out btn-sm"
                                >View</a
                              >
                            </td>
                          </tr>
                          <tr v-if="orders.length === 0 && !loading">
                            <td colspan="5" class="text-center text-muted">
                              No orders found.
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div
                class="tab-pane fade"
                id="address"
                role="tabpanel"
                aria-labelledby="address-tab"
              >
                <div class="row">
                  <div class="col-lg-6">
                    <div class="card mb-3 mb-lg-0">
                      <div class="card-header">
                        <h3>Billing Address</h3>
                      </div>
                      <div class="card-body">
                        <address v-if="customer">
                          {{ customer.first_name }} {{ customer.last_name }}
                          <br />
                          {{ customer.phone }} <br />
                          {{ customer.address }} <br />
                          {{ customer.upazila }}, {{ customer.district }} <br />
                          {{ customer.postal_code }}
                        </address>
                        <p v-else class="text-muted">No customer profile created.</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="card">
                      <div class="card-header">
                        <h3>Shipping Address</h3>
                      </div>
                      <div class="card-body">
                        <address v-if="shipping">
                          {{ shipping.first_name }} {{ shipping.last_name }}
                          <br />
                          {{ shipping.phone }} <br />
                          {{ shipping.address }} <br />
                          {{ shipping.upazila }}, {{ shipping.district }} <br />
                          {{ shipping.postal_code }}
                        </address>
                        <p v-else class="text-muted">No customer profile created.</p>
                      </div>
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
import router from "../../router";
import { useAuth } from "../../store/auth";

const auth = useAuth();
const orders = ref([]);
const loading = ref(true);

const customer = ref({});
const shipping = ref({});

onMounted(() => {
  loadOrders();
});

const loadOrders = async () => {
  try {
    const res = await apiClient.get("/order");
    orders.value = res.data.data;
    if (orders.value.length > 0) {
      const firstOrder = orders.value[0];

      customer.value = firstOrder.cus_details
        ? JSON.parse(firstOrder.cus_details)
        : {};

      shipping.value = firstOrder.ship_details
        ? JSON.parse(firstOrder.ship_details)
        : {};
    }
  } catch (e) {
    console.log("Failed to load orders", e);
  } finally {
    loading.value = false;
  }
};

const logout = () => {
  auth.logout();
};

const formatDate = (date) => {
  return new Date(date).toLocaleDateString("en-US", {
    month: "long",
    day: "numeric",
    year: "numeric",
  });
};

const switchTab = (tabId) => {
  const tabTrigger = document.querySelector(`#${tabId}-tab`);
  if (tabTrigger) {
    tabTrigger.click();
  }
};
</script>
