<template>
  <!-- START SECTION BREADCRUMB -->
  <div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
      <!-- STRART CONTAINER -->
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="page-title">
            <h1>Login</h1>
          </div>
        </div>
        <div class="col-md-6">
          <ol class="breadcrumb justify-content-md-end">
            <li class="breadcrumb-item">
              <router-link to="/">Home</router-link>
            </li>
            <li class="breadcrumb-item active">Login</li>
          </ol>
        </div>
      </div>
    </div>
    <!-- END CONTAINER-->
  </div>
  <!-- END SECTION BREADCRUMB -->

  <!-- START MAIN CONTENT -->
  <div class="main_content">
    <!-- START LOGIN SECTION -->
    <div class="login_register_wrap section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-6 col-md-10">
            <div class="login_wrap">
              <div class="padding_eight_all bg-white">
                <div class="heading_s1">
                  <h3 class="text-center">Login</h3>
                </div>
                <div v-if="!auth.otpSent">
                  <div class="form-group mb-3">
                    <input
                      type="text"
                      v-model="email"
                      class="form-control"
                      placeholder="Your Email"
                      @blur="validateOnBlur"
                    />
                    <span v-if="auth.message" class="text-danger">{{
                      auth.message
                    }}</span>
                  </div>
                  <div class="form-group mb-3">
                    <button
                      class="btn btn-fill-out btn-block"
                      :disabled="auth.sending || !email"
                      @click="otpSend"
                      name="login"
                    >
                      {{ auth.sending ? "Sending..." : "Send OTP" }}
                    </button>
                  </div>
                </div>

                <div v-if="auth.otpSent">
                  <div class="form-group mb-3">
                    <input
                      type="text"
                      v-model="otp"
                      class="form-control"
                      placeholder="Your OTP"
                      @blur="validateOtpBlur"
                    />
                    <span v-if="otpError" class="text-danger">{{ otpError }}</span>
                  </div>
                  <div class="form-group mb-3">
                    <button
                      class="btn btn-fill-out btn-block"
                      :disabled="auth.verifying || otp.length !== 6"
                      @click="verifyOtp"
                      name="login"
                    >
                      {{ auth.verifying ? "Login in..." : "Login" }}
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END LOGIN SECTION -->
  </div>
  <!-- END MAIN CONTENT -->
</template>

<script setup>
import { ref, watch, onBeforeMount } from "vue";
import { useAuth } from "../../store/auth";

const auth = useAuth();

const email = ref("");
const otp = ref("");
const otpError = ref("");

onBeforeMount(() => {
  auth.email = "";
  auth.message = "";
  auth.otpSent = false;
  auth.sending = false;
  auth.verifying = false;
});

watch(email, (val) => {
  auth.email = val;

  if (!val) {
    auth.message = "*The email field is required.";
    return;
  }
  if (!val.includes("@") || !val.includes(".")) {
    auth.message = "*The email field must be a valid email address.";
    return;
  }
  auth.message = "";
});

watch(otp, (val) => {
  if (!val) {
    otpError.value = "*The OTP field is required.";
    return;
  }

  if (!/^[0-9]+$/.test(val)) {
    otpError.value = "*OTP must be digits only.";
    return;
  }

  if (val.length !== 6) {
    otpError.value = "*OTP must be exactly 6 digits.";
    return;
  }

  otpError.value = "";
});

const validateOnBlur = () => {
  if (!email.value) {
    auth.message = "*The email field is required.";
    return;
  }

  if (!email.value.includes("@") || !email.value.includes(".")) {
    auth.message = "*The email field must be a valid email address.";
    return;
  }

  auth.message = "";
};

const validateOtpBlur = () => {
  if (!otp.value) {
    otpError.value = "*The OTP field is required.";
    return;
  }

  if (!/^[0-9]+$/.test(otp.value)) {
    otpError.value = "*OTP must be digits only.";
    return;
  }

  if (otp.value.length !== 6) {
    otpError.value = "*OTP must be exactly 6 digits.";
    return;
  }

  otpError.value = "";
};

const otpSend = () => {
  auth.sendOtp(email.value);
};

const verifyOtp = () => {
  auth.verifyOtp(otp.value);
};
</script>
