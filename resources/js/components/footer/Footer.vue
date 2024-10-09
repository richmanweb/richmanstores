<template>
  <footer class="footer-background pt-8 text-white pb-14 pb-md-10 pb-lg-0">
    <v-container class="main-footer footer-content">
      <v-row>
        <v-col
          class=""
          cols="12"
          sm="8"
          md="6"
          lg="3"
        >
<!--            <div class="border-bottom pb-7 border-gray-800 mb-6">-->
            <div class="pb-2 mb-2">
                <img
                    :src="data.footer_logo"
                    class="mw-100"
                />
            </div>
          <div class="fs-14 fw-400 mb-7">
            {{ $t("get_your_special_offers_coupons__more") }}
          </div>

<!--            <VForm class="subscribe-form d-flex align-center gap-4">-->
<!--                <VTextField-->
<!--                    label="Subscribe to newsletter"-->
<!--                    placeholder="john@email.com"-->
<!--                    theme="dark"-->
<!--                    density="compact"-->
<!--                    class="footer-text"-->
<!--                />-->
<!--                <VBtn size="large">-->
<!--                    Subscribe-->
<!--                </VBtn>-->
<!--            </VForm>-->

          <v-form class="d-flex align-center gap-4" v-on:submit.prevent="subscribe()">
            <v-text-field
              :placeholder="$t('your_email_address')"
              type="email"
              color="primary"
              class="bg-white mb-2 subscriber-field text-field"
              v-model="subscribeForm.email"
              hide-details="auto"
              required
              variant="plain"
            ></v-text-field>
              <v-btn
                  class="px-1 mb-2 mx-2"
                  elevation="0"
                  type="submit"
                  color="white"
                  size="large"
                  @click="subscribe"
                  :loading="subscribeFormLoading"
                  :disabled="subscribeFormLoading"
              >{{ $t("subscribe") }}
              </v-btn>
          </v-form>

            <!--  -->
            <p
                v-for="error of v$.subscribeForm.email.$errors"
                :key="error.$uid"
                class="text-red"
            >
                {{error.$message }}
            </p>

<!--            <v-btn-->
<!--                variant="outlined"-->
<!--                class="px-12 mb-4"-->
<!--                elevation="0"-->
<!--                type="submit"-->
<!--                color="primary"-->
<!--                @click="subscribe"-->
<!--                :loading="subscribeFormLoading"-->
<!--                :disabled="subscribeFormLoading"-->
<!--                outlined-->
<!--            >{{ $t("subscribe") }}-->
<!--            </v-btn>-->
        </v-col>
        <v-col
          class="mb-5 d-none d-lg-block"
          lg="2"
          cols="12"
          offset-lg="1"
        >
          <h4 class="fs-18 mb-4">
            {{ data.footer_link_one?.title }}
          </h4>
          <ul class="list-unstyled ps-0 fs-13">
            <li
              v-for="(link, label, i) in data.footer_link_one?.menu"
              :key="i"
              class="py-2"
            >
              <dynamic-link
                :to="link"
                append-class="text-reset"
              >{{ label }}</dynamic-link>
            </li>
          </ul>
        </v-col>
        <v-col
          class="mb-5 d-none d-lg-block"
          lg="2"
          cols="12"
        >
          <h4 class="fs-18 mb-4">
            {{ data.footer_link_two?.title }}
          </h4>
          <ul class="list-unstyled ps-0 fs-13">
            <li
              v-for="(link, label, i) in data.footer_link_two?.menu"
              :key="i"
              class="py-2"
            >
              <dynamic-link
                :to="link"
                append-class="text-reset"
              >{{ label }}</dynamic-link>
            </li>
          </ul>
        </v-col>
        <v-col
          class="mb-5 d-none d-lg-block"
          lg="2"
          cols="12"
        >
          <h4 class="fs-18 mb-4">{{ $t("contact_us") }}</h4>
          <ul class="list-unstyled ps-0 fs-13">
            <li class="py-2 mb-2">
              <div class="opacity-50">
                <i class="las la-home me-3 mb-2"></i>
                {{ $t("address") }}
              </div>
              <div>
                {{ data.contact_info?.contact_address }}
              </div>
            </li>
            <li class="py-2 mb-2">
              <div class="opacity-50">
                <i class="las la-envelope me-3 mb-2"></i>
                {{ $t("email") }}
              </div>
              <div>
                {{ data.contact_info?.contact_email }}
              </div>
            </li>
            <li class="py-2 mb-2">
              <div class="opacity-50">
                <i class="las la-phone me-3 mb-2"></i>
                {{ $t("phone") }}
              </div>
              <div>
                {{ data.contact_info?.contact_phone}}
              </div>
            </li>
          </ul>
        </v-col>
        <v-col
          class="mb-5 d-none d-lg-block"
          lg="2"
          cols="12"
        >
          <div
            class="mobile-apps-area"
            v-if="app_store || play_store"
          >
            <h4 class="fs-18 mb-4">{{ $t("mobile_apps") }}</h4>
            <a
              v-if="play_store"
              :href="data.mobile_app_links?.play_store"
              target="_blank"
              class="d-inline-block pt-2"
            >
              <img
                :src="static_asset('/assets/img/play_store.png')"
                class="mw-100"
                height="40"
              />
            </a>
            <a
              v-if="app_store"
              :href="data.mobile_app_links?.app_store"
              target="_blank"
              class="d-inline-block pt-2"
            >
              <img
                :src="static_asset('/assets/img/app_store.png')"
                class="mw-100"
                height="40"
              />
            </a>
            <!-- affiliate -->
                <router-link
                v-if="this.generalSettings.affiliate_system == 1 && this.isAuthenticated && !this.isAffiliatedUser"
                  :to="{ name: 'AffiliateRegistration' }"
                  class="text-reset d-inline-block pt-2"
                >{{ $t('be_an_affiliate_partner') }}</router-link>
          </div>
          <template>
            <ul class="list-unstyled ps-0 fs-13">
              <div v-if="is_addon_activated('multi_vendor')">
                <h4 class="primary-text my-4">{{ $t("seller_zone") }}</h4>
                <li class="py-2">
                  <router-link
                    :to="{ name: 'ShopRegistration' }"
                    class="text-reset"
                  >{{ $t('be_a_seller') }}</router-link>
                </li>
                <li class="py-2">
                  <a
                    :href="$store.getters['app/appUrl']+'/login'"
                    class="text-reset"
                    target="_blank"
                  >{{ $t('login_to_seller_panel') }}</a>
                </li>
              </div>

            </ul>

          </template>

        </v-col>
        <v-col
          cols="12"
          class="d-lg-none mb-5"
        >
          <v-expansion-panels
            flat
            accordion
          >

            <v-expansion-panel class=" transparent text-white border-bottom border-gray-800">
              <v-expansion-panel-title
                class="px-0"
                expand-icon="las la-angle-down text-white fs-14"
                collapse-icon="las la-angle-up text-white fs-14"
              >
                <h4 class="primary-text mb-0">
                  {{ data.footer_link_one?.title }}
                </h4>
              </v-expansion-panel-title>
              <v-expansion-panel-text class="">
                <ul class="list-unstyled ps-0 fs-13">
                  <li
                    v-for="(link, label, i) in data.footer_link_one?.menu"
                    :key="i"
                    class="py-2"
                  >
                    <dynamic-link
                      :to="link"
                      append-class="text-reset"
                    >{{ label }}</dynamic-link>
                  </li>
                </ul>
              </v-expansion-panel-text>
            </v-expansion-panel>

            <v-expansion-panel class=" transparent text-white border-bottom border-gray-800 ">
              <v-expansion-panel-title
                class="px-0"
                expand-icon="las la-angle-down text-white fs-14"
                collapse-icon="las la-angle-up text-white fs-14"
              >
                <h4 class="primary-text mb-0">
                  {{ data.footer_link_two?.title }}
                </h4>
              </v-expansion-panel-title>
              <v-expansion-panel-text class="">
                <ul class="list-unstyled ps-0 fs-13">
                  <li
                    v-for="(link, label, i) in data.footer_link_two?.menu"
                    :key="i"
                    class="py-2"
                  >
                    <dynamic-link
                      :to="link"
                      append-class="text-reset"
                    >{{ label }}</dynamic-link>
                  </li>
                </ul>
              </v-expansion-panel-text>
            </v-expansion-panel>

            <v-expansion-panel class=" transparent text-white border-bottom border-gray-800 ">
              <v-expansion-panel-title
                class="px-0"
                expand-icon="las la-angle-down text-white fs-14"
                collapse-icon="las la-angle-up text-white fs-14"
              >
                <h4 class="primary-text mb-0">
                  {{ $t("contact_us") }}
                </h4>
              </v-expansion-panel-title>
              <v-expansion-panel-text class="">
                <ul class="list-unstyled ps-0 fs-13">
                  <li class="py-2 mb-2">
                    <div class="opacity-50">
                      <i class="las la-home me-3 mb-2"></i>
                      {{ $t("address") }}
                    </div>
                    <div> {{ data.contact_info?.contact_address}} </div>
                  </li>
                  <li class="py-2 mb-2">
                    <div class="opacity-50">
                      <i class=" las la-envelope me-3 mb-2 "></i>
                      {{ $t("email") }}
                    </div>
                    <div> {{ data.contact_info?.contact_email }} </div>
                  </li>
                  <li class="py-2 mb-2">
                    <div class="opacity-50">
                      <i class="las la-phone me-3 mb-2"></i>
                      {{ $t("phone") }}
                    </div>
                    <div> {{ data.contact_info?.contact_phone }} </div>
                  </li>
                </ul>
              </v-expansion-panel-text>
            </v-expansion-panel>
            <v-expansion-panel
              class="transparent text-white"
              v-if="app_store || play_store"
            >
              <v-expansion-panel-title
                class="px-0"
                expand-icon="las la-angle-down text-white fs-14"
                collapse-icon="las la-angle-up text-white fs-14"
              >
                <h4 class="primary-text mb-0"> {{ $t("mobile_apps") }} </h4>
              </v-expansion-panel-title>
              <v-expansion-panel-text class="">
                <a
                  :href="data.mobile_app_links?.play_store"
                  target="_blank"
                  class="d-inline-block pt-2"
                  v-if="play_store"
                >
                  <img
                    :src="static_asset('/assets/img/play_store.png')"
                    class="mw-100"
                    height="40"
                  />
                </a>
                <a
                  :href="data.mobile_app_links?.app_store"
                  target="_blank"
                  class="d-inline-block pt-2"
                  v-if="app_store"
                >
                  <img
                    :src="static_asset('/assets/img/app_store.png')"
                    class="mw-100"
                    height="40"
                  />
                </a>
              </v-expansion-panel-text>
            </v-expansion-panel>
            <v-expansion-panel
              class="transparent text-white border-top border-gray-800"
              v-if="is_addon_activated('multi_vendor')"
            >
              <v-expansion-panel-title
                class="px-0"
                expand-icon="las la-angle-down text-white fs-14"
                collapse-icon="las la-angle-up text-white fs-14"
              >
                <h4 class="primary-text mb-0"> {{ $t("seller_zone") }} </h4>
              </v-expansion-panel-title>
              <v-expansion-panel-text class="">
                <ul class="list-unstyled ps-0 fs-13">
                  <li class="py-2">
                    <router-link
                      :to="{ name: 'ShopRegistration' }"
                      class="text-reset"
                    >{{ $t('be_a_seller') }}</router-link>
                  </li>
                  <li class="py-2">
                    <a
                      :href="$store.getters['app/appUrl']+'/login'"
                      class="text-reset"
                      target="_blank"
                    >{{ $t('login_to_seller_panel') }}</a>
                  </li>
                </ul>
              </v-expansion-panel-text>

            </v-expansion-panel>
            <!-- Affiliate -->
            <v-expansion-panel
              class="transparent text-white"
              v-if="this.generalSettings.affiliate_system == 1 && this.isAuthenticated && !this.isAffiliatedUser"
            >
              <v-expansion-panel-title
                class="px-0"
                expand-icon="las la-angle-down text-white fs-14"
                collapse-icon="las la-angle-up text-white fs-14"
              >
                <h4 class="primary-text mb-0"> {{ $t("affiliate") }} </h4>
              </v-expansion-panel-title>
              <v-expansion-panel-text class="">

                <ul class="list-unstyled ps-0 fs-13">
                  <li class="py-2">
                    <router-link
                      :to="{ name: 'AffiliateRegistration' }"
                      class="text-reset"
                    >{{ $t('be_an_affiliate_partner') }}</router-link>
                  </li>
                </ul>
              </v-expansion-panel-text>
            </v-expansion-panel>
            <!--  -->
          </v-expansion-panels>
        </v-col>
      </v-row>
      <div class="py-3 border-top border-bottom border-gray-800">
        <ul class="list-unstyled d-flex flex-wrap ps-0">
          <li
            v-for="(link, label, i) in data.footer_menu"
            :key="i"
            :class="[ 'py-2 pe-4 pe-md-7', { 'ps-md-3 ps-md-7': i !== 0 }]"
          >
            <dynamic-link
              :to="link"
              append-class="text-reset"
            >{{ label }}</dynamic-link>
          </li>
        </ul>
      </div>
      <v-row class="py-5">
        <v-col
          md="6"
          cols="12"
          :version="data.current_version"
        >
          <div
            v-html="data.copyright_text"
            class="lh-4 fs-13"
          ></div>
        </v-col>
        <v-col
          md="6"
          cols="12"
        >
          <ul class=" list-unstyled d-flex justify-start justify-md-end mt-2 ps-0 ">
            <li
              v-for="(link, label, i) in data.social_link"
              :key="i"
              :class="['social-icon', { 'ms-2': i != 0 }]"
            >
              <a
                v-if="link"
                :href="link"
                :class="label"
                target="_blank"
              >
                <i :class="{ lab: true, ['la-' + label]: true, }"></i>
              </a>
            </li>
          </ul>
        </v-col>
      </v-row>
    </v-container>
  </footer>

  <!-- cookie dialog box -->
  <template  v-if="this.getCookieDescription">
  <div class="text-center pa-4 cookie">
    <!-- <v-btn @click="showCookie = true">
      Open Dialog
    </v-btn> -->

    <v-dialog
      v-model="showCookie"
      width="auto"
      class="cookie text-center"
    >
      <v-card
        max-width="400"
        prepend-icon="mdi-update"
        :text="this.getCookieDescription"
        :title=" this.getCookieTitle"
      >
        <template v-slot:actions>
          <v-btn
            class="text-none ms-auto text-white btn-primary"
            rounded="0"
            variant="flat"
            @click="setCookie(true)"
          >
            Accept Cookies
          </v-btn>
        </template>
      </v-card>
    </v-dialog>
  </div>
</template>
  <!--  -->
</template>

<script>
import { useVuelidate } from "@vuelidate/core";
import { email, required } from "@vuelidate/validators";
import { mapActions, mapGetters } from "vuex";
export default {
  data: () => ({
    loading: true,
    data: {},
    v$: useVuelidate(),
    subscribeForm: {
      email: "",
    },
    subscribeFormLoading: false,
    app_store: null,
    play_store: null,
    showCookie: false,
    dialog: true,
  }),

  validations() {
    return {
      subscribeForm: {
        email: {
          required,
          email,
        },
      },
    };
  },

  computed: {
    ...mapGetters("app", ["appName","generalSettings","getCookieStatus","getCookieTitle","getCookieDescription"]),
    ...mapGetters("auth", ["isAuthenticated"]),
    ...mapGetters("affiliate", ["isAffiliatedUser"]),
  },

  methods: {
    ...mapActions("affiliate", ["fetchAffiliatedUser"]),
    ...mapActions("app", ["setCookie"]),

    async setCookie(status) {

      document.cookie = this.appName +'-cookie' + "=" + this.getCookieDescription;
      localStorage.setItem("cookieStatus", status);
      this.showCookie = false;
    },

    async getDetails() {
      const res = await this.call_api("get", `setting/footer`);
      if (res.status === 200) {
        this.data = res.data;
        this.app_store = res.data.mobile_app_links.app_store;
        this.play_store = res.data.mobile_app_links.play_store;
        this.loading = false;
      }
    },

    async subscribe() {
      const isFormCorrect = await this.v$.$validate();
      if (!isFormCorrect) return;

      this.subscribeFormLoading = true;
      const res = await this.call_api("post", "subscribe", this.subscribeForm);
      this.snack({ message: res.data.message });
      this.subscribeFormLoading = false;
    },
  },


  created() {
    if (this.getCookieStatus == null) {
      this.showCookie = true;
    }
    this.getDetails();
    if (this.isAuthenticated) {
      this.fetchAffiliatedUser();
    }
  },

};
</script>


<style scoped>
.footer-background {
    position: relative;
    background-image: url('https://richman-official.com/wp-content/uploads/2024/01/Banner-2.webp?id=3172');
    background-size: cover;
    background-position: center;
}

.footer-background::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8); /* Dark overlay color with opacity */
    z-index: 1;
}

.footer-content {
    position: relative;
    z-index: 2; /* Ensure content appears above the overlay */
    color: #fff; /* Adjust the text color to ensure it's readable */
    padding: 20px; /* Adjust padding if necessary */
}
</style>
