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
            <h3>Meet the Sales Professionals!</h3>
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
                v-model="searchText.name"
                placeholder="Search"
                @keyup.enter="search('name')"
              />
            </div>
            <transition name="fade">
              <p v-if="searchText.name" class="search-info pull-right">Press enter to search</p>
            </transition>
          </div>
          <div class="col-12 col-sm-12 col-md-4 col-lg-4 ps-col">
            <select class="select-options product-select" v-model="searchType">
              <option value>Filter Results By</option>
              <!-- <option value="location">Location</option> -->
              <option value="sales_method">Sales method</option>
              <option value="industry">Industries</option>
            </select>
          </div>
          <div class="col-12 col-sm-12 col-md-4 col-lg-4 ps-col" v-if="searchType=='sales_method'">
            <transition name="fade" mode="in-out">
              <select
                class="registration-select freelaning-select"
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
          <div class="col-12 col-sm-12 col-md-4 col-lg-4 ps-col" v-if="searchType=='industry'">
            <transition name="fade" mode="in-out">
              <select
                class="registration-select freelaning-select"
                v-model="searchText.industry"
                @change="search('industry')"
              >
                <option value>Prefered Industry</option>
                <option
                  v-for="(data, index) of industries"
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

        <div
          class="row ps-row"
          v-if="freelancers && freelancers.data && (admin_user || (current_user && current_user.user.role=='client' && current_user.client.subscription_type==2) )"
        >
          <!-- start loop -->
          <div
            class="col-12 col-sm-12 col-md-6 col-lg-4 ps-col"
            v-for="data in freelancers.data"
            :key="data.id"
          >
            <div class="product-service-box professionals-boxes" v-if="data.freelancer">
              <div class="grey-box"></div>

              <div class="image-1">
                <div class="client-sale-professional">
                  <img
                    class
                    :src=" data && data.profile_picture ? '/images/users/'+data.profile_picture :'/images/avatar.png'"
                  />
                </div>
                <div class="client-professional-content">
                  <p
                    class="client-name"
                    v-if="data && data.full_name && data.full_name.length>16"
                  >{{ data.full_name.slice(0, 16)}}...</p>
                  <p
                    class="client-name"
                    v-if="data.full_name && data.full_name.length<=16"
                  >{{ data.full_name}}</p>
                  <p class="client-amount">{{data.freelancer.price ? '$ '+data.freelancer.price:''}}</p>
                </div>
              </div>
              <div class="product-content professional-content">
                <h4>Description</h4>
                <p
                  v-if="data.freelancer && data.freelancer.ddescription && data.freelancer.description.length>170"
                >{{ data.freelancer.description.slice(0, 170)}}...</p>
                <p
                  v-if="data.freelancer.description && data.freelancer.description.length<=170"
                >{{ data.freelancer.description}}</p>
              </div>

              <router-link :to="{name:'userProfile', params:{id:data.freelancer.id}}">
                <button class="btn-block" style="text-decoration: none">View Profile</button>
              </router-link>
            </div>
          </div>
          <!-- end of loop -->
          <div
            class="container-fluid"
            v-if="freelancers && freelancers.data && freelancers.data.length"
          >
            <div class="row">
              <div class="col-sm-3 offset-sm-2"></div>
              <div class="col-sm-4">
                <pagination :data="freelancers" :limit="2" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
          </div>
        </div>

        <div v-if="(!freelancers || !freelancers.data || !freelancers.data.length) " class="row">
          <div class="product-content col-md-12 ml-4">
            <p>No freelancers exists</p>
          </div>
        </div>

        <!-- starting cliens if free subscribed -->
        <div
          class="row ps-row"
          v-if="(current_user && current_user.user &&( current_user.user.role=='client' && current_user.client && (current_user.client.subscription_type==0 || current_user.client.subscription_type==1))) || (!current_user && !admin_user) "
        >
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
        <!-- starting freelancer if view this page -->
        <div
          class="row ps-row"
          v-if="current_user && current_user.user && current_user.user.role=='freelancer' "
        >
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
        <!-- ending freelancer if view this page -->
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
              <h6 v-if="!current_user">Please login to view Freelancers</h6>
              <h6
                v-if="this.current_user && this.current_user.user.role == 'freelancer'"
              >You need to be a company to view this page</h6>
              <h6
                v-if="current_user && current_user.user.role=='client' && current_user.client.subscription_type!=2"
              >Please update your subscription plan to view Freelancers</h6>
            </div>
            <div class="modal-footer">
              <div class="view-btn view-delete" v-if="!current_user">
                <button class="edit" @click.stop.prevent="closeModal()">Login</button>
                <button class="delete" @click.stop.prevent="closeModal()">CLOSE</button>
              </div>
              <div class="view-btn view-delete" v-if="current_user && !current_user.client">
                <button class="btn btn-home" type="button" @click.stop.prevent="closeModal()">Home</button>
              </div>
              <div
                class="view-btn view-delete"
                v-if="current_user && current_user.user.role=='client' && current_user.client.subscription_type!=2"
              >
                <button class="edit" @click.stop.prevent="updatePlan()">Update</button>
                <button class="delete" @click.stop.prevent="closeModal()">Home</button>
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
import { getSalesmethods, getIndustries } from "../../utils/getDatabseData";
export default {
  data() {
    return {
      loader: true,
      sales_methods: null,
      industries: null,
      freelancers: null,
      current_user: null,
      admin_user: null,
      searchType: "",
      searchText: {
        name: null,
        sales_method: "",
        industry: "",
      },
    };
  },
  mounted() {
    // Fetch initial results
    this.getResults();
  },
  methods: {
    async getResults(page = 1) {
      this.loader = true;
      // axios.get("example/results?page=" + page).then((response) => {
      //   this.laravelData = response.data;
      // });
      this.freelancers = (
        await axios.get("/index.php/api/freelancer?page=" + page)
      ).data;
      this.loader = false;
    },
    closeModal() {
      $("body").removeClass("modal-open");
      $(".fade").removeClass("modal-backdrop");
      $("body").css("padding-right", "0px");
      this.$router.push({ name: "home" });
    },
    updatePlan() {
      $("body").removeClass("modal-open");
      $(".fade").removeClass("modal-backdrop");
      $("body").css("padding-right", "0px");
      this.$router.push({ name: "subscriptionPlans" });
    },
    // Call to action for checking which search type is triggred
    // filter for serach by
    async search(name) {
      this.loader = true;
      const searchObj = { [name]: this.searchText[name] };
      this.freelancers = (
        await axios.post("/index.php/api/freelancers/search", {
          text: searchObj,
        })
      ).data;
      this.loader = false;
    },
  },
  async created() {
    this.industries = (await getIndustries()).data;
    this.sales_methods = (await getSalesmethods()).data;
    if (localStorage.getItem("current_user")) {
      this.current_user = JSON.parse(localStorage.getItem("current_user"));
      // console.log(this.user.client);
    }
    if (localStorage.getItem("admin_user")) {
      this.admin_user = JSON.parse(localStorage.getItem("admin_user"));
    }

    if (
      this.current_user &&
      this.current_user.user.role == "client" &&
      this.current_user.client.subscription_type != 2
    ) {
      $("#checkUser").modal("show");
    }
    if (!this.current_user && !this.admin_user) {
      $("#checkUser").modal("show");
    }
    if (this.current_user && this.current_user.user.role == "freelancer") {
      $("#checkUser").modal("show");
    }
    this.loader = false;
  },
};
</script>
<style scoped>
.freelaning-select {
  padding: 3px 7px 7px 7px;
}
</style>