<template>
  <div>
    <!-- nav -->
    <div class="container responsive-container">
      <nav class="navbar navbar-expand-lg navbar-light">
        <router-link :to="{name:'home'}" class="navbar-brand nav-image">
          <img src="../../../../public/assets/images/logo-nav.png" />
        </router-link>
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarText"
          aria-controls="navbarText"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse nav-padding" id="navbarText">
          <ul class="navbar-nav">
            <li class="nav-item">
              <router-link :to="{name:'listFreelancers'}" class="nav-link">Freelancing</router-link>
            </li>
            <li class="nav-item">
              <router-link :to="{name:'indexListClients'}" class="nav-link">Companies</router-link>
            </li>
            <li class="nav-item">
              <router-link :to="{name:'services'}" class="nav-link">Services</router-link>
            </li>
            <li class="nav-item">
              <router-link :to="{name:'contactUs'}" class="nav-link">Contact</router-link>
            </li>
            <li class="nav-item" v-if="current_user">
              <span v-if="current_user.client">
                <router-link :to="{name:'create-service'}" class="nav-link">Dashboard</router-link>
              </span>
              <span v-if="current_user.freelancer">
                <router-link :to="{name:'freelance-profile'}" class="nav-link">Dashboard</router-link>
              </span>
              <!--  -->
            </li>
            <li class="nav-item" v-if="admin_user">
              <router-link :to="{name:'admin-listed-services'}" class="nav-link">Dashboard</router-link>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </div>
</template>
<script>
import { isLoggedIn, userRole } from "../../utils/auth";
export default {
  data() {
    return {
      current_user: null,
      admin_user: null,
    };
  },
  watch: {
    $route() {
      $("#navbarText").collapse("hide");
    },
  },
  created() {
    if (!this.current_user) {
      setInterval(() => {
        if (localStorage.getItem("current_user")) {
          this.current_user = JSON.parse(localStorage.getItem("current_user"));
        } else {
          this.current_user = null;
        }
      }, 1000);
    }
    if (!this.admin_user) {
      setInterval(() => {
        if (localStorage.getItem("admin_user")) {
          this.admin_user = JSON.parse(localStorage.getItem("admin_user"));
        } else {
          this.admin_user = null;
        }
      }, 1000);
    }
  },
};
</script>
<style scoped>
.nav-item .router-link-exact-active {
  color: var(--cyan-light) !important;
  transition: 0.3s;
  border-bottom: 3px solid #5cc9be;
}
</style>