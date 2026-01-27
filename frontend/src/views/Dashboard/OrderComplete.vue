<template>
  <!-- START SECTION BREADCRUMB -->
  <div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
      <!-- STRART CONTAINER -->
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="page-title">
            <h1>Order Completed</h1>
          </div>
        </div>
        <div class="col-md-6">
          <ol class="breadcrumb justify-content-md-end">
            <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
            <li class="breadcrumb-item active">Order Completed</li>
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
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="text-center order_complete">
              <i class="fas fa-check-circle"></i>
              <div class="heading_s1">
                <h3>Your order is completed!</h3>
              </div>
              <p>
                Thank you for your order! Your order is being processed. You will receive an email
                confirmation when your order is completed.
              </p>
              <router-link to="/" class="btn btn-fill-out"
                >Continue Shopping</router-link
              >
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END SECTION SHOP -->
  </div>
  <!-- END MAIN CONTENT -->
</template>
<script setup></script>
<style scoped></style>
