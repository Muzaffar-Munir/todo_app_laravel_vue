<template>
  <div>
    <div v-if="loader">
      <div class="spinner"></div>
    </div>
    <!-- section-top-->
    <section class="create-account-banner">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h3>Dashboard</h3>
          </div>
        </div>
      </div>
    </section>

    <section class="create-account">
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 tab-responsive">
            <dashboard-nav-component></dashboard-nav-component>
          </div>

          <div class="col-12 col-sm-12 col-md-8 col-lg-9 col-xl-9">
            <div id="update" class="tabcontent" style="display:block">
              <div class="create-account-content"></div>
              <h5>Your Subscribed Companies.</h5>
              <section class="manage-subscription">
                <div class="container">
                  <div v-if="subscriptions && subscriptions.data">
                    <div
                      class="row manage-subscription-row mb-4"
                      v-for="subscription in subscriptions.data"
                      :key="subscription.id"
                    >
                      <div class="col-md-9 main-text manage-ads-main-text">
                        <div class="text">
                          <strong>Client:</strong>
                          <span
                            v-if="subscription.client && subscription.client.user"
                          >{{ subscription.client.user.first_name }} {{ subscription.client.user.last_name }}</span>
                        </div>
                        <div class="text">
                          <strong>Comapny</strong>
                          <span
                            v-if="subscription.client"
                          >{{ subscription.client.business_name ? subscription.client.business_name:'' }}</span>
                        </div>

                        <div class="text">
                          <img
                            :src="subscription.client && subscription.client.user &&  subscription.client.user.profile_picture ? '/images/users/'+subscription.client.user.profile_picture: '/images/avatar.png'"
                          />
                        </div>
                      </div>
                      <div class="col-md-3 link-img">
                        <a href="#" data-toggle="modal" data-target="#exampleModal">
                          <img src="../../../../public/assets/images/Untitled-1_05.jpg" />
                        </a>
                      </div>
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
                                <button
                                  type="button"
                                  class="close"
                                  data-dismiss="modal"
                                  aria-label="Close"
                                >
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <p>Do you really want to delete this item?</p>
                                <div class="view-btn view-delete">
                                  <button
                                    class="edit"
                                    @click.stop.prevent="deleteSubscription(subscription.id)"
                                  >YES</button>
                                  <button class="delete" data-dismiss="modal">NO</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="container-fluid" v-if="subscriptions">
                      <div class="row">
                        <div class="col-sm-3 offset-sm-2"></div>
                        <div class="col-sm-4">
                          <pagination
                            :data="subscriptions"
                            :limit="2"
                            @pagination-change-page="getResults"
                          ></pagination>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div v-else>
                    <div class="row manage-ads-row mb-4">
                      <div class="col-md-9 main-text manage-ads-main-text">
                        <div class="text">You don't have subscribed any comapny</div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import dashboardNavComponent from "./dashboardNav";
export default {
  components: {
    dashboardNavComponent,
  },
  mounted() {
    // Fetch initial results
    this.getResults();
  },
  data() {
    return {
      subscriptions: null,
      loader: true,
      freelancer: null,
    };
  },
  methods: {
    async getResults(page = 1) {
      this.loader = true;
      this.subscriptions = (
        await axios.get(
          "/api/user_subscribe_client?page=" +
            page +
            "&freelancer=" +
            this.freelancer.id
        )
      ).data;
      this.loader = false;
    },
    async deleteSubscription(id) {
      this.loader = true;

      axios
        .delete("/index.php/api/user_subscribe_client/" + id)
        .then((response) => {
          if (response.status && response.status == 200) {
            axios
              .get("/index.php/api/user_subscribe_client")
              .then((response) => {
                if (response.status && response.status == 200) {
                  this.subscriptions = response.data;
                  $("body").removeClass("modal-open");
                  $(".fade").removeClass("modal-backdrop");
                  $("body").css("padding-right", "0px");
                  this.loader = false;
                }
              })
              .catch((error) => {
                this.loader = false;
              })
              .then(() => {
                this.loader = false;
              });
          }
        })
        .catch((error) => {
          this.loader = false;
        })
        .then(() => {
          this.loader = false;
        });
    },
  },
  async created() {
    // this.subscriptions = (await axios.get("/api/user_subscribe_client")).data;
    if (localStorage.getItem("current_user")) {
      this.freelancer = (JSON.parse(
        localStorage.getItem("current_user")
      )).freelancer;
      console.log(this.freelancer);
    }
    this.loader = false;
  },
};
</script>