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

              <div class="new-btn">
                <h5>Manage Your Subscription</h5>
                <router-link :to="{name:'subscriptionPlans'}">
                  <button class="back">Update</button>
                </router-link>
              </div>
              <!-- Starting Content -->
              <div class="container">
                <!-- main content section-->
                <div class="row manage-ads-row mb-4">
                  <div class="col-md-9 main-text manage-ads-main-text flex">
                    <span
                      class="flex"
                      v-if="client.subscription_type && client.subscription_type=='0'"
                    >
                      <div class="text mr-5">
                        <strong>Title:</strong> COVID RELIEF OFFER
                      </div>
                      <div class="text mr-5">
                        <strong>Duration:</strong> 5M 25D 15H 30M
                      </div>
                      <div class="text">
                        <strong>Price:</strong>
                        $ 0
                      </div>
                    </span>
                    <span
                      class="flex"
                      v-if="client.subscription_type && client.subscription_type=='1'"
                    >
                      <div class="text mr-5">
                        <strong>Title:</strong> 30 DAYS SUBSCRIPTION
                      </div>
                      <div class="text mr-5">
                        <strong>Duration:</strong> 30 Days
                      </div>
                      <div class="text">
                        <strong>Price:</strong>
                        $ 299
                      </div>
                    </span>
                    <span
                      class="flex"
                      v-if="client.subscription_type && client.subscription_type=='2'"
                    >
                      <div class="text mr-5">
                        <strong>Title:</strong> 12 MONTHS SUBSCRIPTION
                      </div>
                      <div class="text mr-5">
                        <strong>Duration:</strong> 12 Months
                      </div>
                      <div class="text">
                        <strong>Price:</strong>
                        $ 2,499
                      </div>
                    </span>
                    <span
                      class="flex"
                      v-if="client.subscription_type && (client.subscription_type=='5' || client.subscription_type=='10')"
                    >
                      <div class="text mr-5">
                      Your Subscription is expired please update your subscription
                      </div>
                      
                    </span>
                  </div>
                </div>
                <!-- ending main content  -->
              </div>
              <!-- ending Content -->
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
  data() {
    return {
      loader: true,
      client: null,
    };
  },
  created() {
    if (localStorage.getItem("current_user")) {
      this.client = JSON.parse(localStorage.getItem("current_user")).client;
    }
    setTimeout(() => {
      this.loader = false;
    }, 1000);
  },
};
</script>
<style scoped>
.flex {
  display: flex;
  justify-content: space-around;
}
</style>