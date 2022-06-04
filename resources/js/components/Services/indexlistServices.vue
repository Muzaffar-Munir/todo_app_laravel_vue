<template>
  <div>
    <div v-if="loader">
      <div class="spinner"></div>
    </div>
    <!-- section-top-->
    <section class="product-services-banner professional-banner">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h3>Listed Ads</h3>
          </div>
        </div>
      </div>
    </section>

    <!-- product and services services -->
    <section class="product-and-services">
      <div class="container">
        <div class="row mb-5 ps-row-1">
          <div class="col-12 col-sm-12 col-md-4 col-lg-4 ps-col">
            <div class="search-icon">
              <i class="fa fa-search" aria-hidden="true"></i>
              <input
                type="text"
                id="mySearch"
                @keyup.enter="search('title')"
                v-model="searchText.title"
                placeholder="Search from title"
              />
            </div>
            <transition name="fade">
              <p v-if="searchText.title" class="search-info pull-right">Press enter to search</p>
            </transition>
          </div>
          <div class="col-12 col-sm-12 col-md-4 col-lg-4 ps-col">
            <select class="select-options product-select" v-model="searchType">
              <option value>Filter Results By</option>
              <option value="sales_method">Sales Method</option>
            </select>
          </div>
          <div class="col-12 col-sm-12 col-md-4 col-lg-4 ps-col" v-if="searchType=='sales_method'">
            <transition name="fade" mode="in-out">
              <select
                class="select-options product-select"
                v-model="searchText.sales_method"
                @change="search('sales_method')"
              >
                <option value>Preffered Sales Method:</option>
                <option
                  v-for="(data, index) of sales_methods"
                  :key="index"
                  :value="data.id"
                >{{data.title}}</option>
              </select>
            </transition>
            <transition name="fade">
              <p class="search-info pull-right">Please change input to search</p>
            </transition>
          </div>
        </div>

        <div class="row ps-row" v-if="services && services.data && (current_user || admin_user)">
          <!-- starting loop -->
          <div
            class="col-12 col-sm-12 col-md-6 col-lg-4 ps-col"
            v-for="data in services.data"
            :key="data.id"
          >
            <div class="product-service-box professionals-boxes">
              <div class="grey-box"></div>
              <div class="image-1">
                <div class="client-sale-professional">
                  <img
                    :src="data.attachment ? '/images/services/'+data.attachment: '/images/avatar.png'"
                    alt="img"
                  />
                </div>
                <div class="client-professional-content">
                  <p
                    class="client-name"
                    v-if="data.title && data.title.length>16"
                  >{{ data.title.slice(0, 15)}}..</p>
                  <p class="client-name" v-if="data.title && data.title.length<=16">{{ data.title}}</p>
                  <p class="client-amount">{{data.price ? '$ '+data.price : ''}}</p>
                </div>
              </div>
              <div class="product-content professional-content">
                <h4>Description</h4>
                <p
                  v-if="data.description && data.description.length>170"
                  class="description"
                >{{ data.description.slice(0, 170)}}...</p>
                <p
                  v-if="data.description && data.description.length<=170"
                  class="description"
                >{{ data.description}}</p>
              </div>
              <router-link :to="{name:'indexViewService', params:{id:data.id}}">
                <button class="btn-block">Details</button>
              </router-link>
            </div>
          </div>
          <!-- ending loop -->
        </div>
        <div class="container-fluid" v-if="services">
          <div class="row">
            <div class="col-sm-3 offset-sm-2"></div>
            <div class="col-sm-4">
              <pagination :data="services" :limit="2" @pagination-change-page="getResults"></pagination>
            </div>
          </div>
        </div>
        <div v-else>No service exists</div>
        <!-- starting cliens if free subscribed -->
        <div class="row ps-row" v-if="!current_user && !admin_user">
          <!-- starting dummy section -->
          <div class="col-12 col-sm-12 col-md-6 col-lg-4 ps-col">
            <div class="product-service-box professionals-boxes">
              <div class="loading-img">
                <img class="img-fluid" src="../../../../public/assets/images/Box2.jpg" alt />
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-6 col-lg-4 ps-col">
            <div class="product-service-box professionals-boxes">
              <div class="loading-img">
                <img class="img-fluid" src="../../../../public/assets/images/Box2.jpg" alt />
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-6 col-lg-4 ps-col">
            <div class="product-service-box professionals-boxes">
              <div class="loading-img">
                <img class="img-fluid" src="../../../../public/assets/images/Box2.jpg" alt />
              </div>
            </div>
          </div>

          <!-- end dummy section -->
        </div>
        <!-- ending clients free subscriptions -->
      </div>
    </section>
    <!-- modal -->
    <div
      class="modal fade model-style"
      id="checkUser"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
      ref="checkUser"
    >
      <div class="pop-up-setting" style="display: flex; align-items: center;">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h6 v-if="!current_user && !admin_user">Please login to view this Page</h6>
            </div>
            <div class="modal-footer">
              <div class="view-btn view-delete">
                <button class="btn btn-home" type="button" @click.stop.prevent="closeModal()">Home</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ending modal -->
  </div>
</template>
<script>
import { getSalesmethods } from "../../utils/getDatabseData";
export default {
  mounted() {
    // Fetch initial results
    this.getResults();
  },
  data() {
    return {
      services: null,
      current_user: null,
      admin_user: null,
      loader: true,
      searchType: "",
      sales_methods: null,
      searchText: {
        title: null,
        sales_method: "",
      },
    };
  },
  methods: {
    async getResults(page = 1) {
      this.loader = true;
      // axios.get("example/results?page=" + page).then((response) => {
      //   this.laravelData = response.data;
      // });

      this.services = (
        await axios.get("/index.php/api/service?page=" + page)
      ).data;
      this.loader = false;
    },
    closeModal() {
      $("body").removeClass("modal-open");
      $(".fade").removeClass("modal-backdrop");
      $("body").css("padding-right", "0px");
      this.$router.push({ name: "home" });
    },
    // Call to action for checking which search type is triggred
    // filter for serach by Name
    async search(name) {
      this.loader = true;
      const searchObj = { [name]: this.searchText[name] };
      this.services = (
        await axios.post("/index.php/api/services/search", { text: searchObj })
      ).data;
      this.loader = false;
    },
  },
  async created() {
    // this.services = (await axios.get("/index.php/api/service")).data;
    this.sales_methods = (await getSalesmethods()).data;
    if (localStorage.getItem("current_user")) {
      this.current_user = JSON.parse(localStorage.getItem("current_user"));
    }
    if (localStorage.getItem("admin_user")) {
      this.admin_user = JSON.parse(localStorage.getItem("admin_user"));
    }
    if (!this.current_user && !this.admin_user) {
      $("#checkUser").modal("show");
    }

    setTimeout(() => {
      this.loader = false;
    }, 1000);
  },
};
</script>
<style>
.description {
  word-wrap: break-word;
}
</style>