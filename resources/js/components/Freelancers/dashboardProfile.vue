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
            <div id="update" class="tabcontent profile-tabs" style="display:block">
              <div class="create-account-content"></div>
              <view-profile-component :id="user.id" :userObj="userObj"></view-profile-component>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import dashboardNavComponent from "./dashboardNav";
import viewProfileComponent from "./viewProfile";
export default {
  components: {
    dashboardNavComponent,
    viewProfileComponent,
  },
  data() {
    return {
      loader: true,
      userObj: null,
      user: null,
    };
  },
  created() {
    if (localStorage.getItem("current_user")) {
      this.user = JSON.parse(localStorage.getItem("current_user")).user;
      this.userObj = JSON.parse(localStorage.getItem("current_user"));
      console.log(this.userObj);
      setTimeout(() => {
        this.loader = false;
      }, 1000);
    }
  },
};
</script>