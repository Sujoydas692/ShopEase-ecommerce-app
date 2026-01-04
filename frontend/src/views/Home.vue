<template>
  <!-- END MAIN CONTENT -->
  <div class="main_content">
    <!-- START SECTION BANNER -->
    <div class="section pb_20">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="single_banner">
              <img
                src="/assets/images/shop_banner_img1.jpg"
                alt="shop_banner_img1"
              />
              <div class="single_banner_info">
                <h5 class="single_bn_title1">Super Sale</h5>
                <h3 class="single_bn_title">New Collection</h3>
                <a href="shop-left-sidebar.html" class="single_bn_link"
                  >Shop Now</a
                >
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="single_banner">
              <img
                src="/assets/images/shop_banner_img2.jpg"
                alt="shop_banner_img2"
              />
              <div class="single_banner_info">
                <h3 class="single_bn_title">New Season</h3>
                <h4 class="single_bn_title1">Sale 40% Off</h4>
                <a href="shop-left-sidebar.html" class="single_bn_link"
                  >Shop Now</a
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END SECTION BANNER -->

    <!-- START SECTION SHOP -->
    <div class="section small_pt pb_70">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="heading_s1 text-center">
              <h2>Exclusive Products</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="tab-style1">
              <ul class="nav nav-tabs justify-content-center" role="tablist">
                <li class="nav-item">
                  <a
                    class="nav-link active"
                    id="arrival-tab"
                    data-bs-toggle="tab"
                    href="#arrival"
                    role="tab"
                    aria-controls="arrival"
                    aria-selected="true"
                    >New Arrival</a
                  >
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link"
                    id="sellers-tab"
                    data-bs-toggle="tab"
                    href="#sellers"
                    role="tab"
                    aria-controls="sellers"
                    aria-selected="false"
                    >Best Sellers</a
                  >
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link"
                    id="featured-tab"
                    data-bs-toggle="tab"
                    href="#featured"
                    role="tab"
                    aria-controls="featured"
                    aria-selected="false"
                    >Featured</a
                  >
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link"
                    id="popular-tab"
                    data-bs-toggle="tab"
                    href="#popular"
                    role="tab"
                    aria-controls="popular"
                    aria-selected="false"
                    >Popular
                  </a>
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link"
                    id="trending-tab"
                    data-bs-toggle="tab"
                    href="#trending"
                    role="tab"
                    aria-controls="trending"
                    aria-selected="false"
                    >Trending
                  </a>
                </li>
              </ul>
            </div>
            <div class="tab-content">
              <div
                class="tab-pane fade show active"
                id="arrival"
                role="tabpanel"
                aria-labelledby="arrival-tab"
              >
                <div class="row shop_container">
                  <div
                    class="col-lg-3 col-md-4 col-6"
                    v-for="product in sections.new.products"
                    :key="product.id"
                  >
                    <div class="product">
                      <div class="product_img">
                        <a href="shop-product-detail.html">
                          <img :src="product.image" alt="product_img1" />
                        </a>
                        <div class="product_action_box">
                          <ul class="list_none pr_action_btn">
                            <li class="add-to-cart">
                              <a
                                href="javascript:void(0)"
                                @click.prevent="addToCartItem(product.id)"
                                ><i class="icon-basket-loaded"></i> Add To
                                Cart</a
                              >
                            </li>
                            <li>
                              <a
                                href="javascript:void(0)"
                                @click.prevent="openQuickView(product)"
                              >
                                <i class="icon-magnifier-add"></i>
                              </a>
                            </li>
                            <li
                              :class="{
                                'active-wish': wishlist.includes(product.id),
                              }"
                            >
                              <a
                                href="javascript:void(0)"
                                @click.prevent="addToWish(product.id)"
                                ><i class="icon-heart"></i
                              ></a>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="product_info">
                        <h6 class="product_title">
                          <a href="shop-product-detail.html">{{
                            product.title
                          }}</a>
                        </h6>
                        <div class="product_price">
                          <span class="price">৳ {{ product.price }}</span>
                          <del>৳55.25</del>
                          <div class="on_sale">
                            <span v-if="product.discount">
                              <template
                                v-if="product.discount_type === 'percentage'"
                              >
                                {{ product.discount }}% Off
                              </template>

                              <template
                                v-else-if="product.discount_type === 'fixed'"
                              >
                                ৳ {{ product.discount }} Off
                              </template>
                            </span>
                          </div>
                        </div>
                        <div class="rating_wrap">
                          <div class="rating">
                            <div
                              class="product_rate"
                              :style="{
                                width: ((product.star ?? 0) / 5) * 100 + '%',
                              }"
                            ></div>
                          </div>
                          <span class="rating_num"
                            >({{
                              product.star
                                ? (product.star * 20).toFixed(0) + "%"
                                : "N/A"
                            }})</span
                          >
                        </div>
                        <div class="pr_desc">
                          <p>
                            {{ product.short_desc }}
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- pagination start -->
                <Pagination
                  v-if="sections.new.meta.last_page > 1"
                  :meta="sections.new.meta"
                  @page-changed="(page) => loadProducts('new', page)"
                />
                <!-- pagination end -->
              </div>

              <div
                class="tab-pane fade"
                id="sellers"
                role="tabpanel"
                aria-labelledby="sellers-tab"
              >
                <div class="row shop_container">
                  <div
                    class="col-lg-3 col-md-4 col-6"
                    v-for="product in sections.bestseller.products"
                    :key="product.id"
                  >
                    <div class="product">
                      <div class="product_img">
                        <a href="shop-product-detail.html">
                          <img :src="product.image" alt="product_img9" />
                        </a>
                        <div class="product_action_box">
                          <ul class="list_none pr_action_btn">
                            <li class="add-to-cart">
                              <a
                                href="javascript:void(0)"
                                @click.prevent="addToCartItem(product.id)"
                                ><i class="icon-basket-loaded"></i> Add To
                                Cart</a
                              >
                            </li>
                            <li>
                              <a
                                href="javascript:void(0)"
                                @click.prevent="openQuickView(product)"
                              >
                                <i class="icon-magnifier-add"></i>
                              </a>
                            </li>
                            <li
                              :class="{
                                'active-wish': wishlist.includes(product.id),
                              }"
                            >
                              <a
                                href="javascript:void(0)"
                                @click.prevent="addToWish(product.id)"
                                ><i class="icon-heart"></i
                              ></a>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="product_info">
                        <h6 class="product_title">
                          <a href="shop-product-detail.html">{{
                            product.title
                          }}</a>
                        </h6>
                        <div class="product_price">
                          <span class="price">৳ {{ product.price }}</span>
                          <del>৳55.25</del>
                          <div class="on_sale">
                            <span v-if="product.discount">
                              <template
                                v-if="product.discount_type === 'percentage'"
                              >
                                {{ product.discount }}% Off
                              </template>

                              <template
                                v-else-if="product.discount_type === 'fixed'"
                              >
                                ৳ {{ product.discount }} Off
                              </template>
                            </span>
                          </div>
                        </div>
                        <div class="rating_wrap">
                          <div class="rating">
                            <div
                              class="product_rate"
                              :style="{
                                width: ((product.star ?? 0) / 5) * 100 + '%',
                              }"
                            ></div>
                          </div>
                          <span class="rating_num"
                            >({{
                              product.star
                                ? (product.star * 20).toFixed(0) + "%"
                                : "N/A"
                            }})</span
                          >
                        </div>
                        <div class="pr_desc">
                          <p>
                            {{ product.short_desc }}
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- pagination start -->
                <Pagination
                  v-if="sections.bestseller.meta.last_page > 1"
                  :meta="sections.bestseller.meta"
                  @page-changed="(page) => loadProducts('bestseller', page)"
                />
                <!-- pagination end -->
              </div>

              <div
                class="tab-pane fade"
                id="featured"
                role="tabpanel"
                aria-labelledby="featured-tab"
              >
                <div class="row shop_container">
                  <div
                    class="col-lg-3 col-md-4 col-6"
                    v-for="product in sections.featured.products"
                    :key="product.id"
                  >
                    <div class="product">
                      <div class="product_img">
                        <a href="shop-product-detail.html">
                          <img :src="product.image" alt="product_img5" />
                        </a>
                        <div class="product_action_box">
                          <ul class="list_none pr_action_btn">
                            <li class="add-to-cart">
                              <a
                                href="javascript:void(0)"
                                @click.prevent="addToCartItem(product.id)"
                                ><i class="icon-basket-loaded"></i> Add To
                                Cart</a
                              >
                            </li>
                            <li>
                              <a
                                href="javascript:void(0)"
                                @click.prevent="openQuickView(product)"
                              >
                                <i class="icon-magnifier-add"></i>
                              </a>
                            </li>
                            <li
                              :class="{
                                'active-wish': wishlist.includes(product.id),
                              }"
                            >
                              <a
                                href="javascript:void(0)"
                                @click.prevent="addToWish(product.id)"
                                ><i class="icon-heart"></i
                              ></a>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="product_info">
                        <h6 class="product_title">
                          <a href="shop-product-detail.html">{{
                            product.title
                          }}</a>
                        </h6>
                        <div class="product_price">
                          <span class="price">৳ {{ product.price }}</span>
                          <del>৳55.25</del>
                          <div class="on_sale">
                            <span v-if="product.discount">
                              <template
                                v-if="product.discount_type === 'percentage'"
                              >
                                {{ product.discount }}% Off
                              </template>

                              <template
                                v-else-if="product.discount_type === 'fixed'"
                              >
                                ৳ {{ product.discount }} Off
                              </template>
                            </span>
                          </div>
                        </div>
                        <div class="rating_wrap">
                          <div class="rating">
                            <div
                              class="product_rate"
                              :style="{
                                width: ((product.star ?? 0) / 5) * 100 + '%',
                              }"
                            ></div>
                          </div>
                          <span class="rating_num"
                            >({{
                              product.star
                                ? (product.star * 20).toFixed(0) + "%"
                                : "N/A"
                            }})</span
                          >
                        </div>
                        <div class="pr_desc">
                          <p>
                            {{ product.short_desc }}
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- pagination start -->
                <Pagination
                  v-if="sections.featured.meta.last_page > 1"
                  :meta="sections.featured.meta"
                  @page-changed="(page) => loadProducts('featured', page)"
                />
                <!-- pagination end -->
              </div>

              <div
                class="tab-pane fade"
                id="popular"
                role="tabpanel"
                aria-labelledby="popular-tab"
              >
                <div class="row shop_container">
                  <div
                    class="col-lg-3 col-md-4 col-6"
                    v-for="product in sections.popular.products"
                    :key="product.id"
                  >
                    <div class="product">
                      <div class="product_img">
                        <a href="shop-product-detail.html">
                          <img :src="product.image" alt="product_img4" />
                        </a>
                        <div class="product_action_box">
                          <ul class="list_none pr_action_btn">
                            <li class="add-to-cart">
                              <a
                                href="javascript:void(0)"
                                @click.prevent="addToCartItem(product.id)"
                                ><i class="icon-basket-loaded"></i> Add To
                                Cart</a
                              >
                            </li>
                            <li>
                              <a
                                href="javascript:void(0)"
                                @click.prevent="openQuickView(product)"
                              >
                                <i class="icon-magnifier-add"></i>
                              </a>
                            </li>
                            <li
                              :class="{
                                'active-wish': wishlist.includes(product.id),
                              }"
                            >
                              <a
                                href="javascript:void(0)"
                                @click.prevent="addToWish(product.id)"
                                ><i class="icon-heart"></i
                              ></a>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="product_info">
                        <h6 class="product_title">
                          <a href="shop-product-detail.html">{{
                            product.title
                          }}</a>
                        </h6>
                        <div class="product_price">
                          <span class="price">৳ {{ product.price }}</span>
                          <del>৳89.00</del>
                          <div class="on_sale">
                            <span v-if="product.discount">
                              <template
                                v-if="product.discount_type === 'percentage'"
                              >
                                {{ product.discount }}% Off
                              </template>

                              <template
                                v-else-if="product.discount_type === 'fixed'"
                              >
                                ৳ {{ product.discount }} Off
                              </template>
                            </span>
                          </div>
                        </div>
                        <div class="rating_wrap">
                          <div class="rating">
                            <div
                              class="product_rate"
                              :style="{
                                width: ((product.star ?? 0) / 5) * 100 + '%',
                              }"
                            ></div>
                          </div>
                          <span class="rating_num"
                            >({{
                              product.star
                                ? (product.star * 20).toFixed(0) + "%"
                                : "N/A"
                            }})</span
                          >
                        </div>
                        <div class="pr_desc">
                          <p>
                            {{ product.short_desc }}
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- pagination start -->
                <Pagination
                  v-if="sections.popular.meta.last_page > 1"
                  :meta="sections.popular.meta"
                  @page-changed="(page) => loadProducts('popular', page)"
                />
                <!-- pagination end -->
              </div>

              <div
                class="tab-pane fade"
                id="trending"
                role="tabpanel"
                aria-labelledby="trending-tab"
              >
                <div class="row shop_container">
                  <div
                    class="col-lg-3 col-md-4 col-6"
                    v-for="product in sections.trending.products"
                    :key="product.id"
                  >
                    <div class="product">
                      <div class="product_img">
                        <a href="shop-product-detail.html">
                          <img :src="product.image" alt="product_img4" />
                        </a>
                        <div class="product_action_box">
                          <ul class="list_none pr_action_btn">
                            <li class="add-to-cart">
                              <a
                                href="javascript:void(0)"
                                @click.prevent="addToCartItem(product.id)"
                                ><i class="icon-basket-loaded"></i> Add To
                                Cart</a
                              >
                            </li>
                            <li>
                              <a
                                href="javascript:void(0)"
                                @click.prevent="openQuickView(product)"
                              >
                                <i class="icon-magnifier-add"></i>
                              </a>
                            </li>
                            <li
                              :class="{
                                'active-wish': wishlist.includes(product.id),
                              }"
                            >
                              <a
                                href="javascript:void(0)"
                                @click.prevent="addToWish(product.id)"
                                ><i class="icon-heart"></i
                              ></a>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="product_info">
                        <h6 class="product_title">
                          <a href="shop-product-detail.html">{{
                            product.title
                          }}</a>
                        </h6>
                        <div class="product_price">
                          <span class="price">৳ {{ product.price }}</span>
                          <del>৳89.00</del>
                          <div class="on_sale">
                            <span v-if="product.discount">
                              <template
                                v-if="product.discount_type === 'percentage'"
                              >
                                {{ product.discount }}% Off
                              </template>

                              <template
                                v-else-if="product.discount_type === 'fixed'"
                              >
                                ৳ {{ product.discount }} Off
                              </template>
                            </span>
                          </div>
                        </div>
                        <div class="rating_wrap">
                          <div class="rating">
                            <div
                              class="product_rate"
                              :style="{
                                width: ((product.star ?? 0) / 5) * 100 + '%',
                              }"
                            ></div>
                          </div>
                          <span class="rating_num"
                            >({{
                              product.star
                                ? (product.star * 20).toFixed(0) + "%"
                                : "N/A"
                            }})</span
                          >
                        </div>
                        <div class="pr_desc">
                          <p>
                            {{ product.short_desc }}
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- pagination start -->
                <Pagination
                  v-if="sections.trending.meta.last_page > 1"
                  :meta="sections.trending.meta"
                  @page-changed="(page) => loadProducts('trending', page)"
                />
                <!-- pagination end -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END SECTION SHOP -->

    <!-- START SECTION SINGLE BANNER -->
    <div class="section bg_light_blue2 pb-0 pt-md-0">
      <div class="container">
        <div class="row align-items-center flex-row-reverse">
          <div class="col-md-6 offset-md-1">
            <div class="medium_divider d-none d-md-block clearfix"></div>
            <div class="trand_banner_text text-center text-md-start">
              <div class="heading_s1 mb-3">
                <span class="sub_heading">New season trends!</span>
                <h2>Best Summer Collection</h2>
              </div>
              <h5 class="mb-4">Sale Get up to 50% Off</h5>
              <a
                href="shop-left-sidebar.html"
                class="btn btn-fill-out rounded-0"
                >Shop Now</a
              >
            </div>
            <div class="medium_divider clearfix"></div>
          </div>
          <div class="col-md-5">
            <div class="text-center trading_img">
              <img src="/assets/images/tranding_img.png" alt="tranding_img" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END SECTION SINGLE BANNER -->

    <!-- START SECTION SHOP -->
    <div class="section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="heading_s1 text-center">
              <h2>Featured Products</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div
              class="product_slider carousel_slider owl-carousel owl-theme nav_style1"
              data-loop="true"
              data-dots="false"
              data-nav="true"
              data-margin="20"
              data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'
            >
              <div
                class="item"
                v-for="product in sections.featured.slider"
                :key="product.id"
              >
                <div class="product">
                  <div class="product_img">
                    <a href="shop-product-detail.html">
                      <img :src="product.image" alt="product_img1" />
                    </a>
                    <div class="product_action_box">
                      <ul class="list_none pr_action_btn">
                        <li class="add-to-cart">
                          <a
                            href="javascript:void(0)"
                            @click.prevent="addToCartItem(product.id)"
                            ><i class="icon-basket-loaded"></i> Add To Cart</a
                          >
                        </li>
                        <li>
                          <a
                            href="javascript:void(0)"
                            @click.prevent="openQuickView(product)"
                          >
                            <i class="icon-magnifier-add"></i>
                          </a>
                        </li>
                        <li
                          :class="{
                            'active-wish': wishlist.includes(product.id),
                          }"
                        >
                          <a
                            href="javascript:void(0)"
                            @click.prevent="addToWish(product.id)"
                            ><i class="icon-heart"></i
                          ></a>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="product_info">
                    <h6 class="product_title">
                      <a href="shop-product-detail.html">{{ product.title }}</a>
                    </h6>
                    <div class="product_price">
                      <span class="price">৳ {{ product.price }}</span>
                      <del>৳55.25</del>
                      <div class="on_sale">
                        <span v-if="product.discount">
                          <template
                            v-if="product.discount_type === 'percentage'"
                          >
                            {{ product.discount }}% Off
                          </template>

                          <template
                            v-else-if="product.discount_type === 'fixed'"
                          >
                            ৳ {{ product.discount }} Off
                          </template>
                        </span>
                      </div>
                    </div>
                    <div class="rating_wrap">
                      <div class="rating">
                        <div
                          class="product_rate"
                          :style="{
                            width: ((product.star ?? 0) / 5) * 100 + '%',
                          }"
                        ></div>
                      </div>
                      <span class="rating_num"
                        >({{
                          product.star
                            ? (product.star * 20).toFixed(0) + "%"
                            : "N/A"
                        }})</span
                      >
                    </div>
                    <div class="pr_desc">
                      <p>
                        {{ product.short_desc }}
                      </p>
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

    <!-- START SECTION TESTIMONIAL -->
    <div class="section bg_redon">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="heading_s1 text-center">
              <h2>Our Client Say!</h2>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-lg-9">
            <div
              class="testimonial_wrap testimonial_style1 carousel_slider owl-carousel owl-theme nav_style2"
              data-nav="true"
              data-dots="false"
              data-center="true"
              data-loop="true"
              data-autoplay="true"
              data-items="1"
            >
              <div class="testimonial_box">
                <div class="testimonial_desc">
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. A
                    aliquam amet animi blanditiis consequatur debitis dicta
                    distinctio, enim error eum iste libero modi nam natus
                    perferendis possimus quasi sint sit tempora voluptatem.
                  </p>
                </div>
                <div class="author_wrap">
                  <div class="author_img">
                    <img src="/assets/images/user_img1.jpg" alt="user_img1" />
                  </div>
                  <div class="author_name">
                    <h6>Lissa Castro</h6>
                    <span>Designer</span>
                  </div>
                </div>
              </div>
              <div class="testimonial_box">
                <div class="testimonial_desc">
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. A
                    aliquam amet animi blanditiis consequatur debitis dicta
                    distinctio, enim error eum iste libero modi nam natus
                    perferendis possimus quasi sint sit tempora voluptatem.
                  </p>
                </div>
                <div class="author_wrap">
                  <div class="author_img">
                    <img src="/assets/images/user_img2.jpg" alt="user_img2" />
                  </div>
                  <div class="author_name">
                    <h6>Alden Smith</h6>
                    <span>Designer</span>
                  </div>
                </div>
              </div>
              <div class="testimonial_box">
                <div class="testimonial_desc">
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. A
                    aliquam amet animi blanditiis consequatur debitis dicta
                    distinctio, enim error eum iste libero modi nam natus
                    perferendis possimus quasi sint sit tempora voluptatem.
                  </p>
                </div>
                <div class="author_wrap">
                  <div class="author_img">
                    <img src="/assets/images/user_img3.jpg" alt="user_img3" />
                  </div>
                  <div class="author_name">
                    <h6>Daisy Lana</h6>
                    <span>Designer</span>
                  </div>
                </div>
              </div>
              <div class="testimonial_box">
                <div class="testimonial_desc">
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. A
                    aliquam amet animi blanditiis consequatur debitis dicta
                    distinctio, enim error eum iste libero modi nam natus
                    perferendis possimus quasi sint sit tempora voluptatem.
                  </p>
                </div>
                <div class="author_wrap">
                  <div class="author_img">
                    <img src="/assets/images/user_img4.jpg" alt="user_img4" />
                  </div>
                  <div class="author_name">
                    <h6>John Becker</h6>
                    <span>Designer</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END SECTION TESTIMONIAL -->

    <!-- START SECTION SHOP INFO -->
    <div class="section pb_70">
      <div class="container">
        <div class="row g-0">
          <div class="col-lg-4">
            <div class="icon_box icon_box_style1">
              <div class="icon">
                <i class="flaticon-shipped"></i>
              </div>
              <div class="icon_box_content">
                <h5>Free Delivery</h5>
                <p>
                  If you are going to use of Lorem, you need to be sure there
                  anything
                </p>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="icon_box icon_box_style1">
              <div class="icon">
                <i class="flaticon-money-back"></i>
              </div>
              <div class="icon_box_content">
                <h5>30 Day Return</h5>
                <p>
                  If you are going to use of Lorem, you need to be sure there
                  anything
                </p>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="icon_box icon_box_style1">
              <div class="icon">
                <i class="flaticon-support"></i>
              </div>
              <div class="icon_box_content">
                <h5>27/4 Support</h5>
                <p>
                  If you are going to use of Lorem, you need to be sure there
                  anything
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END SECTION SHOP INFO -->

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
  <Teleport to="#quickview-container">
    <ProductQuickView
      v-if="quickViewVisible"
      :product="quickViewProduct"
      @close="closeQuickView"
    />
  </Teleport>
  <!-- END MAIN CONTENT -->
</template>

<script setup>
import { ref, reactive, onMounted, nextTick } from "vue";
import apiClient from "../lib/axiosClient";
import Pagination from "../components/Pagination.vue";
import { useAuth } from "../store/auth";
import { useCartStore } from "../store/cart";
import { useRouter } from "vue-router";
import { toast } from "vue3-toastify";
import ProductQuickView from "./ProductQuickView.vue";

const auth = useAuth();
const cart = useCartStore();

const router = useRouter();
const wishlist = ref([]);

const quickViewProduct = ref(null);
const quickViewVisible = ref(false);
const isOpening = ref(false);

const openQuickView = async (product) => {
  if (isOpening.value) return;

  isOpening.value = true;

  if (quickViewVisible.value) {
    closeQuickView();
    await new Promise((resolve) => setTimeout(resolve, 100));
  }

  quickViewProduct.value = product;
  quickViewVisible.value = true;

  setTimeout(() => {
    isOpening.value = false;
  }, 300);
};

const closeQuickView = () => {
  quickViewVisible.value = false;
  setTimeout(() => {
    quickViewProduct.value = null;
  }, 300);
};

const savedNewProducts = JSON.parse(localStorage.getItem("new_products")) || [];

const sections = reactive({
  new: { products: savedNewProducts, meta: {}, links: [] },
  featured: { slider: [], products: [], meta: {}, links: [] },
  bestseller: { products: [], meta: {}, links: [] },
  popular: { products: [], meta: {}, links: [] },
  trending: { products: [], meta: {}, links: [] },
});

const loadFeaturedSlider = async () => {
  try {
    const res = await apiClient.get("/product/featured", {
      params: { remarks: "featured", all: true },
    });

    sections.featured.slider = res.data.data ?? [];

    initCarousel();
  } catch (error) {
    console.error("Featured Slider Load Error:", error);
  }
};

const loadProducts = async (type, page = 1) => {
  const res = await apiClient.get("/products", {
    params: { remarks: type, page },
  });

  const paginated =
    res.data.data.data && Array.isArray(res.data.data.data)
      ? res.data.data
      : res.data.data;

  sections[type].products = paginated.data ?? [];

  if (type === "new") {
    localStorage.setItem("new_products", JSON.stringify(paginated.data));
  }

  sections[type].meta = {
    current_page: paginated.current_page,
    last_page: paginated.last_page,
    per_page: paginated.per_page,
    total: paginated.total,
    from: paginated.from,
    to: paginated.to,
  };

  sections[type].links = {
    prev: paginated.prev_page_url,
    next: paginated.next_page_url,
  };

  initCarousel();
};

const initCarousel = () => {
  nextTick(() => {
    const $slider = $(".product_slider");

    if ($slider.length && typeof $.fn.owlCarousel !== "undefined") {
      if ($slider.hasClass("owl-loaded")) {
        $slider.trigger("destroy.owl.carousel");
        $slider.removeClass("owl-loaded");
        $slider.find(".owl-stage-outer").children().unwrap();
      }

      $slider.owlCarousel({
        loop: true,
        nav: true,
        dots: false,
        margin: 20,
        responsive: {
          0: { items: 1 },
          481: { items: 2 },
          768: { items: 3 },
          1199: { items: 4 },
        },
      });
    }
  });
};

onMounted(() => {
  loadWishlist();
  loadFeaturedSlider();
  loadProducts("new");
  loadProducts("featured");
  loadProducts("bestseller");
  loadProducts("popular");
  loadProducts("trending");
});

const loadWishlist = async () => {
  if (!auth.isAuthenticated) {
    return;
  }
  try {
    const { data } = await apiClient.get("/wish-list");

    wishlist.value = data.data.map((item) => item.product_id);
  } catch (error) {
    console.error("Failed to load wishlist", error);
  }
};

const addToWish = async (productId) => {
  if (!auth.isAuthenticated) {
    toast.warning("You need to login first!");

    setTimeout(() => {
      router.push("/login");
      return;
    }, 2000);
  } else {
    try {
      const { data } = await apiClient.post("add/wish-list", {
        product_id: productId,
      });

      toast.success(
        Array.isArray(data?.message) ? data.message[0] : data?.message
      );

      if (wishlist.value.includes(productId)) {
        wishlist.value = wishlist.value.filter((id) => id !== productId);
      } else {
        wishlist.value.push(productId);
      }
    } catch (error) {
      toast.error(error.response?.data?.message || "Failed to add to wishlist");
    }
  }
};
const addToCartItem = async (productId) => {
  await cart.addToCart({
    productId,
  });
};
</script>
<style scoped>
.active-wish a i {
  padding: 9.5px 10px 10px 10px;
  background: #ff324d !important;
  color: #fff !important;
}
.active-cart a i {
  padding: 9.5px 10px 10px 10px;
  background: #ff324d !important;
  color: #fff !important;
}
</style>
