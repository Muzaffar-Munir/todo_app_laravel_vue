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
              <section class="manage-ad">
                <div class="container">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="new-btn">
                        <h5 v-if="!id">Please fill out the form to publish an ad.</h5>
                        <h5 v-if="id">Please fill out the form to update an ad.</h5>
                        <router-link :to="{ name:'clientListServices' }">
                          <button class="back">BACK</button>
                        </router-link>
                      </div>
                    </div>
                  </div>
                  <div class="row d-flex justify-content-center">
                    <div class="col-md-12 col-lg-12">
                      <create-client-service-component
                        :type="'update'"
                        :id="id"
                        :data="service"
                        v-if="service"
                        :user="user"
                      ></create-client-service-component>
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
import createClientServiceComponent from "./../Services/createClientService";
import dashboardNavComponent from "./dashboardNav";
export default {
  components: {
    dashboardNavComponent,
    createClientServiceComponent,
  },
  data() {
    return {
      user: null,
      service: null,
      id: null,
      loader: true,
    };
  },
  async created() {
    this.id = this.$route.params.id;
    this.service = (await axios.get("/api/service/" + this.id)).data;
    if (this.$route.params.user) {
      this.user = this.$route.params.user;
    } else {
      this.user = (await axios.get("/index.php/user")).data;
    }
    setTimeout(() => {
      this.loader = false;
    }, 1000);
  },
};
</script>
