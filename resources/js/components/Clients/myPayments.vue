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

              <div class="container">
                <div class="row">
                  <div class="col-md-12">
                    <div class="new-btn">
                      <h5>Your Payments</h5>
                    </div>
                  </div>
                </div>

                <div v-if="loader">
                  <div class="spinner"></div>
                </div>
                <div v-if="payments && payments.length">
                  <div
                    class="row manage-ads-row mb-4"
                    v-for="payment in payments"
                    :key="payment.id"
                  >
                    <div class="col-md-9 main-text manage-ads-main-text">
                      <div class="text">
                        <strong>Started from:</strong>
                        <span v-if="payment.start_date">{{payment.start_date }}</span>
                      </div>
                      <div class="text">
                        <strong>Ended on:</strong>
                        <span v-if="payment.end_date">{{payment.end_date }}</span>
                      </div>
                      <!-- <div class="text">
                        <strong>Status:</strong>
                        <span v-if="payment.status">{{ payment.status }}</span>
                      </div>-->

                      <div class="text">
                        <strong>Amount:</strong>
                        {{ payment.total ? payment.total: '' }}
                      </div>
                    </div>
                    <div class="col-md-3 link-img">
                      <a :href="payment.pdf_link" target="#">
                        <img src="../../../../public/assets/images/Untitled-1_03.jpg" />
                      </a>
                    </div>
                  </div>
                </div>
                <div v-else>
                  <div class="row manage-ads-row mb-4">
                    <div class="col-md-9 main-text manage-ads-main-text">
                      <div class="text">You don't have created any payment</div>
                    </div>
                  </div>
                </div>
              </div>
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
      payments: null,
      user: null,
      loader: true,
    };
  },
  async created() {
    if (localStorage.getItem("current_user")) {
      this.user = JSON.parse(localStorage.getItem("current_user")).user;
      this.payments = (
        await axios.post("/index.php/api/clients/payments", {
          user_id: this.user.id,
        })
      ).data;
      console.log(this.payments);
    }

    setTimeout(() => {
      this.loader = false;
    }, 1000);
  },
};
</script>