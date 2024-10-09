<template>
  <header class="shadow header-background" :class="['header-sticky', { 'sticky-top': generalSettings.sticky_header == 1 }] ">
    <TopBar
      :loading="loading"
      :data="data"
    />
    <LogoBar
      :loading="loading"
      :data="data"
    />
    <HeaderMenu
      :loading="loading"
      :data="data"
      class="d-none d-md-block"
    />
  </header>
</template>

<!--<style scoped>-->
<!--.header-background {-->
<!--    background-image: url('https://richman-official.com/wp-content/uploads/2024/01/sm-w-bg-1.jpg');-->
<!--    background-size: cover;-->
<!--    background-position: center;-->
<!--}-->
<!--</style>-->

<script>
import { mapGetters } from "vuex";
import HeaderMenu from "./HeaderMenu.vue";
import LogoBar from "./LogoBar.vue";
import TopBar from "./TopBar.vue";
export default {
  data: () => ({
    loading: true,
    data: {},
  }),
  components: {
    TopBar,
    LogoBar,
    HeaderMenu,
  },
  computed: {
    ...mapGetters("app", ["generalSettings"]),
  },
  methods: {
    async getDetails() {
      const res = await this.call_api("get", `setting/header`);

      if (res.status === 200) {
        this.data = res.data;
        this.loading = false;
      }
    },
  },
  created() {
    this.getDetails();
  },
};
</script>
