<template>
  <div>
    <!-- section-top-->
    <section class="product-services-banner professional-banner">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h3>Explore Businessess</h3>
          </div>
        </div>
      </div>
    </section>
    <!-- product and services services -->
    <section class="product-and-services">
      <div class="container">
        <div class="row mb-5 ps-row-1">
          <div class="col-12 col-sm-12 col-md-4 ps-col">
            <div class="search-icon">
              <i class="fa fa-search" aria-hidden="true"></i>
              <input
                type="text"
                id="mySearch"
                v-model="searchText.name"
                @keyup.enter="search('name')"
                placeholder="Search by name"
              />
            </div>
            <transition name="fade">
              <p v-if="searchText.name" class="search-info pull-right">Press enter to search</p>
            </transition>
          </div>

          <div class="col-12 col-sm-12 col-md-4 col-lg-4 ps-col">
            <select class="select-options product-select" v-model="searchType">
              <option value>Filter Results By</option>
              <option value="location">Location</option>
              <option value="email">Email</option>
              <option value="sales_method">Sales method</option>
            </select>
          </div>
          <div class="col-12 col-sm-12 col-md-4 col-lg-4 ps-col" v-if="searchType=='location'">
            <transition name="fade" mode="in-out">
              <select
                class="registration-select freelaning-select"
                v-model="searchText.location"
                @change="search('location')"
              >
                <option value>Enter Target Location</option>
                <option value="suburb">Suburb</option>
                <option value="state">State</option>
                <option value="country">Country</option>
                <option value="none">None</option>
              </select>
            </transition>
            <transition name="fade">
              <p class="search-info pull-right">Press change input to search</p>
            </transition>
          </div>
          <div class="col-12 col-sm-12 col-md-4 col-lg-4 ps-col" v-if="searchType=='email'">
            <transition name="fade" mode="in-out">
              <div class="search-icon">
                <i class="fa fa-search" aria-hidden="true"></i>
                <input
                  type="email"
                  id="mySearch"
                  v-model="searchText.email"
                  @keyup.enter="search('email')"
                  placeholder="Search by email"
                />
              </div>
            </transition>
            <transition name="fade">
              <p v-if="searchText.email" class="search-info pull-right">Press enter to search</p>
            </transition>
          </div>

          <div class="col-12 col-sm-12 col-md-4 col-lg-4 ps-col" v-if="searchType=='sales_method'">
            <transition name="fade" mode="in-out">
              <select
                class="registration-select freelaning-select"
                v-model="searchText.sales_method"
                @change="search('sales_method')"
              >
                <option value selected>Preffered Sales Method:</option>
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
        <div v-if="loader">
          <div class="spinner"></div>
        </div>
        <div class="row ps-row" v-if="clients && clients.data.length">
          <div
            class="col-12 col-sm-12 col-md-6 col-lg-4 ps-col"
            v-for="data in clients.data"
            :key="data.id"
          >
            <div class="product-service-box" v-if="data.client">
              <div class="grey-box"></div>
              <img
                class="services-img"
                :src=" data.profile_picture ? '/images/users/'+data.profile_picture :'/images/avatar.png'"
                alt="img"
              />

              <div class="product-content">
                <h4>{{ data.full_name ? data.full_name:'' }}</h4>
                <p>{{ data.client.business_name ? data.client.business_name:'' }}</p>
              </div>
              <span
                v-if="user && user.role=='freelancer' && (!subscriptions || !subscriptions.includes(data.client.id))"
              >
                <form @submit.stop.prevent="subscribe(data.client.id)">
                  <button type="submit" class="btn-block">SUBSCRIBE</button>
                </form>
              </span>
              <span
                v-if="user && user.role=='freelancer' && (subscriptions && subscriptions.includes(data.client.id))"
              >
                <button class="subscribed-btn">SUBSCRIBED</button>
              </span>
            </div>
          </div>
        </div>
        <div v-if="!clients || !clients.data.length" class="row">
          <div class="product-content col-md-12 ml-4">
            <p>No company exists</p>
          </div>
        </div>
        <div class="container-fluid" v-if="clients">
          <div class="row">
            <div class="col-sm-3 offset-sm-2"></div>
            <div class="col-sm-4">
              <pagination :data="clients" :limit="2" @pagination-change-page="getResults"></pagination>
            </div>
          </div>
        </div>
      </div>
      <!-- modal -->
      <div
        class="modal fade model-style"
        id="exampleModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div class="pop-up-setting" style="display: flex; align-items: center;">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p v-if="user && user.role!='client'">You have Successfully subscribed this Company</p>
                <p v-if="is_client">Company can't subscribe other Company</p>
                <p v-if="!user">Please Login to SUBSCRIBE</p>
              </div>
              <div class="modal-footer">
                <div class="view-btn view-delete">
                  <button class="edit" @click.stop.prevent="closeModal()" v-if="!user">Login</button>
                  <button class="delete" data-dismiss="modal">CLOSE</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- ending modal -->
    </section>
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
      is_client: null,
      clients: null,
      user: null,
      loader: true,
      subscriptions: null,
      searchType: "",
      sales_methods: null,
      searchText: {
        name: null,
        sales_method: "",
        email: null,
        location: "",
      },
    };
  },
  methods: {
    async getResults(page = 1) {
      this.loader = true;
      this.clients = (
        await axios.get("/index.php/api/client?page=" + page)
      ).data;
      this.loader = false;
    },
    // Call to action for checking which search type is triggred
    // filter for serach by Name
    async search(name) {
      this.loader = true;
      const searchObj = { [name]: this.searchText[name] };
      this.clients = (
        await axios.post("/index.php/api/client/search", { text: searchObj })
      ).data;
      this.loader = false;
    },
    async subscribe(client) {
      let openmodel = false;
      if (this.user && this.user.role == "freelancer") {
        const postData = { user_id: this.user.id, client_id: client };
        await axios.post("/index.php/api/user_subscribe_client", postData);
        await axios
          .get("/index.php/api/user/" + this.user.id + "?subscriptions=true")
          .then((response) => {
            if (response.status && response.status == 200) {
              openmodel = true;
              this.subscriptions = response.data;
            }
          })
          .catch((error) => {
            console.log(error);
          });
        if (openmodel) {
          $("#exampleModal").modal("show");
        }

        this.subscriptions = this.subscriptions.map((obj) => {
          return obj.client_id;
        });
      } else if (this.user && this.user.role == "freelancer") {
        this.is_client = true;
        $("#exampleModal").modal("show");
      } else {
        $("#exampleModal").modal("show");
      }
    },
    closeModal() {
      $("body").removeClass("modal-open");
      $(".fade").removeClass("modal-backdrop");
      $("body").css("padding-right", "0px");
      this.$router.push({ name: "home" });
    },
  },
  async created() {
    // this.clients = (await axios.get("/index.php/api/client")).data;
    // this.user = (await axios.get("/index.php/user")).data;
    this.sales_methods = (await getSalesmethods()).data;
    if (localStorage.getItem("current_user")) {
      this.user = JSON.parse(localStorage.getItem("current_user")).user;
    }
    if (this.user && this.user.role == "freelancer") {
      this.subscriptions = (
        await axios.get(
          "/index.php/api/user/" + this.user.id + "?subscriptions=true"
        )
      ).data;
      if (this.subscriptions) {
        this.subscriptions = this.subscriptions.map((obj) => {
          return obj.client_id;
        });
      }
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