<template>
  <!-- START SECTION BANNER -->
  <div
    v-if="sliders.length > 0"
    class="banner_section slide_medium shop_banner_slider staggered-animation-wrap"
  >
    <div
      id="carouselExampleControls"
      class="carousel slide carousel-fade light_arrow"
      data-bs-ride="carousel"
    >
      <div class="carousel-inner">
        <div
          v-for="(slider, index) in sliders"
          :key="slider.id"
          :class="['carousel-item', 'background_bg', { active: index === 0 }]"
          :data-img-src="slider.image || getDefaultImage(index)"
          :style="{
            backgroundImage: `url('${slider.image || getDefaultImage(index)}')`,
          }"
        >
          <div class="banner_slide_content">
            <div class="container">
              <!-- STRART CONTAINER -->
              <div class="row">
                <div class="col-lg-7 col-9">
                  <div class="banner_content overflow-hidden">
                    <h5
                      v-if="slider.subtitle"
                      class="mb-3 staggered-animation font-weight-light"
                      data-animation="slideInLeft"
                      data-animation-delay="0.5s"
                    >
                      {{ slider.subtitle }}
                    </h5>
                    <h2
                      class="staggered-animation"
                      data-animation="slideInLeft"
                      data-animation-delay="1s"
                    >
                      {{ slider.title }}
                    </h2>
                    <router-link
                      v-if="slider.product_id"
                      :to="{
                        name: 'productdetail',
                        params: { slug: slider.product?.slug },
                      }"
                      class="btn btn-fill-out rounded-0 staggered-animation text-uppercase"
                      data-animation="slideInLeft"
                      data-animation-delay="1.5s"
                    >
                      {{ slider.button_text || "Shop Now" }}
                    </router-link>
                    <a
                      v-else-if="slider.url"
                      :href="slider.url"
                      class="btn btn-fill-out rounded-0 staggered-animation text-uppercase"
                      data-animation="slideInLeft"
                      data-animation-delay="1.5s"
                    >
                      {{ slider.button_text || "Shop Now" }}
                    </a>
                    <router-link
                      v-else
                      to="/shop"
                      class="btn btn-fill-out rounded-0 staggered-animation text-uppercase"
                      data-animation="slideInLeft"
                      data-animation-delay="1.5s"
                    >
                      {{ slider.button_text || "Shop Now" }}
                    </router-link>
                  </div>
                </div>
              </div>
            </div>
            <!-- END CONTAINER-->
          </div>
        </div>
      </div>
      <a
        class="carousel-control-prev"
        href="#carouselExampleControls"
        role="button"
        data-bs-slide="prev"
      >
        <i class="ion-chevron-left"></i>
      </a>
      <a
        class="carousel-control-next"
        href="#carouselExampleControls"
        role="button"
        data-bs-slide="next"
      >
        <i class="ion-chevron-right"></i>
      </a>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import apiClient from "../../lib/axiosClient";

const sliders = ref([]);
const loading = ref(true);

const STORAGE_KEY = "home_sliders";

const defaultImages = [
  "/assets/images/banner1.jpg",
  "/assets/images/banner2.jpg",
  "/assets/images/banner3.jpg",
];

const getDefaultImage = (index) => {
  return defaultImages[index] || defaultImages[0];
};

const loadFromStorage = () => {
  const cached = localStorage.getItem(STORAGE_KEY);
  if (cached) {
    try {
      sliders.value = JSON.parse(cached);
    } catch (e) {
      console.warn("Invalid slider cache");
    }
  }
};

const fetchSliders = async () => {
  try {
    loading.value = true;
    const response = await apiClient.get("/products/sliders");

    if (response.data.status && Array.isArray(response.data.data)) {
      const formatted = response.data.data.map((slider) => ({
        id: slider.id,
        title: slider.title || slider.product?.title || "Special Offer",
        subtitle:
          slider.subtitle || slider.product?.short_desc || "Exclusive Deal",
        image: slider.image || slider.product?.image || null,
        button_text: slider.button_text || "Shop Now",
        product_id: slider.product_id,
        product: slider.product || null,
        url: slider.url || null,
        is_active: slider.is_active ?? true,
        order: slider.order ?? 0,
      }));

      formatted.sort((a, b) => a.order - b.order);

      sliders.value = formatted;

      localStorage.setItem(STORAGE_KEY, JSON.stringify(formatted));
    }
  } catch (error) {
    console.error("Error fetching sliders:", error);
    sliders.value = [];
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  loadFromStorage();
  fetchSliders();

  setTimeout(() => {
    if (typeof window.bootstrap !== "undefined" && window.bootstrap.Carousel) {
      const carouselElement = document.getElementById(
        "carouselExampleControls"
      );
      if (carouselElement) {
        new window.bootstrap.Carousel(carouselElement);
      }
    }
  }, 500);
});
</script>

<style scoped>
.background_bg {
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  min-height: 500px;
}

.banner_slide_content {
  display: flex;
  align-items: center;
  height: 500px;
}

.banner_content {
  background: rgba(255, 255, 255, 0.24);
  padding: 30px;
  border-radius: 10px;
  backdrop-filter: blur(5px);
}

@media (max-width: 768px) {
  .banner_slide_content {
    height: 400px;
  }

  .background_bg {
    min-height: 400px;
  }

  .banner_content {
    padding: 20px;
  }
}

@media (max-width: 576px) {
  .banner_slide_content {
    height: 300px;
  }

  .background_bg {
    min-height: 300px;
  }

  .banner_content {
    padding: 15px;
  }
}
</style>
